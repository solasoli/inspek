<style>
  .conditional_part {
    display:none;
  }
</style>
<script>
$(function() {
  var id_kegiatan = 0;
  $('#modal-form').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    id_kegiatan = $(e.relatedTarget).data('kegiatan');
    get_sasaran(id);
    function get_sasaran(id) {
      $("#cover-sasaran_edit").html('');
      $.get("{{url('')}}/mst/sasaran/get_sasaran_by_id_program_kerja?id=" + id, function(data) {
        // console.log(data);
        if (id > 0) {
          $.each(data, function(idx, val){
            var r = "<tr>";
            r += "<td>";
            r += "<input name='sasaran[]' value='"+ val.nama +"' autocomplete='off' required='required' class='form-control' type='text'>";
            r += "</td>";
            r += "<td>";
            r += "<button type='button' class='btn btn-danger btn-xs remove-sasaran'><i class='fa fa-close'></i></button>";
            r += "</td>";
            r += "</tr>";
            $("#cover-sasaran_edit").append(r);
          });
        }
        else {
          $("#cover-sasaran_edit").html('');
        }

      });
    }

    $("select[name='wilayah']").val('').trigger('change');
    $("select[name='opd']").html(''); // api na benang , kakara di clir

    if(id > 0) { // form edit
      $.get("{{url('')}}/mst/program_kerja/get_program_kerja_by_id?id=" + id, function(data) {
        // console.log(data);
        $('input[name="sub_kegiatan"]').val(data.sub_kegiatan);
        $('select[name="wilayah"]').val(data.id_wilayah).trigger("change.select2");
        // $('select[name="opd"]').val(data.id_skpd).trigger("change");
        get_pd(data.id_skpd);
        $('input[name="dari"]').val(moment(new Date(data.dari)).format("DD-MM-YYYY"));
        $('input[name="sampai"]').val(moment(new Date(data.sampai)).format("DD-MM-YYYY"));
        $('input[name="jml_wakil_penanggung_jawab"]').val(data.jml_wakil_penanggung_jawab);
        $('input[name="jml_pengendali_teknis"]').val(data.jml_pengendali_teknis);
        $('input[name="jml_ketua_tim"]').val(data.jml_ketua_tim);
        $('input[name="jml_anggota"]').val(data.jml_anggota);
        $('input[name="anggaran"]').autoNumeric('set', data.anggaran);

        count_man_power();
      });

      $("#form-program_kerja").attr('action', '{{url()->current()}}/edit/'+ id +'');
    } else {

      $("#form-program_kerja").attr('action', '{{url()->current()}}/add');
    }

    $('#form-program_kerja').on('submit', function(e){
      e.preventDefault();
      $('.error').html('');
      $.ajax({
        url: $(this).attr('action'),
        method: $(this).attr('method'),
        data: $(this).serialize(),
        dataType: 'json',
        success(response)
        {
          window.location.href = '{{url()->current()}}';
        },
        error(error)
        {
          let errors = error.responseJSON.errors;
          for(let key in errors) {
            let errorDiv = $(`.error[data-error="${key}"]`);
            if(errorDiv.length) {
              errorDiv.text(errors[key][0]);
            }
          }
        }
      });
    });

  });


  $(".add-sasaran").on('click', function(){
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


  $(document).on('click', ".remove-sasaran", function(){
    $(this).parent().closest("tr").remove();
  });

  var irban_option = [];
  var ketua_tim_option = [];
  var dalnis_option = [];
  var anggota_option = [];

  $("select[name='wilayah']").on('change', function(){
    get_pd(); 
    
    var val = $(this).val();
    if(val > 0){
      console.log(val)
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

  $(".opd").on('change', function(){
    $("#kegiatan_pr").html('').trigger('change')
    $.get('{{ URL::to('/mst/kegiatan/get_kegiatan')}}', { id: $(this).val() } ,function(res) {

      let options = ''
      $.each(res, function(idx, k){
        var selected = id_kegiatan == k.id ? 'selected' : ''
        options += `<option value='${k.id}' ${selected}>${k.nama}</option>`
      })
      $("#kegiatan_pr").html(options).trigger('change')
    })

  })

  $(".man-power").on('keyup change', function(){
    count_man_power();
  })

  function count_man_power(){
    let total = 0;
    $('.man-power').map(function(){
      total += $(this).val()/1
    });
    $('#jml_man_power').html(total)
  }

  
  async function get_inspektur_pembantu(val){
    await $.post("/mst/pegawai/get_inspektur_pembantu_by_wilayah", {"id_wilayah": val}, function(res){
      if(res.data != null){

        {{--  var data_edit = {{isset($data->id_inspektur_pembantu) ? $data->id_inspektur_pembantu : 0 }};  --}}

        $.each(res.data, function(idx, val){
          //var selected = data_edit == val.id ? "selected" : "";
          irban_option.push("<option value='" + val.id +"'>" + val.nama + "</option>");
        });
      }
    });
    $(".penanggung-jawab-mp").html(irban_option.join(''))
  }

  async function get_pengendali_teknis(val){
    await $.post("/mst/pegawai/get_pengendali_teknis_by_wilayah", {"id_wilayah": val}, function(res){
      if(res.data != null){
        $(".pengendali_teknis").html('');

        {{--  var data_edit = {{isset($data->id_pengendali_teknis) ? $data->id_pengendali_teknis : 0 }};  --}}

        $.each(res.data, function(idx, val){
          dalnis_option.push("<option value='" + val.id +"'>" + val.nama + "</option>");
        });
      }
    });
    $(".pengendali-teknis-mp").html(dalnis_option.join(''))
  }

  async function get_ketua_tim(val){
    await $.post("/mst/pegawai/get_ketua_tim_by_wilayah", {"id_wilayah": val}, function(res){
      if(res.data != null){

        {{--  var data_edit = {{isset($data->id_ketua_tim) ? $data->id_ketua_tim : 0 }};  --}}

        $.each(res.data, function(idx, val){
          ketua_tim_option.push("<option value='" + val.id +"'>" + val.nama + "</option>");
        });
      }
    });
    $(".ketua-tim-mp").html(ketua_tim_option.join(''))
  }

  async function get_anggota(val){
    await $.post("/mst/pegawai/get_anggota_by_wilayah", {"id_wilayah": val}, function(res){
      if(res.data != null){

        $.each(res.data, function(idx, val){
          anggota_option.push("<option value='" + val.id +"'>" + val.nama + "</option>");
        });
      }
    });
    $(".anggota-mp").html(anggota_option.join(''))
  }

});
</script>
<script type="text/javascript">
  $('#lintas_irban').click(function() {
    $append.attr('disabled').to('#dropdown_irban').attr(! this.checked)
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
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Irban :
            </label>
            <div class="col-md-7 col-sm-7 col-xs-12">
              <div class="row">
                <div class="col-md-6 col-xs-12">
              <select id="dropdown_irban" class="form-control select2" name="wilayah">
                <option value="" >- Pilih -</option>
                @foreach ($wilayah AS $row)
                  <option value="{{$row->id}}">{{$row->nama}}</option>
                @endforeach
              </select>
                </div>
              <div class="col-md-6 col-xs-12">
                <input style="margin-top: 12px" id="lintas_irban" type="checkbox" />
                <label for="lintas_irban">&nbsp;&nbsp;&nbsp;Lintas Irban</label>
              </div>
              
            </div>
              
              <div class="text-danger error" data-error="wilayah"></div>
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
              <select name='kegiatan' autocomplete="off" value='{{ !is_null(old('nama')) ? old('nama') : (isset($data->nama) ? $data->nama : '') }}' required="required" class="form-control" id='kegiatan_pr'>
              </select>
              <div class="text-danger error" data-error="kegiatan"></div>
            </div>
          </div>

          <div class="divider"></div>

          <div class="col-md-12">
            <div class="label-modal">Jenis Pengawasan *</div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input name='sub_kegiatan' value='{{ !is_null(old('nama')) ? old('nama') : (isset($data->nama) ? $data->nama : '') }}' required="required" class="form-control" id='sub_kegiatan'>
              <div class="text-danger error" data-error="sub_kegiatan"></div>
            </div>
          </div>

          <div class="divider"></div>

          <div style="margin: 0 5px">
            <table class="table" width="100%">
              <thead>
                <tr>
                  <th>Sasaran</th>
                  <th style="width:60px"></th>
                </tr>
              </thead>
              <tbody id='cover-sasaran_edit'>
              </tbody>
              <tr>
                <td colspan="2">
                  <button type="button" class="btn btn-info add-sasaran"> Tambah Sasaran</button>
                </td>
              </tr>
            </table>
          </div>

          <div class="divider"></div>

          <div class="col-md-12">
            <div class="label-modal">Anggaran</div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <input name='anggaran' required="required" class="form-control rupiah-format" type="text" autocomplete="off">
              <div class="text-danger error" data-error="anggaran"></div>
            </div>
          </div>

          <div class="divider"></div>

          <div class="col-md-12">
            
            <div class="card-header label-modal" style="padding-left: 0;border-bottom: none;background:none;">
              <div class="pull-left">Man Power</div>
              <div class="pull-right">
                <input id="more_info" name="more-info" type="checkbox" />
                <label style="font-size:13px; margin-left:8px;">Sertakan Nama Auditor</label>
              </div>
            </div>

            <hr>
            <div class="row">
              <div class="col-6">
                <div class="form-group row justify-content-center">
                  <label class="form-control-label col-md-8 col-sm-8 col-xs-12">
                    Wakil Penanggung Jawab :
                  </label>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <input name='jml_wakil_penanggung_jawab' required="required" class="form-control man-power" style='max-width:50px; display: inline' type="number" value='0' autocomplete="off">
                    Orang
                  </div>
                </div>
              </div>
                
              <div class="col-4">
                <div class="conditional_part">
                  <div class="form-group cover-penanggung-jawab">
                    <select name="penanggung_jawab_mp" class="form-control penanggung-jawab-mp"></select>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-6">
                <div class="form-group row justify-content-center">
                  <label class="form-control-label col-md-8 col-sm-8 col-xs-12">
                    Pengendali Teknis :
                  </label>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <input name='jml_pengendali_teknis' required="required" class="form-control man-power" style='max-width:50px; display: inline' type="number" value='0' autocomplete="off">
                    Orang
                  </div>
                </div>
              </div>
                
              <div class="col-4">
                <div class="conditional_part">
                  <div class="form-group cover-pengendali-teknis">
                    <select name="dalnis_mp" class="form-control pengendali-teknis-mp"></select>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group row justify-content-center">
                  <label class="form-control-label col-md-8 col-sm-8 col-xs-12">
                    Ketua Tim :
                  </label>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <input name='jml_ketua_tim' required="required" class="form-control man-power" style='max-width:50px; display: inline' value='0' type="number" autocomplete="off">
                    Orang
                  </div>
                </div>
              </div>
                
              <div class="col-4">
                <div class="conditional_part">
                  <div class="form-group cover-ketua-tim">
                    <select name="ketua_tim_mp" class="form-control ketua-tim-mp"></select>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group row justify-content-center">
                  <label class="form-control-label col-md-8 col-sm-8 col-xs-12">
                    Anggota :
                  </label>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <input name='jml_anggota' style='max-width:50px; display: inline' required="required" class="form-control man-power" value='0' type="number" autocomplete="off">
                    Orang
                  </div>
                </div>
              </div>
                
              <div class="col-4">
                <div class="conditional_part">
                  <div class="form-group cover-anggota">
                    <select name="anggota_mp" class="form-control anggota-mp"></select>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="form-group row justify-content-center">
                  <label class="form-control-label col-md-8 col-sm-8 col-xs-12">
                    Total Man Power :
                  </label>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <span id='jml_man_power'>0</span> Orang
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
        if(this.checked != true){
          $(".conditional_part").hide();
        }
        else{
          $(".conditional_part").show();
        }
      });
</script>