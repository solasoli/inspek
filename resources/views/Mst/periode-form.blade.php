@extends('layouts.app')

@section('content')

<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="/">Master</a>
    <a class="breadcrumb-item Active" href="#">Periode</a>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">{{ isset($data) ? "Edit" : "Tambah" }} Periode</h4>
</div>

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
          <h6 class="card-title float-left py-2">FORM Periode</h6>
        </div>
        <div class="card-body">
          <form class="form-layout form-layout-5" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Tahun Periode <span class="required">*</span> :
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input name='periode_awal' autocomplete="off" value='{{ !is_null(old('periode_awal')) ? old('periode_awal') : (isset($data->start_year) ? $data->start_year : '') }}' required="required" class="form-control" type="text" style='width:100px; display:inline'>
                <div style="display:inline;margin-left:10px;margin-right: 10px"> - </div>
                <input name='periode_akhir' autocomplete="off" value='{{ !is_null(old('periode_akhir')) ? old('periode_akhir') : (isset($data->end_year) ? $data->end_year : '') }}' required="required" class="form-control" type="text" style='width:100px;display:inline'>
              </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group row mt-4 d-flex justify-content-center">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a href='{{url('')}}/mst/periode' class="btn btn-danger" type="button">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(function(){

  });
</script>
  @endsection
