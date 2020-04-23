@extends('layouts.app')
@section('content')
<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="/">Master</a>
    <a class="breadcrumb-item Active" href="#">Surat Perintah {{ $type == 1 ? "PKPT" : "Non-PKPT"}}</a>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">{{ isset($data) ? "Edit" : "Tambah" }} Surat Perintah {{ $type == 1 ? "PKPT" : "Non-PKPT"}}</h4>
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

          @if ($type == 1) <!-- Surat Perintah PKP -->
            <div class="card-body">
              <div class="form-group row">
                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                  Dasar Surat
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea name='dasar_surat' class="form-control">{{ !is_null(old('dasar_surat')) ? old('dasar_surat') : (isset($data->dasar_surat) ? $data->dasar_surat : (isset($dasar_surat->dasar_surat) ? $dasar_surat->dasar_surat : '')) }}</textarea>
                </div>
              </div>
            </div>

            <div class="card-header">
              <h6 class="card-title float-left py-2">Program Kerja</h6>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                  Pilih Kegiatan
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name='kegiatan' class="form-control select2">
                    @foreach($kegiatan as $idx => $row)
                    <option value='{{$row->id}}' data-wilayah='{{$row->id_wilayah}}'>{{$row->nama}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                  Pilih Sasaran
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name='sasaran' class="form-control select2">
                  </select>
                </div>
              </div>
            </div>
          @else <!-- Surat Perintah Non-PKPT -->
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
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Kegiatan <span class="required"></span> :
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input name='nama' autocomplete="off" value='{{ !is_null(old('nama')) ? old('nama') : (isset($data->nama) ? $data->nama : '') }}' required="required" class="form-control" type="text" >
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
                    <tr>
                      <td>
                        <input name="sasaran[]" autocomplete="off" required="required" class="form-control" type="text" >
                      </td>
                      <td></td>
                    </tr>
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
                <select class="form-control select2" name="wilayah">
                  <option value="">- Pilih -</option>
                  @foreach ($wilayah AS $row)
                    <option value="{{$row->id}}">{{$row->nama}}</option>
                  @endforeach
                </select>
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

          </div>

          @endif

          <div class="card-header">
            <h6 class="card-title float-left py-2">Susunan Tim</h6>
          </div>
          <div class="card-body">
            {{ csrf_field() }}

            <!-- <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Wilayah
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='wilayah' class="form-control select2 wilayah">
                  <option value="" data-nama="-">- Pilih Disini -</option>
                  @foreach($wilayah as $idx => $row)
                  @php
                  $selected = !is_null(old('wilayah')) && old('wilayah') == $row->id ? "selected" : (isset($data->id_wilayah) && $row->id == $data->id_wilayah ? 'selected' : '');
                  @endphp
                  <option value='{{$row->id}}' {{$selected}} data-nama="{{$row->nama_inspektur}}">{{$row->nama}}</option>
                  @endforeach
                </select>
              </div>
            </div> -->

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Inspektur
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
                Inspektur Pembantu
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
                  <option value="" data-nama="-">- Pilih Disini -</option>
                  @foreach($pegawai as $idx => $row)
                  @php
                  $selected = !is_null(old('ketua_tim')) && old('ketua_tim') == $row->id ? "selected" : (isset($data->id_ketua_tim) && $row->id == $data->id_ketua_tim ? 'selected' : '');
                  @endphp
                  <option value='{{$row->id}}' {{$selected}} data-nama="{{$row->nama}}">{{$row->nama}}</option>
                  @endforeach
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
                            <select name='anggota[]' class="form-control select2">
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
                    @elseif((isset($anggota) && $anggota->count() == 0) || !isset($anggota))
                      <tr>
                        <td>
                          <select name='anggota[]' class="form-control select2">
                            @foreach($pegawai as $idx => $row)
                              <option value='{{$row->id}}'>{{$row->nama}}</option>
                            @endforeach
                          </select>
                        </td>
                        <td></td>
                      </tr>
                    @else
                      @php
                        $x = 1;
                      @endphp

                      @foreach($anggota as $i => $r)
                        <tr>
                          <td>
                            <select name='anggota[]' class="form-control select2">
                              @foreach($pegawai as $idx => $row)
                                @php
                                $selected = $row->id == $r->id ? "selected" : "";
                                @endphp
                                <option value='{{$row->id}}' {{$selected}}>{{$row->nama}}</option>
                              @endforeach
                            </select>
                          </td>
                          <td>
                            @if($x > 1)
                            <button type='button' class='btn btn-danger btn-xs delete-anggota'>
                              <i class='fa fa-close'></i>
                            </button>
                            @endif
                          </td>
                        </tr>
                        @php
                        $x++;
                        @endphp
                      @endforeach
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

          <!-- <div class="card-header">
            <h6 class="card-title float-left py-2"></h6>
          </div>
          <div class="card-body">

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                No. Surat
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control" name='no_surat' value="{{ !is_null(old('no_surat')) ? old('no_surat') : (isset($data->no_surat) ? $data->no_surat : '') }}">
              </div>
            </div>

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Untuk
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea name='untuk' class="form-control">{{ !is_null(old('untuk')) ? old('untuk') : (isset($data->untuk) ? $data->untuk : '') }}</textarea>
              </div>
            </div>

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">

              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">

                <div class="alert alert-danger" id='jadwal_warning' style="display: none">Terdapat surat perintah lain dengan tanggal tersebut!</div>
              </div>
            </div>
          </div> -->

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
  var addMoreOpd = "<tr>";
  addMoreOpd += "<td>";
  addMoreOpd += "<select name='anggota[]' class='form-control select2'>";
  addMoreOpd += "<option value=''>- Pilih Disini -</option>";
  @foreach($pegawai as $idx => $row)
    addMoreOpd += "<option value='{{$row->id}}'>{{$row->nama}}</option>";
  @endforeach
  addMoreOpd += "</select>";
  addMoreOpd += "</td>";
  addMoreOpd += "<td>";
  addMoreOpd += "<button type='button' class='btn btn-danger btn-xs delete-anggota'><i class='fa fa-close'></i></button>";
  addMoreOpd += "</td>";
  addMoreOpd += "</tr>";

  $(function(){
    $('.fc-datepicker').datepicker({
      dateFormat: "dd-mm-yy"
    });
    $(".add-anggota").on('click', function(){
        $("#cover-anggota").append(addMoreOpd);

        $("#cover-anggota tr:last .select2").select2();
    });

    change_wilayah($(".wilayah"));

    $(".wilayah").on("change", function(){
      change_wilayah($(this));
    });

    function change_wilayah(el){
      var nama = $(el).find("option:selected").data("nama");
      $("#inspektur-ds").html(nama);
      get_inspektur_pembantu($(el));
      get_pengendali_teknis($(el));
      get_ketua_tim($(el));

      check_jadwal_surat_perintah();
    }

    function get_inspektur_pembantu(el){
      $.post("/mst/inspektur_pembantu/get_inspektur_pembantu_by_wilayah", {"id_wilayah": $(el).val()}, function(res){
        if(res.data != null){
          $(".inspektur_pembantu").html('');

          var data_edit = {{isset($data->id_inspektur_pembantu) ? $data->id_inspektur_pembantu : 0 }};

          $.each(res.data, function(idx, val){
            var selected = data_edit == val.id ? "selected" : "";
            $(".inspektur_pembantu").append("<option value='" + val.id +"' " +selected+ ">" + val.nama_inspektur + "</option>");
          });
        }
      });
    }

    function get_pengendali_teknis(el){
      $.post("/mst/pegawai/get_pengendali_teknis_by_wilayah", {"id_wilayah": $(el).val()}, function(res){
        if(res.data != null){
          $(".pengendali_teknis").html('');

          var data_edit = {{isset($data->id_pengendali_teknis) ? $data->id_pengendali_teknis : 0 }};

          $.each(res.data, function(idx, val){
            var selected = data_edit == val.id ? "selected" : "";
            $(".pengendali_teknis").append("<option value='" + val.id +"' " +selected+ ">" + val.nama_inspektur + "</option>");
          });
        }
      });
    }

    function get_ketua_tim(el){
      $.post("/mst/pegawai/get_ketua_tim_by_wilayah", {"id_wilayah": $(el).val()}, function(res){
        if(res.data != null){
          $(".ketua_tim").html('');

          var data_edit = {{isset($data->id_ketua_tim) ? $data->id_ketua_tim : 0 }};

          $.each(res.data, function(idx, val){
            var selected = data_edit == val.id ? "selected" : "";
            $(".ketua_tim").append("<option value='" + val.id +"' " +selected+ ">" + val.nama_inspektur + "</option>");
          });
        }
      });
    }

    $(".wilayah, #dari_kalendar, #sampai_kalendar").on("change", function(){
      check_jadwal_surat_perintah();
    });

    function check_jadwal_surat_perintah(){
      $("#jadwal_warning").hide();
      if($(".wilayah").val() != "" && $("#dari_kalendar").val() != "" && $("#sampai_kalendar").val() != ""){
        $.post("/pkpt/surat_perintah/check_jadwal", {"id_wilayah": $(".wilayah").val(), "dari" : $("#dari_kalendar").val(), "sampai": $("#sampai_kalendar").val(), "sp_id" : "{{ isset($data->id) ? $data->id : 0}}" }, function(res){
            if(res.data != null && res.data.length > 0){
              $("#jadwal_warning").show();
            }
        });
      }
    }

    $(document).on('click', ".delete-anggota", function(){
      $(this).parent().closest("tr").remove();
    });

    function get_sasaran(){
      var id = $("select[name='kegiatan']").val();
      $("select[name='sasaran']").html('');

      $.get("{{url('')}}/mst/sasaran/get_sasaran_by_id_kegiatan?id=" + id, function(data) {
        // console.log(data);
        $.each(data, function(idx, val){
          var option = "<option value='"+val.id+"'>"+val.nama+"</option>";
          $("select[name='sasaran']").append(option);
        });
      });
    }

    get_sasaran();

    $("select[name='kegiatan']").on('change', function() {
      get_sasaran();
    });

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

    $("select[name='wilayah']").on('change', function(){
      get_pd();
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
      $("#cover-sasaran").append(am);
    });

    $(document).on('click', ".remove-sasaran", function(){
      $(this).parent().closest("tr").remove();
    });

  });
</script>
@endsection
