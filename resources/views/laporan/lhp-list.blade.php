@extends('layouts.app')
@section('content')

<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="#">Surat Perintah</a>
    <span class="breadcrumb-item active">LHP</span>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">LHP</h4>
</div>

<div class="br-pagebody">
  @if(Session::has('message'))
  <div class="row">
    <div class="alert alert-success col-lg-12">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="d-flex align-items-center justify-content-start">
        <span>{!! Session::get('message') !!}</span>
      </div>
    </div>
  </div>
  @endif

  <div class="row">
    <div class="col-lg-12 widget-2 px-0">
      <div class="card shadow-base">
        <div class="card-header">
          <h6 class="card-title float-left">Daftar LHP</h6>
          <div class="float-right">

            @if(can_access("pkpt_surat_perintah", "add"))
            <a class='btn btn-sm btn-success' href='{{url()->current()}}/add/1'><i class='menu-item-icon icon ion-plus'></i> Tambah</a>
            @endif
          </div>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped responsive" id="oTable" style="width:100%">
            <thead>
              <tr>
                <th>Irban</th>
                <th>Kegiatan</th>
                <th>Sasaran</th>
                <th>Dari</th>
                <th>Sampai</th>
                <th style='width:195px'>Aksi</th>
              </tr>
            </thead>
          </table>
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
        { data: 'wilayah', name: 'wilayah'},
        { data: 'kegiatan', name: 'kegiatan'},
        { data: 'sasaran', name: 'sasaran'},
        { data: 'dari', name: 'sp.dari', render: function(data, type, row){
          var x = new Date(data);
          return moment(x).format("DD-MM-YYYY");
        }},
        { data: 'sampai', name: 'sp.sampai', render: function(data, type, row){
          var x = new Date(data);
          return moment(x).format("DD-MM-YYYY");
        }},
        { data: null, name:null, orderable: false, render: function ( data, type, row ) {
          var return_button = "";
          @if(can_access("pkpt_surat_perintah", "edit"))
          return_button += "<a class='btn btn-warning btn-xs' href='{{url()->current()}}/edit/" + data.id + "'><i class='fa fa-pencil'></i> Edit</a> ";
          @endif
          @if(can_access("pkpt_surat_perintah", "delete"))
          return_button += "<a class='btn btn-danger btn-xs' href='{{url()->current()}}/delete/" + data.id + "' onclick='return confirm(\"Apakah anda ingin menghapus data ini?\")'><i class='fa fa-close'></i> Hapus</a>";
          @endif

          if(data.is_approve == 0){
            return_button += "<a class='btn btn-success btn-xs' href='{{url()->current()}}/approve/" + data.is_pkpt + "/" + data.id + "'><i class='fa fa-check'></i> Approve</a>";
          }

          return_button += " <a class='btn btn-info btn-xs' href='{{url()->current()}}/info/" + data.id + "'><i class='fa fa-eye'></i> Detail</a>";
          return return_button == "" ? "-" : return_button;
        }},
      ],
      columnDefs: [
      {
        targets: 5,
        className: "text-center",
     }],
  });

  $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

  setTimeout(function() {
    $(".alert-success").hide(1000);
  }, 3000);

});
</script>
@endsection
