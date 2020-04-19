@extends('layouts.app')
@section('content')
<style media="screen">
  .modal-lg{
    width: 750px !important;
  }
</style>
<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="#">Master</a>
    <span class="breadcrumb-item active">Struktur</span>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">Struktur</h4>
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

  <!-- inspektur -->
  <div class="row text-center">
    <div class="col-lg-6 widget-2 px-0" style="margin:0 auto">
      <div class="card shadow-base">
        <div class="card-header">
          <h6 class="card-title" style="margin:0 auto">Inspektur</h6>
        </div>
        <div class="card-body">
          <select class="form-control select2" name='inspektur'>
            
          </select>
        </div>
      </div>
    </div>
  </div>

  <div class="br-pagebody"></div>

  <!-- sekretaris -->
  <div class="row text-center">
    <div class="col-lg-5 widget-2 ">
      <div class="card shadow-base">
        <div class="card-header">
          <h6 class="card-title" style="margin:0 auto">SEKRETARIS</h6>
        </div>
        <div class="card-body">
          <select class="form-control select2" name='inspektur'>
            
          </select>
        </div>
      </div>
    </div>

    <div class="col-lg-7 widget-2 px-0">
      <div class="card shadow-base">
        <div class="card-header">
          <h6 class="card-title" style="margin:0 auto">Inspektur Pembantu</h6>
        </div>
        <div class="card-body">

          <div class="form-group row">
            <label class="form-control-label col-md-12 col-xs-12">Inspektur Pembantu I</label>
            <div class="col-md-12 col-xs-12">
              <select class="form-control select2" name='inspektur'>
                
              </select>
            </div>
          </div>

          <hr />

          <div class="form-group row">
            <label class="form-control-label col-md-12 col-xs-12">Inspektur Pembantu II</label>
            <div class="col-md-12 col-xs-12">
              <select class="form-control select2" name='inspektur'>
                
              </select>
            </div>
          </div>

          <hr />

          <div class="form-group row">
            <label class="form-control-label col-md-12 col-xs-12">Inspektur Pembantu III</label>
            <div class="col-md-12 col-xs-12">
              <select class="form-control select2" name='inspektur'>
                
              </select>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="br-pagebody"></div>

  <div class="row">
    <div class="col-lg-12 widget-2 px-0">
      <div class="card shadow-base">
        <div class="card-header">
          <h6 class="card-title float-left">List Anggota</h6>
          <div class="float-right">
          </div>
        </div>
        <div class="card-body">

          <ul class="nav nav-tabs nav-justified mb-4">
            <li class="nav-item"><a href="#list" class="nav-link rounded-top font-weight-bold active show" data-toggle="tab">Anggota Irban I</a></li>
            <li class="nav-item"><a href="#kalendar" class="nav-link rounded-top font-weight-bold" data-toggle="tab">Anggota Irban II</a></li>
            <li class="nav-item"><a href="#kalendar" class="nav-link rounded-top font-weight-bold" data-toggle="tab">Anggota Irban III</a></li>
          </ul>

          <div class="tab-content">
            <table class="table table-bordered table-striped responsive" id="oTable" style="width:100%">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Jabatan</th>
                  <th>Atasan Langsung</th>
                  <!-- <th>Irban</th>
                  <th>Peran Irban</th> -->
                  <th style='width:150px'>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>


        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<!-- Datatables -->
<script src="{{ asset('admin_template/lib/datatables/jquery.dataTables.js') }}"></script>
<script>
$(function() {
  $('#oTable').DataTable({
    language: {
      searchPlaceholder: 'Search...',
      sSearch: '',
      lengthMenu: '_MENU_ items/page',
    },
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: '{{url()->current()}}/datatables/',
    columns: [
      { data: 'nama', name: 'nama'},
      { data: 'jabatan', name: 'jabatan'},

      { data: null, orderable: false, render: function ( data, type, row ) { // atasan langsung
        var a = "";
        a += "<select class='atasan_langsung'>";
        @foreach($wilayah AS $row)
          var selected = '{{$row->id}}' == row.atasan_langsung ? 'selected' : '';
          a += "<option value='{{$row->id}}' "+ selected +">{{$row->nama}}</option>";
        @endforeach
        a += "</select>";
        return a;
      }},

      { data: null, orderable: false, render: function ( data, type, row ) {
        var f = "";
        f += "<form method='post' action='{{url()->current()}}/edit/"+ row.id +"' class='form-update'>";
        f += '{{ csrf_field() }}';
        f += "<input type='hidden' name='atasan_langsung' class='hidden_atasan_langsung'>";
        f += "<input type='submit' class='btn btn-primary' value='simpan'>";
        f += "</form>";
        return f;
      }},
    ],
    columnDefs: [
      {
        targets: 3,
        className: "text-center",
      }],
    });
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

    $(document).on('submit', '.form-update', function(e){
      e.preventDefault();
      var tr = $(this).parent().parent();

      var atasan_langsung = tr.find($(".atasan_langsung")).val();
      tr.find($(".hidden_atasan_langsung")).val(atasan_langsung);

       e.currentTarget.submit();
    });

    setTimeout(function() {
      $(".alert-success").hide(1000);
    }, 3000);

  });
</script>
@endsection
