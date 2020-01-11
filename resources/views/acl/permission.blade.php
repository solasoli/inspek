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
                  @foreach($role as $idx => $row)
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
            <table class="table table-bordered table-striped" id="users-table" style="width:100%">
              <tr>
                <th style="width: 1px;white-space: nowrap;">#</th>
                <th>Menu</th>
                <th style="width: 1px;white-space: nowrap;">View</th>
                <th style="width: 1px;white-space: nowrap;">Add</th>
                <th style="width: 1px;white-space: nowrap;">Edit</th>
                <th style="width: 1px;white-space: nowrap;">Delete</th>
              </tr>
              @foreach($menu as $idx => $row)
              @php
              $view_checked = isset($data_array['view'][$row->id]) && $data_array['view'][$row->id] == 1 ? "checked" : "";
              $add_checked = isset($data_array['add'][$row->id]) && $data_array['add'][$row->id] == 1 ? "checked" : "";
              $edit_checked = isset($data_array['edit'][$row->id]) && $data_array['edit'][$row->id] == 1 ? "checked" : "";
              $delete_checked = isset($data_array['delete'][$row->id]) && $data_array['delete'][$row->id] == 1 ? "checked" : "";
              @endphp
              <tr>
                <td>{{$row->id}}</td>
                <td>{{$row->nama}} <input type="hidden" name="menu[]" value={{$row->id}}></td>
                <td align="center"><input name="view[{{$row->id}}]" type="checkbox" value="1" {{$view_checked}}></td>
                <td align="center"><input name="add[{{$row->id}}]" type="checkbox" value="1" {{$add_checked}}></td>
                <td align="center"><input name="edit[{{$row->id}}]" type="checkbox" value="1" {{$edit_checked}}></td>
                <td align="center"><input name="delete[{{$row->id}}]" type="checkbox" value="1" {{$delete_checked}}></td>
              </tr>
              @endforeach
            </table>
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
});
</script>
@endsection
