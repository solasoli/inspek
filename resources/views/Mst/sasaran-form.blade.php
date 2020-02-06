@extends('layouts.app')
@section('content')
<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="/">Master</a>
    <a class="breadcrumb-item Active" href="#">Sasaran</a>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">{{ isset($data) ? "Edit" : "Tambah" }} Sasaran</h4>
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
            <h6 class="card-title float-left py-2">FORM SASARAN</h6>
          </div>
          <div class="card-body">
            {{ csrf_field() }}

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Parent
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='parent' class="form-control select2">
                  <option value="">- No Parent -</option>
                  @foreach($parent as $idx => $row)
                  @php
                  $selected = !is_null(old('parent')) && old('parent') == $row->id ? "selected" : (isset($data->id_parent) && $row->id == $data->id_parent ? 'selected' : '');
                  @endphp
                  <option value='{{$row->id}}' {{$selected}}>{{$row->nama}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Sasaran <span class="required">*</span> :
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input name='nama' autocomplete="off" value='{{ !is_null(old('nama')) ? old('nama') : (isset($data->nama) ? $data->nama : '') }}' required="required" class="form-control" type="text" >
              </div>
            </div>

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

  $(function(){

  });
</script>
@endsection
