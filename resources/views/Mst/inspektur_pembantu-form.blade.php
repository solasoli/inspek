@extends('layouts.app')
@section('content')
<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="/">Master</a>
    <a class="breadcrumb-item Active" href="#">OPD</a>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">Inspektur Pembantu</h4>
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
                  <option value="">- Pilih Disini</option> 
                  @foreach($wilayah as $idx => $row)
                  @php
                  $selected = !is_null(old('wilayah')) && old('wilayah') == $row->id ? "selected" : (isset($wilayah_selected->id) && $row->id == $wilayah_selected->id ? 'selected' : '');
                  @endphp
                  <option value='{{$row->id}}' {{$selected}}>{{$row->nama}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            @if(isset($wilayah_selected->id))
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Inspektur
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                {{$wilayah_selected->nama_inspektur}}
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    @if(isset($wilayah_selected->id))
    <div class="row mg-y-10">
      <div class="col-lg-12 widget-2 px-0">
        <div class="card shadow-base">

          <div class="card-header">
            <h6 class="card-title float-left py-2">LIST INSPEKTUR PEMBANTU</h6>
          </div>
          <div class="card-body">

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Nama Inspektur Pembantu</th>
                      <th style="width:60px"></th>
                    </tr>
                  </thead>
                  <tbody id='cover-pegawai'>
                    @if((isset($data) && $data->count() == 0) || !isset($data))
                    <tr>
                      <td>
                        <select name='pegawai[]' class="form-control select2">
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

                      @foreach($data as $i => $r)
                        <tr>
                          <td>
                            <select name='pegawai[]' class="form-control select2">
                              @foreach($pegawai as $idx => $row)
                                @php
                                $selected = $row->id == $r->id_inspektur_pembantu ? "selected" : "";
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
                      <button type="button" class="btn btn-info add-pegawai btn-block"> Tambah Inspektur Pembantu</button>
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
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif

  </div>

</form>
<script>
  var addMorePegawai = "<tr>";
  addMorePegawai += "<td>";
  addMorePegawai += "<select name='pegawai[]' class='form-control select2'>";
  addMorePegawai += "<option value=''>- Pilih Disini -</option>";
  @foreach($pegawai as $idx => $row)
    addMorePegawai += "<option value='{{$row->id}}'>{{$row->nama}}</option>";
  @endforeach
  addMorePegawai += "</select>";
  addMorePegawai += "</td>";
  addMorePegawai += "<td>";
  addMorePegawai += "<button type='button' class='btn btn-danger btn-xs delete-opd'><i class='fa fa-close'></i></button>";
  addMorePegawai += "</td>";
  addMorePegawai += "</tr>";

  $(function(){
    $(".wilayah").on('change', function(){
      location.href = "/mst/inspektur_pembantu/form/" + $(this).val();
    })

    $(".add-pegawai").on('click', function(){
        $("#cover-pegawai").append(addMorePegawai);

        $("#cover-pegawai tr:last .select2").select2();
    });

    $(document).on('click', ".delete-opd", function(){
      $(this).parent().closest("tr").remove();
    });

  });
</script>
@endsection
