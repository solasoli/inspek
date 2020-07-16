@extends('layouts.app')
@section('content')
<style media="screen">
  .modal-lg{ width: 100% !important; }
  .ui-datepicker{ z-index:99999 !important; }

  .table th, .table td {
    white-space: nowrap;
  }

  .table-responsive {
    overflow-y: auto;
  }
</style>
<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="#">Master</a>
    <span class="breadcrumb-item active">Sasaran</span>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">Sasaran</h4>
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
          <h6 class="card-title float-left">List Sasaran</h6>
          <div class="float-right">

            @if(can_access("mst_kegiatan", "add"))
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addModal">Tambah</button>
            @endif
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped responsive" id="oTable" style="width:100%">
              <thead>
                <tr>
                  <th>Nama Kegiatan</th>
                  <!-- <th>Singkatan PD</th> -->
                  <th>Perangkat Daerah</th>
                  <th>Nama Sasaran</th>
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

<!-- modal add -->
@include('Mst.sasaran-form_add')

<!-- modal edit -->
@include('Mst.sasaran-form_edit')
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
      { data: 'nama', name: 'k.nama'},
      // { data: 'singkatan_pd', name: 'singkatan_pd'},
      { data: 'nama_skpd', name: 'skpd.name'},
      { data: 'nama_sasaran', name: 's.nama'},
      { data: null, orderable: false, render: function ( data, type, row ) {
        var return_button = "";
        @if(can_access("mst_kegiatan", "edit"))
        return_button += "<button class='btn btn-warning btn-xs' data-toggle='modal' data-target='#editModal' data-idkegiatan='" + data.id + "'><i class='fa fa-pencil'></i> Edit</button> ";
        @endif
        @if(can_access("mst_kegiatan", "delete"))
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

    $('#addModal, #editModal').on('show.bs.modal', function () {
      $(this).find('form').trigger('reset');
    });

  });
</script>
@endsection
