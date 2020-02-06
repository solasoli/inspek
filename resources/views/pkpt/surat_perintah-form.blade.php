@extends('layouts.app')
@section('content')
<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="/">Master</a>
    <a class="breadcrumb-item Active" href="#">Surat Perintah</a>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">{{ isset($data) ? "Edit" : "Tambah" }} Surat Perintah</h4>
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
            <h6 class="card-title float-left py-2">FORM WILAYAH</h6>
          </div>
          <div class="card-body">
            {{ csrf_field() }}
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Wilayah
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='wilayah' class="form-control select2 wilayah">
                  <option value="" data-nama="-">- Pilih Disini -</option> 
                  @foreach($wilayah as $idx => $row)
                  @php
                  $selected = !is_null(old('wilayah')) && old('wilayah') == $row->id ? "selected" : (isset($wilayah_selected->id) && $row->id == $wilayah_selected->id ? 'selected' : '');
                  @endphp
                  <option value='{{$row->id}}' {{$selected}} data-nama="{{$row->nama_inspektur}}">{{$row->nama}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Inspektur
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12" id="inspektur-ds">
                -
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
                <select name='pengendali_teknis' class="form-control select2">
                  <option value="" data-nama="-">- Pilih Disini -</option> 
                  @foreach($pegawai as $idx => $row)
                  @php
                  $selected = !is_null(old('pengendali_teknis')) && old('pengendali_teknis') == $row->id ? "selected" : (isset($wilayah_selected->id) && $row->id == $wilayah_selected->id ? 'selected' : '');
                  @endphp
                  <option value='{{$row->id}}' {{$selected}} data-nama="{{$row->nama}}">{{$row->nama}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Ketua Tim
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='ketua_tim' class="form-control select2">
                  <option value="" data-nama="-">- Pilih Disini -</option> 
                  @foreach($pegawai as $idx => $row)
                  @php
                  $selected = !is_null(old('ketua_tim')) && old('ketua_tim') == $row->id ? "selected" : (isset($wilayah_selected->id) && $row->id == $wilayah_selected->id ? 'selected' : '');
                  @endphp
                  <option value='{{$row->id}}' {{$selected}} data-nama="{{$row->nama}}">{{$row->nama}}</option>
                  @endforeach
                </select>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>


    <div class="row mg-y-10">
      <div class="col-lg-12 widget-2 px-0">
        <div class="card shadow-base">
          <div class="card-header">
            <h6 class="card-title float-left py-2">FORM DASAR SURAT</h6>
          </div>
          <div class="card-body">
            {{ csrf_field() }}
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Dasar Surat
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea name='dasar_surat' class="form-control">{{ !is_null(old('nama')) ? old('nama') : (isset($data->nama) ? $data->nama : (isset($dasar_surat->dasar_surat) ? $dasar_surat->dasar_surat : '')) }}</textarea>
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
                Sasaran
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='ketua_tim' class="form-control select2">
                  <option value="" data-nama="-">- Pilih Disini -</option> 
                  @foreach($sasaran->where("id_parent",0) as $idx => $row)
                  <optgroup label="{{ $row->nama }}">
                    @foreach($sasaran->where("id_parent", $row->id) as $i => $r)
                      <option value='{{$r->id}}'>{{$r->nama}}</option>
                    @endforeach
                  </optgroup>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Dari
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="input-group">
                  <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                  <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY">
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
                  <input type="text" class="form-control fc-datepicker" placeholder="MM/DD/YYYY">
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>


    <div class="row mg-y-10">
      <div class="col-lg-12 widget-2 px-0">
        <div class="card shadow-base">

          <div class="card-header">
            <h6 class="card-title float-left py-2">LIST ANGGOTA</h6>
          </div>
          <div class="card-body">

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
                  <tbody id='cover-opd'>
                    @if((isset($list_opd) && $list_opd->count() == 0) || !isset($list_opd))
                    <tr>
                      <td>
                        <select name='opd[]' class="form-control select2">
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

                      @foreach($list_opd as $i => $r)
                        <tr>
                          <td>
                            <select name='opd[]' class="form-control select2">
                              @foreach($pegawai as $idx => $row)
                                @php
                                $selected = $row->id == $r->id_skpd? "selected" : "";
                                @endphp
                                <option value='{{$row->id}}' {{$selected}}>{{$row->nama}}</option>
                              @endforeach
                            </select>
                          </td>
                          <td>
                            @if($x > 1)
                            <button type='button' class='btn btn-danger btn-xs delete-opd'>
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
                      <button type="button" class="btn btn-info add-opd"> Tambah Anggota</button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mg-y-10">
      <div class="col-lg-12 widget-2 px-0">
        <div class="card shadow-base">
          <div class="card-body">

            <div class="form-group row mt-4 d-flex justify-content-center">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a href='{{url('')}}/pkpt/surat_perintah' class="btn btn-danger" type="button">Cancel</a>
                <button type="submit" class="btn btn-primary" disabled="">Submit</button>
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
  addMoreOpd += "<select name='opd[]' class='form-control select2'>";
  addMoreOpd += "<option value=''>- Pilih Disini -</option>";
  @foreach($pegawai as $idx => $row)
    addMoreOpd += "<option value='{{$row->id}}'>{{$row->nama}}</option>";
  @endforeach
  addMoreOpd += "</select>";
  addMoreOpd += "</td>";
  addMoreOpd += "<td>";
  addMoreOpd += "<button type='button' class='btn btn-danger btn-xs delete-opd'><i class='fa fa-close'></i></button>";
  addMoreOpd += "</td>";
  addMoreOpd += "</tr>";

  $(function(){
    $('.fc-datepicker').datepicker();
    $(".add-opd").on('click', function(){
        $("#cover-opd").append(addMoreOpd);

        $("#cover-opd tr:last .select2").select2();
    });

    $(".wilayah").on("change", function(){
      var nama = $(this).find("option:selected").data("nama");
      $("#inspektur-ds").html(nama);
      get_inspektur_pembantu($(this));
    });

    function get_inspektur_pembantu(el){
      $.post("/mst/inspektur_pembantu/get_inspektur_pembantu_by_wilayah", {"id_wilayah": $(el).val()}, function(res){
        if(res.data != null){
          $(".inspektur_pembantu").html('');
          $.each(res.data, function(idx, val){
            $(".inspektur_pembantu").append("<option value='" + val.id +"'>" + val.nama_inspektur + "</option>");
          });
        }
      });
    }

    $(document).on('click', ".delete-opd", function(){
      $(this).parent().closest("tr").remove();
    });

  });
</script>
@endsection
