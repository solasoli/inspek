@extends('layouts.app')

@section('content')
<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="#">ACL</a>
    <span class="breadcrumb-item active">Permission</span>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">Permission</h4>
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

  <form method="post">
    {{ csrf_field() }}
    <div class="row mb-4">
      <div class="col-lg-12 widget-2 px-0">
        <div class="card shadow-base">
          <div class="card-body">
            <div class="form-group row form-layout form-layout-5">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">Role :</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="role" class="form-control select2" required="required">
                  @foreach($role->whereNotIn('id', [1]) as $idx => $row)
                  <option value="{{$row->id}}" {{$row->id == $current_role ? "selected" : ""}}>{{$row->nama}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12 widget-2 px-0">
        <div class="card shadow-base">
          <div class="card-header">
            <h6 class="card-title float-left">Permission</h6>
            <div class="float-right">
              <button type="submit" class="btn btn-warning float-right"><i class="fa fa-refresh"></i> Update Permission</button>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped" style="width:100%">
              <tr>
                <th>Menu</th>
                <th style="width: 1px;white-space: nowrap;">View</th>
                <th style="width: 1px;white-space: nowrap;">Add</th>
                <th style="width: 1px;white-space: nowrap;">Edit</th>
                <th style="width: 1px;white-space: nowrap;">Delete</th>
                <th style="width: 1px;white-space: nowrap;">Additional</th>
                <th style="width: 1px;white-space: nowrap;">All</th>
              </tr>
              @foreach($menu->where("level", 1) as $idx => $row)
                @php
                echo generateChildPermission($row->id, $data_array);

                @endphp

              @endforeach
            </table>
            @php
            @endphp
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
$(function(){
  $("select[name='role']").on("change", function(){
    location.href = '/acl/permission/' + $(this).val();
    return false;
  });

  $(document).on('click', ".check_all", function(){
    console.log($(this).is(":checked"));
    $(this).parent().closest("tr").find($("input[type='checkbox']")).prop("checked", $(this).is(":checked"));
  })
});
</script>
@endsection
