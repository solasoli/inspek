@extends('layouts.app')

@section('content')

<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="#">ACL</a>
    <span class="breadcrumb-item active">Menu</span>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">Menu</h4>
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
          <h6 class="card-title float-left">Data Menu</h6>
          <div class="float-right">
            <a class='btn btn-sm btn-success' href='{{url()->current()}}/add'><i class='fa fa-sm fa-plus'></i> Tambah</a>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped responsive" id="oTable" style="width:100%">
           <thead>
             <tr>
               <th>Nama Menu</th>
               <th>Parent</th>
               <th>Slug</th>
               <th>URL</th>
               <th style='width:150px'>Aksi</th>
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
<!-- DataTables -->
<script src="{{ asset('admin_template/lib/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('admin_template/lib/datatables-responsive/dataTables.responsive.js') }}"></script>
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
      { data: 'nama', name: 'nama' },
      { data: 'id_parent', name: 'id_parent' },
      { data: 'slug', name: 'slug' },
      { data: 'url', name: 'url' },
      { data: null, orderable: false, render: function ( data, type, row ) {
        var return_button = "<a class='btn btn-warning btn-xs' href='{{url()->current()}}/edit/" + data.id + "'><i class='fa fa-pencil'></i> Edit</a> ";
        return_button += "<a class='btn btn-danger btn-xs' href='{{url()->current()}}/delete/" + data.id + "' onclick='return confirm(\"Apakah anda ingin menghapus data ini?\")'><i class='fa fa-trash'></i> Hapus</a>";
        return return_button;
      }},
    ],
    columnDefs: [
    {
      targets: 4,
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
