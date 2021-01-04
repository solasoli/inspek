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
    <span class="breadcrumb-item active">Perangkat Daerah</span>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <div class="row">
    <div class="col-6">
      <h4 class="tx-gray-800 mg-b-5">Perangkat Daerah</h4>
    </div>

    <div class="col-6 text-right">
      <button type="button" class='btn btn-info' id='print-page'><i class='fa fa-print'></i> Print</button>
      <button type="button" class='btn btn-info' id='download-excel'><i class="fa fa-file-excel-o"></i> Download Excel</button>
    </div>
  </div>
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

  <div class="row">
    <div class="col-lg-12 widget-2 px-0">
      <div class="card shadow-base">
        <div class="card-header">
          <h6 class="card-title float-left">List Perangkat Daerah</h6>
          <div class="float-right">

            @if(can_access("mst_skpd", "add"))
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-form" data-id="0"><i class='menu-item-icon icon ion-plus'></i> Tambah</button>
            @endif

          </div>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped responsive" id="oTable" style="width:100%">
            <thead>
              <tr>
                <th>Nama SKPD</th>
                <!-- <th>Singkatan PD</th> -->
                <th>Pimpinan</th>
                <th>Wilayah Kerja</th>
                <th style='width:150px'>Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal form -->
@include('Mst.skpd-form')
@endsection

@section('scripts')
<!-- Datatables -->
<script src="{{ asset('admin_template/lib/datatables/jquery.dataTables.js') }}"></script>
<script>
$(function() {
  $("#print-page").on('click', function() {
    const windowPrint = window.open("{{url()->current()}}/print/html")
  })
  $("#download-excel").on('click', function() {
    const windowPrint = location.href = "{{url()->current()}}/print/excel"
  })

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
      { data: 'name', name: 'name'},
      // { data: 'singkatan_pd', name: 'singkatan_pd'},
      { data: 'pimpinan', name: 'pimpinan'},
      { data: 'wilayah.nama', name: 'wilayah.nama'},
      { data: null, orderable: false, searchable: false, render: function ( data, type, row ) {
        var return_button = "";
        @if(can_access("mst_skpd", "edit"))
        return_button += "<button class='btn btn-warning btn-xs' data-toggle='modal' data-target='#modal-form' data-id='" + data.id + "'><i class='fa fa-pencil'></i> Edit</button> ";
        @endif
        @if(can_access("mst_skpd", "delete"))
        return_button += "<a class='btn btn-danger btn-xs' href='{{url()->current()}}/delete/" + data.id + "' onclick='return confirm(\"Apakah anda ingin menghapus data ini?\")'><i class='fa fa-close'></i> Hapus</a>";
        @endif
        return return_button == "" ? "-" : return_button;
      }},
    ],
    columnDefs: [
      {
        targets: 3,
        className: "text-center",
      }],
    });
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

    setTimeout(function() {
      $(".alert-success").hide(1000);
    }, 3000);

    $('#modal-form').on('show.bs.modal', function () {
      $(this).find('.error').html('');
      $(this).find('form').trigger('reset');
    });

  });
</script>
@endsection
