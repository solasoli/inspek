@extends('layouts.app')
@section('content')
<style type="text/css">
  .table th, .table td{
    white-space: nowrap;
  }
  .table-responsive {
    overflow-y: auto;
  }
</style>

<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="#">RKA</a>
    <span class="breadcrumb-item active">List</span>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">Rencana Kerja dan Anggaran</h4>
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
          <h6 class="card-title float-left">List Rencana Kerja dan Anggaran</h6>
          <div class="float-right">
            <a class='btn btn-sm btn-success' href='{{url()->current()}}/add'><i class='menu-item-icon icon ion-ios-cloud-upload'></i> Upload</a>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped responsive" id="oTable" style="width:100%">
             <thead>
               <tr>
                 <th>Urusan Pemerintah</th>
                 <th>Organisasi</th>
                 <th>Program</th>
                 <th>Kegiatan</th>
                 <th style='width:150px'>Aksi</th>
               </tr>
             </thead>
             <tfoot>
                 <th>Urusan Pemerintah</th>
                 <th>Organisasi</th>
                 <th>Program</th>
                 <th>Kegiatan</th>
                 <th></th>
               </tfoot>
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
<script src="{{ asset('admin_template/lib/datatables-responsive/dataTables.responsive.js') }}"></script>
<script>
$(function() {
  $('#oTable').DataTable({
    language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
      },
      responsive: false,
      processing: true,
      serverSide: true,
      ajax: '{{url()->current()}}/datatables/',
      columns: [
        { data: 'up_label', name: 'up.label'},
        { data: 'o_label', name: 'o.label'},
        { data: 'p_label', name: 'p.label'},
        { data: 'k_label', name: 'k.label'},
        { data: null, orderable: false, searchable: false, render: function ( data, type, row ) {
          var return_button = "<a class='btn btn-info btn-xs' href='{{url()->to("/")}}/rka/detail/" + data.id + "'><i class='fa fa-eye'></i> Detail</a> ";
          return return_button;
        }},
      ],
      columnDefs: [
      {
        targets: 2,
        className: "text-center",
     }],
     initComplete: function () {
      console.log('wadadaw');
          this.api().columns().every( function (idx) {
              var column = this;
              console.log('index');
              console.log(console.log(idx));
              var list_select = [0,1];
              var list_text = [2,3];
              if(list_select.indexOf(idx) != -1) {
                generate_select_filter_datatables(column);
              }

              if(list_text.indexOf(idx) != -1) {
                generate_text_filter_datatables(column);
              }
          } );
      }
  });


  $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

  setTimeout(function() {
    $(".alert-success").hide(1000);
  }, 3000);

});
</script>
@endsection
