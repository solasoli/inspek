@extends('layouts.app')
@section('content')
<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="#">Developer Setting</a>
    <span class="breadcrumb-item active">Config</span>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">Config</h4>
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

  <form method="post">
    {{ csrf_field() }}
    <div class="row mb-4">
      <div class="col-lg-12 widget-2 px-0">
        <div class="card shadow-base">
          <div class="card-header">
            <h6 class="card-title float-left py-2">Form</h6>
          </div>
          <div class="card-body">
            <div class="form-layout form-layout-5">
              <div class="form-group row">
                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">Nama Config : <span class="tx-danger">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input name='nama' autocomplete="off" value='{{ !is_null(old('nama')) ? old('nama') : (isset($data->nama) ? $data->nama : '') }}' required="required" class="form-control" type="text">
                </div>
              </div>
              <div class="form-group row">
                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">Kode Config : <span class="tx-danger">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input name='kode' autocomplete="off" value='{{ !is_null(old('kode')) ? old('kode') : (isset($data->kode) ? $data->kode : '') }}' required="required" class="form-control" type="text">
                </div>
              </div>
            </div>
            <table class="table" width="100%" border="0">
              <tr>
                <th class="tx-center">Label</th>
                <th class="tx-center">Column in DB</th>
                <th width="5%">&nbsp;</th>
              </tr>
              <tbody id="addmore_container">
                @if (is_array(old('label')))
                  @foreach (old('label') AS $idx => $val)
                    <tr>
                      <td><input type='text' name='label[]' class='form-control' value="{{ $val }}"></td>
                      <td><input type='text' name='column_in_db[]' class='form-control' value="{{ old('column_in_db')[$idx] }}"></td>
                      <td><i class='fa fa-times remove_field' style='cursor: pointer; color:red'></i></td>
                    </tr>
                  @endforeach
                @endif

                @if (isset($data->nama))
                  @foreach ($data_detail AS $idx => $row)
                  <tr>
                    <td><input type='text' name='label[]' class='form-control' value="{{ $row->label }}"></td>
                    <td><input type='text' name='column_in_db[]' class='form-control' value="{{ $row->column_in_db }}"></td>
                    <td><i class='fa fa-times remove_field' style='cursor: pointer; color:red'></i></td>
                  </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
            <button type="button" class="btn btn-info" id="addmore_button">+ add more</button>
          </div>
        </div>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-lg-12 widget-2 px-0">
        <div class="card shadow-base">
          <div class="card-body">
            <div class="form-group row mt-4 d-flex justify-content-center">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a href='{{url('')}}/dev/config' class="btn btn-secondary" type="button">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

</div>
@endsection

@section('scripts')
<script>

$(function() {

  setTimeout(function() {
    $(".alert-success").hide(1000);
  }, 3000);

  remove_field();
  function remove_field() {
    $(".remove_field").on('click', function(){
      $(this).closest('tr').remove();
    });
  }

  $("#addmore_button").on("click", function(){
    var html = "";
    html += "<tr>";
    html += "<td><input type='text' name='label[]' class='form-control'></td>";
    html += "<td><input type='text' name='column_in_db[]' class='form-control'></td>";
    html += "<td><i class='fa fa-times remove_field' style='cursor: pointer; color:red'></i></td>";
    html += "</tr>";

    $("#addmore_container").append(html);

    remove_field();
  });



});
</script>
@endsection
