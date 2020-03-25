@extends('layouts.app')
@section('content')
<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="/">Master</a>
    <a class="breadcrumb-item Active" href="#">Kelola Irban</a>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">{{ isset($data) ? "Edit" : "Tambah" }} Irban</h4>
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
                Nama Irban <span class="required">*</span> :
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input name='nama' autocomplete="off" value='{{ !is_null(old('nama')) ? old('nama') : (isset($data->nama) ? $data->nama : '') }}' required="required" class="form-control" type="text" >
              </div>
            </div>

          <div class="card-header">
            <h6 class="card-title float-left py-2">LIST Perangkat daerah</h6>
          </div>
          <div class="card-body">

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th>OPD</th>
                      <th style="width:60px"></th>
                    </tr>
                  </thead>
                  <tbody id='cover-opd'>
                    @if(old("opd") != null)
                      @php 
                        $x = 1;
                      @endphp
                      @foreach(old("opd") as $i => $r)
                        <tr>
                          <td>
                            <select name='opd[]' class="form-control select2">
                              @foreach($skpd as $idx => $row)
                                @php
                                $selected = $row->id == $r ? "selected" : "";
                                @endphp
                                <option value='{{$row->id}}' {{$selected}}>{{$row->name}}</option>
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

                    @elseif((isset($list_opd) && $list_opd->count() == 0) || !isset($list_opd))
                      <tr>
                        <td>
                          <select name='opd[]' class="form-control select2">
                            @foreach($skpd as $idx => $row)
                              <option value='{{$row->id}}'>{{$row->name}}</option>
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
                              @foreach($skpd as $idx => $row)
                                @php
                                $selected = $row->id == $r->id_skpd? "selected" : "";
                                @endphp
                                <option value='{{$row->id}}' {{$selected}}>{{$row->name}}</option>
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
                      <button type="button" class="btn btn-info add-opd"> Tambah OPD</button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="card shadow-base">

          <div class="card-body">

            <div class="form-group row mt-4 d-flex justify-content-center">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a href='{{url('')}}/mst/wilayah' class="btn btn-danger" type="button">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
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
  @foreach($skpd as $idx => $row)
    addMoreOpd += "<option value='{{$row->id}}'>{{$row->name}}</option>";
  @endforeach
  addMoreOpd += "</select>";
  addMoreOpd += "</td>";
  addMoreOpd += "<td>";
  addMoreOpd += "<button type='button' class='btn btn-danger btn-xs delete-opd'><i class='fa fa-close'></i></button>";
  addMoreOpd += "</td>";
  addMoreOpd += "</tr>";

  /* Anggota */
  var addMoreAnggota = "<tr>";
  addMoreAnggota += "<td>";
  addMoreAnggota += "<select name='anggota[]' class='form-control select2'>";
  addMoreAnggota += "<option value=''>- Pilih Disini -</option>";
  @foreach($pegawai as $idx => $row)
    addMoreAnggota += "<option value='{{$row->id}}'>{{$row->nama}}</option>";
  @endforeach
  addMoreAnggota += "</select>";
  addMoreAnggota += "</td>";
  addMoreAnggota += "<td>";
  addMoreAnggota += "<button type='button' class='btn btn-danger btn-xs delete-opd'><i class='fa fa-close'></i></button>";
  addMoreAnggota += "</td>";
  addMoreAnggota += "</tr>";

  $(function(){
    $(".add-opd").on('click', function(){
        $("#cover-opd").append(addMoreOpd);

        $("#cover-opd tr:last .select2").select2();
    });

    $(".add-anggota").on('click', function(){
        $("#cover-anggota").append(addMoreAnggota);

        $("#cover-anggota tr:last .select2").select2();
    });

    $(document).on('click', ".delete-opd", function(){
      $(this).parent().closest("tr").remove();
    });

  });
</script>
@endsection
