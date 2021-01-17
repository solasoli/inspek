<style>
  .conditional_part {
    display: none;
  }
</style>
<script>
  let option_opd = [];
  $(function() {
    var id_kegiatan = 0;
    
    function get_sasaran(id) {
      $("#cover-sasaran_edit").html('');
      $.get("{{url('')}}/mst/sasaran/get_sasaran_by_id_program_kerja?id=" + id, function(data) {
        // console.log(data);
        if (id > 0) {
          $.each(data, function(idx, val) {
            var r = "<tr>";
            r += "<td>";
            r += "<input name='sasaran[]' value='" + val.nama + "' autocomplete='off' required='required' class='form-control' type='text'>";
            r += "</td>";
            r += "<td>";
            r += "<button type='button' class='btn btn-danger btn-xs remove-sasaran'><i class='fa fa-close'></i></button>";
            r += "</td>";
            r += "</tr>";
            $("#cover-sasaran_edit").append(r);
          });
        } else {
          $("#cover-sasaran_edit").html('');
        }

      });
    }

    $('#modal-form').on('show.bs.modal', async function(e) {
      var id = $(e.relatedTarget).data('id');
      id_kegiatan = $(e.relatedTarget).data('kegiatan');
      $('.adding-irban').html('')
      $('.cover-opd').html('')
      // get_sasaran(id);

      $("select[name='wilayah']").val('').trigger('change');
      $("select[name='opd']").html(''); // api na benang , kakara di clir
      $("#select-irban").val(0) 

      if (id > 0) { // form edit
        var data = {}
        await $.get("{{url('')}}/mst/program_kerja/get_program_kerja_by_id?id=" + id, function(res) {
          data = res
        })
        // console.log(data);
        // $('input[name="sub_kegiatan"]').val(data.sub_kegiatan);
        // $('select[name="wilayah"]').val(data.id_wilayah).trigger("change.select2");
        // $('select[name="opd"]').val(data.id_skpd).trigger("change");
        // get_pd(data.id_skpd);
        var checked = data.is_lintas_irban == 1 ? true : false;
        $("#lintas").prop('checked', checked)

        // set first irban
        if(data.wilayah.length > 0) {
          const first_irban = data.wilayah[0]
          $("#select-irban").val(first_irban.id).trigger('change')

          // after first irban
          for(var ii = 1; ii < data.wilayah.length; ii++) {
            addingIrbanSelection()
            $(".adding-irban select:last").val(data.wilayah[ii].id).trigger('change')
          }
        }
        await lintasIrbanHandler()

        // set OPD
        
        if(data.skpd.length > 0 && data.is_all_opd == false) {
          for(var is = 0; is < data.skpd.length; is++) {
            addingSkpdSelection()
            $(".cover-opd select:last").val(data.skpd[is].id).trigger('change')
          }
        }

        $("#all_opd").prop('checked', data.is_all_opd)
        
        // set Jenis Pengawasan
        if(data.jenis_pengawasan.length > 0) {
          const first_jenis_pengawasan = data.jenis_pengawasan[0]
          $("#jenis_pengawasan").val(first_jenis_pengawasan.id).trigger('change')

          // after first irban
          for(var ii = 1; ii < data.jenis_pengawasan.length; ii++) {
            addingJenisPengawasan()
            $(".cover-jenis-pengawasan select:last").val(data.jenis_pengawasan[ii].id).trigger('change')
          }
        }

        $("select[name='kegiatan']").val(data.id_kegiatan).trigger('change');
        $("select[name='jenis_pengawasan']").val(data.id_jenis_pengawasan).trigger('change');
        $('input[name="dari"]').val(moment(new Date(data.dari)).format("DD-MM-YYYY"));
        $('input[name="sampai"]').val(moment(new Date(data.sampai)).format("DD-MM-YYYY"));
        $('input[name="jml_wakil_penanggung_jawab"]').val(data.jml_wakil_penanggung_jawab);
        $('input[name="jml_pengendali_teknis"]').val(data.jml_pengendali_teknis);
        $('input[name="jml_ketua_tim"]').val(data.jml_ketua_tim);
        $('input[name="jml_anggota"]').val(data.jml_anggota);
        $('textarea[name="sasaran"]').val(data.sasaran);
        // $('input[name="anggaran"]').autoNumeric('set', data.anggaran);

        count_man_power();

        $("#form-program_kerja").attr('action', '{{url()->current()}}/edit/' + id + '');
      } else {

        $("#form-program_kerja").attr('action', '{{url()->current()}}/add');
      }

      $('#form-program_kerja').on('submit', function(e) {
        e.preventDefault();
        $('.error').html('');
        $.ajax({
          url: $(this).attr('action'),
          method: $(this).attr('method'),
          data: $(this).serialize(),
          dataType: 'json',
          success(response) {
            window.location.href = '{{url()->current()}}';
          },
          error(error) {
            let errors = error.responseJSON.errors;
            for (let key in errors) {
              let errorDiv = $(`.error[data-error="${key}"]`);
              if (errorDiv.length) {
                errorDiv.text(errors[key][0]);
              }
            }
          }
        });
      });

    });


    $(".add-sasaran").on('click', function() {
      var am = "<tr>";
      am += "<td>";
      am += "<input name='sasaran[]' autocomplete='off' required='required' class='form-control' type='text'>";
      am += "</td>";
      am += "<td>";
      am += "<button type='button' class='btn btn-danger btn-xs remove-sasaran'><i class='fa fa-close'></i></button>";
      am += "</td>";
      am += "</tr>";
      $("#cover-sasaran_edit").append(am);
    });

    $('.fc-datepicker').datepicker({
      dateFormat: "dd-mm-yy"
    });


    $(document).on('click', ".remove-sasaran", function() {
      $(this).parent().closest("tr").remove();
    });

    var irban_option = [];
    var ketua_tim_option = [];
    var dalnis_option = [];
    var anggota_option = [];

    $("select[name='wilayah']").on('change', function() {
      get_pd();

      var val = $(this).val();
      if (val > 0) {
        get_inspektur_pembantu(val);
        get_pengendali_teknis(val);
        get_ketua_tim(val);
        get_anggota(val);
      }
      irban_option = [];
      ketua_tim_option = [];
      dalnis_option = [];
      anggota_option = [];

    });

    $(".opd").on('change', function() {
      $("#kegiatan_pr").html('').trigger('change')
      $.get('{{ URL::to(' / mst / kegiatan / get_kegiatan ')}}', {
        id: $(this).val()
      }, function(res) {

        let options = ''
        $.each(res, function(idx, k) {
          var selected = id_kegiatan == k.id ? 'selected' : ''
          options += `<option value='${k.id}' ${selected}>${k.nama}</option>`
        })
        $("#kegiatan_pr").html(options).trigger('change')
      })
    })

    $(".man-power").on('keyup change', function() {
      count_man_power();
    })

    function count_man_power() {
      let total = 0;
      $('.man-power').map(function() {
        total += $(this).val() / 1
      });
      $('#jml_man_power').html(total)
    }


    async function get_inspektur_pembantu(val) {
      await $.post("/mst/pegawai/get_inspektur_pembantu_by_wilayah", {
        "id_wilayah": val
      }, function(res) {
        if (res.data != null) {

          {{--
              var data_edit = {
                {
                  isset($data - > id_inspektur_pembantu) ? $data - > id_inspektur_pembantu : 0
                }
              };
              --}}

          $.each(res.data, function(idx, val) {
            //var selected = data_edit == val.id ? "selected" : "";
            irban_option.push("<option value='" + val.id + "'>" + val.nama + "</option>");
          });
        }
      });
      $(".penanggung-jawab-mp").html(irban_option.join(''))
    }

    async function get_pengendali_teknis(val) {
      await $.post("/mst/pegawai/get_pengendali_teknis_by_wilayah", {
        "id_wilayah": val
      }, function(res) {
        if (res.data != null) {
          $(".pengendali_teknis").html('');

          {{-- var data_edit = {
                {
                  isset($data - > id_pengendali_teknis) ? $data - > id_pengendali_teknis : 0
                }
              };
              --}}

          $.each(res.data, function(idx, val) {
            dalnis_option.push("<option value='" + val.id + "'>" + val.nama + "</option>");
          });
        }
      });
      $(".pengendali-teknis-mp").html(dalnis_option.join(''))
    }

    async function get_ketua_tim(val) {
      await $.post("/mst/pegawai/get_ketua_tim_by_wilayah", {
        "id_wilayah": val
      }, function(res) {
        if (res.data != null) {

          {{-- var data_edit = {
                {
                  isset($data - > id_ketua_tim) ? $data - > id_ketua_tim : 0
                }
              };
            --}}

          $.each(res.data, function(idx, val) {
            ketua_tim_option.push("<option value='" + val.id + "'>" + val.nama + "</option>");
          });
        }
      });
      $(".ketua-tim-mp").html(ketua_tim_option.join(''))
    }

    async function get_anggota(val) {
      await $.post("/mst/pegawai/get_anggota_by_wilayah", {
        "id_wilayah": val
      }, function(res) {
        if (res.data != null) {

          $.each(res.data, function(idx, val) {
            anggota_option.push("<option value='" + val.id + "'>" + val.nama + "</option>");
          });
        }
      });
      $(".anggota-mp").html(anggota_option.join(''))
    }

  });
