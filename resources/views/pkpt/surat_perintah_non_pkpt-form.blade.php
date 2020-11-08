@extends('layouts.app')
@section('content')
<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="/">Master</a>
    <a class="breadcrumb-item Active" href="#">Surat Perintah Non-PKPT</a>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">{{ isset($data) ? "Edit" : "Tambah" }} Surat Perintah Non-PKPT</h4>
</div>

<form class="form-layout form-layout-5" style="padding-top:0" method="post" enctype="multipart/form-data">
  <div class="br-pagebody">
    @if(Session::has('error'))
    <div class="row">
      <div class="alert alert-danger col-lg-12">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex align-items-center justify-content-start">
          <span>{!! Session::get('error') !!}</span>
        </div>
      </div>
    </div>
    @endif
    @if(Session::has('success'))
    <div class="row">
      <div class="alert alert-success col-lg-12">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex align-items-center justify-content-start">
          <span>{!! Session::get('success') !!}</span>
        </div>
      </div>
    </div>
    @endif
    <div class="row">
      <div class="col-lg-12 widget-2 px-0">
        <div class="card shadow-base">

          <div class="card-header">
            <h6 class="card-title float-left py-2">Penambahan SP</h6>
          </div>
          <div class="card-body">
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Dasar Surat
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea name='dasar_surat' class="form-control">{{ !is_null(old('dasar_surat')) ? old('dasar_surat') : (isset($data->dasar_surat) ? $data->dasar_surat : (isset($dasar_surat->dasar_surat) ? $dasar_surat->dasar_surat : '')) }}</textarea>
              </div>
            </div>
            <div class="form-group row" style="margin-bottom: 10px">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Pilih Kegiatan
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='kegiatan' class="form-control select2 kegiatan">
                  @foreach($kegiatan as $idx => $row)
                    @php
                    $selected = !is_null(old('kegiatan')) && old('kegiatan') == $row->id ? 'selected' : isset($data->id) && $data->id_program_kerja == $row->id ? 'selected' : '';
                    @endphp
                    <option value='{{$row->id}}'
                      data-kegiatan='{{$row->id_kegiatan}}'
                      data-program_kerja='{{$row->id_program_kerja}}'
                      data-wilayah='{{$row->id_wilayah}}'
                      data-dari='{{ date("d-m-yy",strtotime($row->dari)) }}'
                      data-sampai='{{ date("d-m-yy",strtotime($row->sampai)) }}' {{$selected}}>{{$row->nama}}</option>
                  @endforeach
                </select>

              </div>

            </div>
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Sub Kegiatan <span class="required"></span> :
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input name='sub_kegiatan' autocomplete="off" value='{{ !is_null(old('sub_kegiatan')) ? old('sub_kegiatan') : (isset($data->id) ? $data->program_kerja->sub_kegiatan : '') }}' required="required" class="form-control" type="text" >
              </div>
            </div>
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Anggaran <span class="required"></span> :
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input name='anggaran' autocomplete="off" value='{{ !is_null(old('anggaran')) ? old('anggaran') : (isset($data->id) ? $data->program_kerja->anggaran : '') }}' required="required" class="form-control rupiah-format" type="text" >
              </div>
            </div>
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <table class="table" width="100%">
                  <thead>
                    <tr>
                      <th>Sasaran</th>
                      <th style="width:60px"></th>
                    </tr>
                  </thead>
                  <tbody id='cover-sasaran'>
                    @if(isset($data->id))
                      @foreach($data->sasaran as $idx => $row)
                        <tr>
                          <td>
                            <input name="sasaran_kegiatan[]" autocomplete="off" required="required" class="form-control" type="text" value='{{ $row->nama }}'>
                          </td>
                          <td>
                            @if($idx > 0)
                              <button type="button" class="btn btn-danger btn-xs remove-sasaran"><i class="fa fa-close"></i></button>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    @else
                      <tr>
                        <td>
                          <input name="sasaran_kegiatan[]" autocomplete="off" required="required" class="form-control" type="text" >
                        </td>
                        <td></td>
                      </tr>
                    @endif
                  </tbody>
                  <tr>
                    <td colspan="2">
                      <button type="button" class="btn btn-info add-sasaran"> Tambah Sasaran</button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Dari
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="input-group">
                  <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                  <input type="text" name='dari' id="dari_kalendar" value="{{ !is_null(old('dari')) ? old('dari') : (isset($data->dari) ? date("d-m-Y", strtotime($data->dari)) : '') }}" class="form-control fc-datepicker" placeholder="DD-MM-YYYY" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Sampai
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="input-group">
                  <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                  <input type="text" name='sampai' id="sampai_kalendar" value="{{ !is_null(old('sampai')) ? old('sampai') : (isset($data->sampai) ? date("d-m-Y", strtotime($data->sampai)) : '') }}" class="form-control fc-datepicker" placeholder="DD-MM-YYYY" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Wilayah :
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control select2" name="wilayah" id='wilayah'>
                  <option value="">- Pilih -</option>
                  @foreach ($wilayah AS $row)
                    @php
                    $selected = !is_null(old('wilayah')) && old('wilayah') == $row->id ? "selected" : (isset($data->id_wilayah) && $row->id == $data->id_wilayah ? 'selected' : '');
                    @endphp
                    <option value="{{$row->id}}" {{$selected}}>{{$row->nama}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
              </div>
              <div class="col-md-6">
                <div id="jadwal_warning" class="alert alert-warning" style="margin-bottom:10px; display: none;">
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Perangkat Daerah :
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control select2" name="opd">
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Tembusan
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea name='tembusan' class="form-control">{{ !is_null(old('tembusan')) ? old('tembusan') : (isset($data->tembusan) ? $data->tembusan : '') }}</textarea>
              </div>
            </div>

          </div>

          <div class="card-header">
            <h6 class="card-title float-left py-2">Susunan Tim</h6>
          </div>
          <div class="card-body">
            {{ csrf_field() }}

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Penanggung Jawab
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='inspektur' class="form-control select2">
                  @foreach($list_inspektur as $idx => $row)
                  @php
                  $selected = !is_null(old('inspektur')) && old('inspektur') == $row->id ? "selected" : (isset($data->id_inspektur) && $row->id == $data->id_inspektur ? 'selected' : '');
                  @endphp
                  <option value='{{$row->id}}' {{$selected}} data-nama="{{$row->nama}}">{{$row->nama}}</option>
                  @endforeach
                </select>
              </div>
            </div>


            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Wakil Penanggung Jawab
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='inspektur_pembantu' class="form-control select2 inspektur_pembantu">
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Pengendali Teknis
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='pengendali_teknis' class="form-control select2 pengendali_teknis">
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Ketua Tim
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='ketua_tim' class="form-control select2 ketua_tim">
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">

              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Anggota</th>
                      <th style="width:60px"></th>
                    </tr>
                  </thead>
                  <tbody id='cover-anggota'>
                    @if(!is_null(old('anggota')))
                      @foreach(old('anggota') as $i => $r)
                        <tr>
                          <td>
                            <select name='anggota[]' class="form-control select2 anggota">
                              @foreach($pegawai as $idx => $row)
                                @php
                                $selected = $row->id == $r ? "selected" : "";
                                @endphp
                                <option value='{{$row->id}}' {{$selected}}>{{$row->nama}}</option>
                              @endforeach
                            </select>
                          </td>
                          <td></td>
                        </tr>
                      @endforeach
                    @elseif(isset($data->id))
                      @foreach($data->anggota AS $idx => $row)
                        <tr>
                          <td>
                            <select name='anggota[]' class="form-control select2">
                              @foreach($anggota AS $i => $r)
                                @php
                                $selected = $row->id == $r->id ? 'selected' : '';
                                @endphp
                                <option value="{{$r->id}}" {{$selected}}>{{$r->nama}}</option>
                              @endforeach
                            </select>
                          </td>
                          <td>
                            @if($idx > 0)
                            <button type='button' class='btn btn-danger btn-xs remove-sasaran'><i class='fa fa-close'></i></button>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    @else
                      <tr>
                        <td>
                          <select name='anggota[]' class="form-control select2 anggota">
                          </select>
                        </td>
                        <td>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tr>
                    <td colspan="2">
                      <button type="button" class="btn btn-info add-anggota"> Tambah Anggota</button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

          </div>

          <div class="card-header"></div>
          <div class="card-body">



            <div class="form-group row d-flex justify-content-center">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a href='{{url('')}}/pkpt/surat_perintah' class="btn btn-danger" type="button">Cancel</a>
                <button type="submit" class="btn btn-primary" >Submit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</form>
<script>
  var addMoreAnggota = "<tr>";
  addMoreAnggota += "<td>";
  addMoreAnggota += "<select name='anggota[]' class='form-control select2 anggota'>";
  addMoreAnggota += "</select>";
  addMoreAnggota += "</td>";
  addMoreAnggota += "<td>";
  addMoreAnggota += "<button type='button' class='btn btn-danger btn-xs delete-anggota'><i class='fa fa-close'></i></button>";
  addMoreAnggota += "</td>";
  addMoreAnggota += "</tr>";

  var optionAnggota = '';

  $(function(){
    $('.fc-datepicker').datepicker({
      dateFormat: "dd-mm-yy"
    });
    $(".add-anggota").on('click', function(){
        $("#cover-anggota").append(addMoreAnggota);

        $("#cover-anggota tr:last .select2").html(optionAnggota);
        $("#cover-anggota tr:last .select2").select2();

    });

    change_wilayah($("#wilayah").val());

    $("#wilayah").on("change", function(){
      var val = $(this).val();
      change_wilayah(val);
    });

    function change_wilayah(val){
      $("#inspektur-ds").html(val);
      get_inspektur_pembantu(val);
      get_pengendali_teknis(val);
      get_ketua_tim(val);
      get_anggota(val);
      get_pd({{ isset($data->id) ? $data->program_kerja->id_skpd : 0 }});

      check_jadwal_surat_perintah();
    }

    function get_inspektur_pembantu(val){
      $.post("/mst/pegawai/get_inspektur_pembantu_by_wilayah", {"id_wilayah": val}, function(res){
        if(res.data != null){
          $(".inspektur_pembantu").html('');

          var data_edit = {{isset($data->id_inspektur_pembantu) ? $data->id_inspektur_pembantu : 0 }};

          $.each(res.data, function(idx, val){
            var selected = data_edit == val.id ? "selected" : "";
            $(".inspektur_pembantu").append("<option value='" + val.id +"' " +selected+ ">" + val.nama + "</option>");
          });
        }
      });
    }

    function get_pengendali_teknis(val){
      $.post("/mst/pegawai/get_pengendali_teknis_by_wilayah", {"id_wilayah": val}, function(res){
        if(res.data != null){
          $(".pengendali_teknis").html('');

          var data_edit = {{isset($data->id_pengendali_teknis) ? $data->id_pengendali_teknis : 0 }};

          $.each(res.data, function(idx, val){
            var selected = data_edit == val.id ? "selected" : "";
            $(".pengendali_teknis").append("<option value='" + val.id +"' " +selected+ ">" + val.nama + "</option>");
          });
        }
      });
    }

    function get_ketua_tim(val){
      $.post("/mst/pegawai/get_ketua_tim_by_wilayah", {"id_wilayah": val}, function(res){
        if(res.data != null){
          $(".ketua_tim").html('');

          var data_edit = {{isset($data->id_ketua_tim) ? $data->id_ketua_tim : 0 }};

          $.each(res.data, function(idx, val){
            var selected = data_edit == val.id ? "selected" : "";
            $(".ketua_tim").append("<option value='" + val.id +"' " +selected+ ">" + val.nama + "</option>");
          });
        }
      });
    }

    $("#wilayah, #dari_kalendar, #sampai_kalendar").on("change", function(){
      check_jadwal_surat_perintah();
    });

    function check_jadwal_surat_perintah(){
      $("#jadwal_warning").hide();
      if($(".wilayah").val() != "" && $("#dari_kalendar").val() != "" && $("#sampai_kalendar").val() != ""){
        $.post("/pkpt/surat_perintah/check_jadwal", {"id_wilayah": $("#wilayah").val(), "dari" : $("#dari_kalendar").val(), "sampai": $("#sampai_kalendar").val(), "sp_id" : "{{ isset($data->id) ? $data->id : 0}}" }, function(res){
            if(res.show_warning == 1){
              $("#jadwal_warning").html(res.msg).show();
            }
        });
      }
    }

    $(document).on('click', ".delete-anggota", function(){
      $(this).parent().closest("tr").remove();
    });

    function get_anggota(val){
      $.post("/mst/pegawai/get_anggota_by_wilayah", {"id_wilayah": val}, function(res){
        if(res.data != null){
          $(".anggota").html('');

          var data_edit = {{isset($data->id_ketua_tim) ? $data->id_ketua_tim : 0 }};
          var option = '';
          $.when($.each(res.data, function(idx, val){
            $(".anggota").append("<option value='" + val.id +"'>" + val.nama + "</option>");
            option += "<option value='" + val.id +"'>" + val.nama + "</option>";
          })).then(function(){
            optionAnggota = option;
          });
        }
      });
    }

    function get_pd(selected_skpd) {
      var id_wilayah = $("select[name='wilayah']").val();
      $.get("{{url('')}}/mst/skpd/get_skpd_by_id_wilayah?id=" + id_wilayah, function(data) {
        $("select[name='opd']").html(''); //
        $.each(data, function(idx, val){
          var selected = selected_skpd > 0 && selected_skpd == val.id ? 'selected' : '';
          var option = "<option value='"+val.id+"' " + selected + ">"+val.name+"</option>";
          $("select[name='opd']").append(option);
        });
      });
    }

    $(".add-sasaran").on('click', function(){
      var am = "<tr>";
      am += "<td>";
      am += "<input name='sasaran_kegiatan[]' autocomplete='off' required='required' class='form-control' type='text'>";
      am += "</td>";
      am += "<td>";
      am += "<button type='button' class='btn btn-danger btn-xs remove-sasaran'><i class='fa fa-close'></i></button>";
      am += "</td>";
      am += "</tr>";
      $("#cover-sasaran").append(am);
    });

    $(document).on('click', ".remove-sasaran", function(){
      $(this).parent().closest("tr").remove();
    });

  });
</script>
@endsection
