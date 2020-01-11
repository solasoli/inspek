@extends('layouts.app')
@section('content')
<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item Active" href="#">Upload Kode Bank</a>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">Upload Kode Bank</h4>
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
          <h6 class="card-title float-left py-2">Step 2</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive mb-4">
            <table class="table table-striped" id="oTable">
              <thead>
                <tr>
                  @foreach($range_column AS $col)
                    <th>{{$col}}</th>
                  @endforeach
                </tr>
              </thead>
              @foreach($data_temp as $idx => $row)
                @php
                $data = json_decode($row->value);
                @endphp

                <tr>
                  @foreach($range_column AS $col)
                    @if(isset($data->$col))
                      <td>{{$data->$col}}</td>
                    @else
                      <td></td>
                    @endif
                  @endforeach
                </tr>
              @endforeach
            </table>
          </div>

          <form class="form-layout form-layout-5" method="post">
            {{ csrf_field() }}
            @foreach($config['config_detail'] as $idx => $row)
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">{{$row->label}} : <span class="tx-danger">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='{{$row->column_in_db}}' class="form-control select2">
                  @foreach($range_column AS $col)
                  <option value="{{$col}}">{{$col}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            @endforeach
            <div class="form-group row mt-4 d-flex justify-content-center">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
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
@section('scripts')
<!-- Datatables -->
<script src="{{ asset('admin_template/lib/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('admin_template/lib/datatables-responsive/dataTables.responsive.js') }}"></script>
<script>
$(function() {
  $('#oTable').DataTable({
    "aaSorting": []
  });
  $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

  setTimeout(function() {
    $(".alert-success").hide(1000);
  }, 3000);

});
</script>
@endsection