</script>

<div class="modal" id="modal-form">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Program Kerja</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->

      <div class="modal-body">
        <form id="form-program_kerja" class="form-layout form-layout-5" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group row irban">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Penanggung Jawab:
            </label>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <div class="row">
                <div class="col-md-7 col-xs-12">
                  <select id="select-irban" class="form-control select2 select-irban" name="wilayah[]">
                    <option value="">- Pilih -</option>
                    @foreach ($wilayah AS $row)
                    <option value="{{$row->id}}">{{$row->nama}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-5 col-xs-12">
                  <input style="margin-top: 12px" value="1" id="lintas" name='lintas_irban' type="checkbox" />
                  <label for="lintas">&nbsp;&nbsp;&nbsp;Lintas Irban</label>
                </div>
              </div>
              <div class="text-danger error" data-error="wilayah"></div>
            </div>
          </div>
          <div class="adding-irban"></div>
          <div class="row justify-content-center mb-2 row-irban">
            <div class="col-sm-6">
              <a id="add_irban" href="#" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Tambah Irban</a>
            </div>
          </div>

          {{-- <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Perangkat Daerah :
            </label>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <select class="form-control select2 opd" name="opd"></select>
              <div class="text-danger error" data-error="opd"></div>
            </div>
          </div> --}}
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Dari <span class="required"></span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                <input name='dari' placeholder="DD-MM-YYYY" required="required" class="form-control fc-datepicker" type="text" autocomplete="off">
              </div>
              <div class="text-danger error" data-error="dari"></div>
            </div>
          </div>
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Sampai <span class="required"></span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                <input name='sampai' placeholder="DD-MM-YYYY" required="required" class="form-control fc-datepicker" type="text" autocomplete="off">
              </div>
              <div class="text-danger error" data-error="sampai"></div>
            </div>
          </div>

          <div class="divider"></div>

          <div class="col-md-12">
            <div class="label-modal">Jenis Kegiatan *</div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <select name='kegiatan' autocomplete="off" value='{{ !is_null(old('kegiatan')) ? old('kegiatan') : (isset($data->kegiatan) ? $data->kegiatan : '') }}' required="required" class="form-control" id='kegiatan_pr'>
                @if(isset($jenis_kegiatan))
                  @foreach($jenis_kegiatan as $jkn) 
                    <option value='{{ $jkn->id }}'>{{ $jkn->nama }}</option>
                  @endforeach
                @endif
              </select>
              <div class="text-danger error" data-error="kegiatan"></div>
            </div>
          </div>

          <div class="divider"></div>

          <div class="col-md-12">
            <div class="label-modal">Jenis Pengawasan *</div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <select name='jenis_pengawasan[]' value='{{ !is_null(old('jenis_pengawasan')) ? old('jenis_pengawasan') : (isset($data->jenis_pengawasan) ? $data->jenis_pengawasan : '') }}' required="required" class="form-control" id='jenis_pengawasan'>
                @if(isset($jenis_pengawasan))
                  @foreach($jenis_pengawasan as $jpn) 
                    <option value='{{ $jpn->id }}'>{{ $jpn->nama }}</option>
                  @endforeach
                @endif
              </select>
              <div class="text-danger error" data-error="jenis_pengawasan"></div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 cover-jenis-pengawasan">
            </div>
          </div>
          <div class="col-md-12 mt-3 ml-3">
            <a href="#" class="btn btn-info btn-sm btn-tambah-jenis-pengawasan"><i class="fa fa-plus"></i> Tambah Jenis Pengawasan</a>
          </div>

          <div class="col-md-12 mt-4">
            <div class="label-modal">Perangkat Daerah *</div>
            <div class="col-md-12 col-sm-12 col-xs-12 cover-opd">
            </div>
          </div>
          <div class="col-md-12 mt-3 ml-3">
            <div class="row">
              <div class="col-sm-4">
                <a href="#" class="btn btn-info btn-sm btn-tambah-perangkat-daerah"><i class="fa fa-plus"></i> Tambah Perangkat Daerah</a>
              </div>
              <div class="col-sm-8 mt-2">
                <input id="all_opd" name="all_opd" value="1" type="checkbox" style="margin-left: 5px;">
                <label for="all_opd">&nbsp;&nbsp;&nbsp;Seluruh Perangkat Daerah</label>
              </div>
            </div>
          </div>

          <div class="divider"></div>

          <div class="col-md-12">
            <div class="label-modal">Sasaran</div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <textarea class="form-control pl-2 pt-2" name="sasaran" id="sasaran" cols="100" rows="3"></textarea>
              <div class="text-danger error" data-error="sasaran"></div>
            </div>
          </div>

          {{-- 
          <div class="divider"></div>

          <div class="col-md-12">
            <div class="label-modal">Anggaran</div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input name='anggaran' class="form-control rupiah-format" type="text" autocomplete="off">
              <div class="text-danger error" data-error="anggaran"></div>
            </div>
          </div>
          --}}

          <div class="divider"></div>

          <div class="col-md-12">

            <div class="card-header label-modal" style="padding-left: 0;border-bottom: none;background:none;">
              <div class="pull-left">Jumlah Personil</div>
              <div class="pull-right">
                {{-- 
                  <input id="more_info" name="more-info" type="checkbox" />
                  <label style="font-size:13px; margin-left:8px;">Sertakan Nama Auditor</label>
                --}}
              </div>
            </div>

            <hr>
            <div class="row">
              <div class="col-8">
                <div class="form-group row justify-content-center">
                  <label class="form-control-label col-md-7 col-sm-7 col-xs-12">
                    Wakil Penanggung Jawab :
                  </label>
                  <div class="col-md-5 col-sm-5 col-xs-12">
                    <input name='jml_wakil_penanggung_jawab' required="required" class="form-control man-power" style='max-width:100px; display: inline' type="number" value='0' autocomplete="off">
                    Orang
                  </div>
                </div>
              </div>

              {{-- <div class="col-4">
                <div class="conditional_part">
                  <div class="form-group cover-penanggung-jawab">
                    <select name="penanggung_jawab_mp" class="form-control penanggung-jawab-mp"></select>
                  </div>
                </div>
              </div> --}}
            </div>

            <div class="row">
              <div class="col-8">
                <div class="form-group row justify-content-center">
                  <label class="form-control-label col-md-7 col-sm-7 col-xs-12">
                    Pengendali Teknis :
                  </label>
                  <div class="col-md-5 col-sm-5 col-xs-12">
                    <input name='jml_pengendali_teknis' required="required" class="form-control man-power" style='max-width:100px; display: inline' type="number" value='0' autocomplete="off">
                    Orang
                  </div>
                </div>
              </div>

              {{-- 
              <div class="col-4">
                <div class="conditional_part">
                  <div class="form-group cover-pengendali-teknis">
                    <select name="dalnis_mp" class="form-control pengendali-teknis-mp"></select>
                  </div>
                </div>
              </div> --}}
            </div>

            <div class="row">
              <div class="col-8">
                <div class="form-group row justify-content-center">
                  <label class="form-control-label col-md-7 col-sm-7 col-xs-12">
                    Ketua Tim :
                  </label>
                  <div class="col-md-5 col-sm-5 col-xs-12">
                    <input name='jml_ketua_tim' required="required" class="form-control man-power" style='max-width:100px; display: inline' value='0' type="number" autocomplete="off">
                    Orang
                  </div>
                </div>
              </div>

              {{-- 
              <div class="col-4">
                <div class="conditional_part">
                  <div class="form-group cover-ketua-tim">
                    <select name="ketua_tim_mp" class="form-control ketua-tim-mp"></select>
                  </div>
                </div>
              </div> --}}
            </div>

            <div class="row">
              <div class="col-8">
                <div class="form-group row justify-content-center">
                  <label class="form-control-label col-md-7 col-sm-7 col-xs-12">
                    Anggota :
                  </label>
                  <div class="col-md-5 col-sm-5 col-xs-12">
                    <input name='jml_anggota' style='max-width:100px; display: inline' required="required" class="form-control man-power" value='0' type="number" autocomplete="off">
                    Orang
                  </div>
                </div>
              </div>

              {{-- 
              <div class="col-4">
                <div class="conditional_part">
                  <div class="form-group cover-anggota">
                    <select name="anggota_mp" class="form-control anggota-mp"></select>
                  </div>
                </div>
              </div> --}}
            </div>

            <div class="row">
              <div class="col-8">
                <div class="form-group row justify-content-center">
                  <label class="form-control-label col-md-7 col-sm-7 col-xs-12">
                    Total Man Power :
                  </label>
                  <div class="col-md-5 col-sm-5 col-xs-12">
                    <span id='jml_man_power' style="max-width: 100px">0</span> Orang
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group row mt-4 d-flex justify-content-center">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 d-flex justify-content-center">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>&nbsp;
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('#more_info').change(function() {
    if (this.checked != true) {
      $(".conditional_part").hide();
    } else {
      $(".conditional_part").show();
    }
  });
</script>

<script>
  // Check Lintas Irban
  $('#lintas').on('change', async function(e) {
    await lintasIrbanHandler();
  });

  async function lintasIrbanHandler() {
    const lintasIrbanCheck = $("#lintas").is(":checked");
    if (lintasIrbanCheck) {
      $('#select-irban').attr('disabled', 'disabled');
      $('.row-irban').hide();
      $('.adding-irban').hide();
      $(".adding-irban").html('');
    } else {
      $('#select-irban').removeAttr('disabled');
      $('.row-irban').show();
      $('.adding-irban').show();
    }
    await changeIrban();
  }

  $(document).on('change','.select-irban', async function() {
    await changeIrban();
  })

  async function changeIrban() {
    const list_irban = [];
    option_opd = [];
    if($('#lintas').is(':checked') === false) {
      await $(".select-irban").map(function(idx, el) {
        const val = $(el).val();
        if(val > 0 && list_irban.indexOf(val) == -1) {
          list_irban.push(val);
        }
      })

      if(list_irban.length > 0) {
        await $.post("/mst/skpd/get_skpd_by_multiple_wilayah", {
            "id_wilayah": list_irban
          },  function(res) {

            for (const val of res) { 
              option_opd.push(`<option value='${val.id}'>${val.name}</option>`)
            }
        }); 

      }
    } else {

      await $.get("/mst/skpd/get_all_skpd",  function(res) {

          for (const val of res) { 
            option_opd.push(`<option value='${val.id}'>${val.name}</option>`)
          }
      }); 
    }
    await $(".opd").map(function(idx, el) {
      $(this).data('last-val', $(this).val())
    })
    
    await $(".opd").html(option_opd.join(''))


    await $(".opd").map(function(idx, el) {
      $(this).val($(this).data('last-val'))
    })

    $(".opd").trigger('change');
  } 

  // Add Irban Form
  $('#add_irban').on('click', function() {
    addingIrbanSelection()
  });

  function addingIrbanSelection(){
    
    $('div.adding-irban').append(`
      <div class="row justify-content-center mb-2">
        <div class="col-sm-6">
          <div class="input-group">
            <select class="form-control select2 select-irban" name="wilayah[]">
              <option value="">- Pilih -</option>
              @foreach ($wilayah AS $row)
              <option value="{{$row->id}}">{{$row->nama}}</option>
              @endforeach
            </select>
            <button type="button" class="btn btn-sm btn-danger close-irban"><i class="fa fa-close"></i></button>
          </div>
        </div>
      </div>
    `);
    

    $(".adding-irban select:last").select2()
  }

  // Close Irban Form
  $(document).on('click', ".close-irban", async function() {
    $(this).parent().closest('.row').remove();
    await changeIrban();
  });

  // Add form perangkat daerah
  $('.btn-tambah-perangkat-daerah').on('click', () => {
    addingSkpdSelection()
  });

  function addingSkpdSelection() {
    
    $('.cover-opd').append(`
    <div class='row parent-perangkat-daerah'>
      <div class="col-md-12 col-sm-12 col-xs-12 mt-3 ">
        <div class="input-group">
          <select name='opd[]' autocomplete="off" required="required" class="form-control opd" id='kegiatan_pr'>
          ${option_opd.join('')}
          </select>
          <button type="button" class="btn btn-sm btn-danger close-perangkat-daerah"><i class="fa fa-close"></i></button>
        </div>
      </div>
    </div>
    `);

    $(".cover-opd select:last").select2()
  }

  // Close Perangkat Daerah Form
  $(document).on('click', ".close-perangkat-daerah", function() {
    $(this).parent().closest('.parent-perangkat-daerah').remove();
  });

  // Add form perangkat daerah
  $('.btn-tambah-jenis-pengawasan').on('click', () => {
    addingJenisPengawasan();
  });

  function addingJenisPengawasan() {

    $('.cover-jenis-pengawasan').append(`
    <div class='row parent-jenis-pengawasan'>
      <div class="col-md-12 col-sm-12 col-xs-12 mt-3 ">
        <div class="input-group">
          <select name='jenis_pengawasan[]' autocomplete="off" required="required" class="form-control" id='jenis-pengawasan'>
            @if(isset($jenis_pengawasan))
              @foreach($jenis_pengawasan as $jpn) 
                <option value='{{ $jpn->id }}'>{{ $jpn->nama }}</option>
              @endforeach
            @endif
          </select>
          <button type="button" class="btn btn-sm btn-danger close-jenis-pengawasan"><i class="fa fa-close"></i></button>
        </div>
      </div>
    </div>
    `);
    
    $(".cover-jenis-pengawasan select:last").select2()
  }

  // Close Perangkat Daerah Form
  $(document).on('click', ".close-jenis-pengawasan", function() {
    $(this).parent().closest('.parent-jenis-pengawasan').remove();
  });

  $('#all_opd').on('change', (e) => {
    // console.log(e.target.checked);
    if(e.target.checked === true) {
      $('.btn-tambah-perangkat-daerah').addClass('disabled');
    }else {
      $('.btn-tambah-perangkat-daerah').removeClass('disabled');
    }
  });
  
</script>