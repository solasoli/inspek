@extends('layouts.app')

@section('content')

<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="#">ACL</a>
    <span class="breadcrumb-item active">User</span>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">User</h4>
</div>

<div class="br-pagebody">
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
  @if ($errors->any())
    <div class="row">
      <div class="alert alert-danger col-lg-12">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <ul class="list-unstyled">
          @foreach ($errors->all() as $error)
          <li>
            <div class="d-flex align-items-center justify-content-start">
              <i class="icon ion-ios-close alert-icon mg-t-5 mg-xs-t-0"></i>
              <span>{{ $error }}</span>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif

  <div class="row">
    <div class="col-lg-12 widget-2 px-0">
      <div class="card shadow-base">
        <div class="card-header">
          <h6 class="card-title float-left py-2">Form</h6>
        </div>
        <div class="card-body">
          <form class="form-layout form-layout-5" method="post">
            {{ csrf_field() }}
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">Username : <span class="tx-danger">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input name='username' autocomplete="off" value='{{ !is_null(old('username')) ? old('username') : (isset($data->username) ? $data->username : '') }}' required="required" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">Role : <span class="tx-danger">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='role' class="form-control select2">
                  @foreach($role as $id => $row)

                  @php
                  $selected = !is_null(old('role')) ? old('role') : (isset($data) ? $data->first()->id_role : '');
                  $selected = $selected == $row->id ? "selected" : "";
                  @endphp

                  <option value="{{$row->id}}" {{$selected}}>{{$row->nama}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">E-Mail : <span class="tx-danger">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input name='email' autocomplete="off" value='{{ !is_null(old('email')) ? old('email') : (isset($data->email) ? $data->email : '') }}' required="required" class="form-control" type="email">
              </div>
            </div>
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">Password {!! !isset($data->id) ? '<span class="tx-danger">*</span>' : ''!!} :</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input name='password' autocomplete="off" {!! !isset($data->id) ? 'required' : ''!!} class="form-control" type="text">
                {!! isset($data->id) ? '<span class="tx-danger" align="center">isi Password jika ingin menggantinya</span>' : ''!!}
              </div>
            </div>
            <div class="form-group row mt-4 d-flex justify-content-center">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a href='{{url('')}}/acl/user' class="btn btn-secondary" type="button">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
