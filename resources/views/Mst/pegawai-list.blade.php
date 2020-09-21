
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
    <span class="breadcrumb-item active">Pegawai</span>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">Pegawai</h4>
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
          <h6 class="card-title float-left">List Pegawai</h6>
          <div class="float-right">

            @if(can_access("mst_skpd", "add"))
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addModal"><i class='menu-item-icon icon ion-plus'></i> Tambah</button>
            @endif
          </div>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped" id="users-table" style="width:100%">
             <thead>
                 <tr>
                     <th>Nama</th>
                     <!-- <th>OPD</th> -->
                     <!-- <th>Eselon</th> -->
                     <!-- <th>Pangkat</th> -->
                     <th>Pangkat Golongan</th>
                     <th>Jabatan</th>
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
@include('Mst.pegawai-form_add')

<!-- modal edit -->
@include('Mst.pegawai-form_edit')
@endsection

@section('scripts')
<!-- DataTables -->
<script src="{{ asset('admin_template/lib/datatables/jquery.dataTables.js') }}"></script>
<script>

$(function() {
  $('#users-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{url()->current()}}/datatables/',
      columns: [
        { data: 'nama', name: 'p.nama' },
        // { data: 'opd', name: 'skpd.name' },
        // { data: 'eselon', name: 'e.name' },
        // { data: 'pangkat', name: 'pk.name' },
        { data: 'pangkat_golongan', name: 'pg.name' },
        { data: 'jabatan', name: 'j.name' },
        { data: null, orderable: false, searchable: false,  render: function ( data, type, row ) {
          var return_button = "";
          @if(can_access("master_periode", "edit"))
          return_button += "<button class='btn btn-warning btn-xs' data-toggle='modal' data-target='#editModal' data-id='" + data.id + "'><i class='fa fa-pencil'></i> Edit</button> ";
          @endif
          @if(can_access("master_periode", "delete"))
          return_button += "<a class='btn btn-danger btn-xs' href='{{url()->current()}}/delete/" + data.id + "' onclick='return confirm(\"Apakah anda ingin menghapus data ini?\")'><i class='fa fa-close'></i> Hapus</a>";
          @endif
          return return_button == "" ? "-" : return_button;
        }},
      ]
  });

  setTimeout(function() {
    $(".alert-success").hide(1000);
  }, 3000);

  $('#addModal, #editModal').on('show.bs.modal', function () {
    $(this).find('form').trigger('reset');
  });

});
</script>
@endsection
