@extends('layouts.app')
@section('content')

<style type="text/css">
  .table th, .table td {
    white-space: nowrap;
  }

  .table-responsive {
    overflow-y: auto;
  }

  .form-inline.dt-bootstrap {
    display: block !important;
  }
</style>

<div class="modal" id="type_pkpt_modal">
  <div class="modal-dialog modal-lg col-md-6" style="min-width: 600px">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Buat Surat Perintah Untuk</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form class="form-layout form-layout-5">
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Type <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id='type_pkpt_confirm' class="form-control">
                @foreach($type_pkpt as $row)
                  <option value='{{ $row->id }}'>{{ $row->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row mt-4 d-flex justify-content-center">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary confirm-add">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="#">Surat Perintah</a>
    <span class="breadcrumb-item active">Surat Perintah</span>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">Surat Perintah</h4>
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
          <h6 class="card-title float-left">Daftar Surat Perintah</h6>
          <div class="float-right">

            @if(can_access("sp_surat_perintah", "add"))
            <a class='btn btn-sm btn-success' href='#' data-toggle='modal' data-target='#type_pkpt_modal'><i class='menu-item-icon icon ion-plus'></i> Tambah</a>
            @endif
          </div>
        </div>
        <div class="card-body">

          <ul class="nav nav-tabs nav-justified mb-4">
            <li class="nav-item"><a href="#not_approved" class="nav-link rounded-top font-weight-bold active show" data-toggle="tab">Belum Disetujui</a></li>
            <li class="nav-item"><a href="#approved" class="nav-link rounded-top font-weight-bold" data-toggle="tab">Sudah Disetujui</a></li>
          </ul>

          <div class="tab-content">

            <div class="tab-pane fade active show" id="not_approved">
              <div class="table-responsive">
                <table class="table table-bordered table-striped responsive" id="oTable" style="width:100%">
                  <thead>
                    <tr>
                      <th>Type</th>
                      <th>Irban</th>
                      <th>Kegiatan</th>
                      <th>Sasaran</th>
                      <th>Dari</th>
                      <th>Sampai</th>
                      <th>Status</th>
                      <th style='width:195px'>Aksi</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>

            <div class="tab-pane fade" id="approved">
              <div class="table-responsive">
                <table class="table table-bordered table-striped responsive" id="oTableApprove" style="width:100%">
                  <thead>
                    <tr>
                      <th>Type</th>
                      <th>Irban</th>
                      <th>Kegiatan</th>
                      <th>Sasaran</th>
                      <th>Dari</th>
                      <th>Sampai</th>
                      <th>Status</th>
                      <th>Hasil</th>
                      <th style='width:195px'>Aksi</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>

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
<script src="{{ asset('admin_template/lib/datatables/dataTables.bootstrap.min.js') }}"></script>
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
      ajax: '{{url()->current()}}/datatables_approve/0',
      columns: [
        { data: 'is_pkpt', name: 'is_pkpt', render: function(data, type, row){
          return data == 2 ? 'Non-PKPT' : 'PKPT';
        }},
        { data: null, name:null, orderable: false, render: function ( data, type, row ) {
          const wilayah = []
          if(data.program_kerja != null) { 
            if(data.program_kerja.is_lintas_irban == 1) {
              return 'Lintas Irban'
            } else if(data.wilayah != null && data.program_kerja.is_lintas_irban == 0) {
              for (const wly of data.wilayah) {
                wilayah.push(wly.nama)
              }
              return wilayah.join(', ');
            }
          }
          return '-'
        }},
        { data: 'kegiatan.nama', name: 'kegiatan.nama'},
        { data: null, name: null, orderable: false, render: function(data, type, row) {
          return data.program_kerja != null ? data.program_kerja.sasaran : '-'
        }},
        { data: 'dari', name: 'dari', render: function(data, type, row){
          var x = new Date(data);
          return moment(x).format("DD-MM-YYYY");
        }},
        { data: 'sampai', name: 'sampai', render: function(data, type, row){
          var x = new Date(data);
          return moment(x).format("DD-MM-YYYY");
        }},
        { data: null, name: 'is_approve', render: function(data, type, row){
          return data.is_approve == 1 ? "<span class='text-success'>Sudah Disetujui</span>" : "<span class='text-danger'>Belum Disetujui</span>";
        }},
        { data: null, name:null, orderable: false, render: function ( data, type, row ) {
          var return_button = "";
          @if(can_access("sp_surat_perintah", "edit"))
          return_button += "<a class='btn btn-warning btn-xs' href='{{url()->current()}}/edit/" + data.id + "'><i class='fa fa-pencil'></i> Edit</a> ";
          @endif
          @if(can_access("sp_surat_perintah", "delete"))
          return_button += "<a class='btn btn-danger btn-xs' href='{{url()->current()}}/delete/" + data.id + "' onclick='return confirm(\"Apakah anda ingin menghapus data ini?\")'><i class='fa fa-close'></i> Hapus</a> ";
          @endif

          if(data.is_approve == 0){
            @if(can_access("sp_surat_perintah", "additional"))
            return_button += "<a class='btn btn-success btn-xs' href='{{url()->current()}}/approve/" + data.id + "'><i class='fa fa-check'></i> Setuju</a> ";
            @endif
          }

          if(data.is_lampiran == 1) {
            return_button += " <a class='btn btn-info btn-xs' href='{{url()->current()}}/info/is_lampiran/" + data.id + "'><i class='fa fa-eye'></i> Rinci</a>";
            return return_button == "" ? "-" : return_button;
          }else {
            return_button += " <a class='btn btn-info btn-xs' href='{{url()->current()}}/info/" + data.id + "'><i class='fa fa-eye'></i> Rinci</a>";
            return return_button == "" ? "-" : return_button;
          }
        }},
      ],
      columnDefs: [
      {
        targets: 7,
        className: "text-center",
     }],
  });

  // non PKPT
   $('#oTableApprove').DataTable({
    language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
      },
      responsive: true,
      processing: true,
      serverSide: true,
      ajax: '{{url()->current()}}/datatables_approve/1',
      columns: [
        { data: 'is_pkpt', name: 'is_pkpt', render: function(data, type, row){
          console.log(data.is_pkpt);
          return data == 2 ? 'Non-PKPT' : 'PKPT';
        }},
        { data: null, name:null, orderable: false, render: function ( data, type, row ) {
          const wilayah = []
          
          if(data.program_kerja != null) { 
            if(data.program_kerja.is_lintas_irban == 1) {
              return 'Lintas Irban'
            } else if(data.wilayah != null && data.program_kerja.is_lintas_irban == 0) {
              for (const wly of data.wilayah) {
                wilayah.push(wly.nama)
              }
              return wilayah.join(', ');
            }
          }

          return ''
        }},
        { data: 'kegiatan.nama', name: 'kegiatan.nama'},
        { data: null, name: null, orderable: false, render: function(data, type, row) {
          return data.program_kerja != null ? data.program_kerja.sasaran : '-'
        }},
        { data: 'dari', name: 'dari', render: function(data, type, row){
          var x = new Date(data);
          return moment(x).format("DD-MM-YYYY");
        }},
        { data: 'sampai', name: 'sampai', render: function(data, type, row){
          var x = new Date(data);
          return moment(x).format("DD-MM-YYYY");
        }},

        { data: null, name: 'is_approve', render: function(data, type, row){
          return data.is_approve == 1 ? "<span class='text-success'>Approved</span>" : "<span class='text-danger'>Belum Disetujui</span>";
        }},
        { data: null, name: 'is_approve', render: function(data, type, row){
          return data.is_approve == 1 ? "<span class='text-success'>Selesai</span>" : "<span class='text-danger'>Belum Selesai</span>";
        }},
        { data: null, name:null, orderable: false, render: function ( data, type, row ) {
          var return_button = "";
          @if(can_access("sp_surat_perintah", "edit"))
          return_button += "<a class='btn btn-warning btn-xs' href='{{url()->current()}}/edit/" + data.id + "'><i class='fa fa-pencil'></i> Edit</a> ";
          @endif
          @if(can_access("sp_surat_perintah", "delete"))
          return_button += "<a class='btn btn-danger btn-xs' href='{{url()->current()}}/delete/" + data.id + "' onclick='return confirm(\"Apakah anda ingin menghapus data ini?\")'><i class='fa fa-close'></i> Hapus</a> ";
          @endif


          return_button += " <a class='btn btn-info btn-xs' href='{{url()->current()}}/info/" + data.id + "'><i class='fa fa-eye'></i> Detail</a>";
          return return_button == "" ? "-" : return_button;
        }},
      ],
      columnDefs: [
      {
        targets: 8,
        className: "text-center",
     }],
  });

  $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

  $(".nav-link").on('click', function(){
    if($(this).attr('href') == '#not_approved') {
      $(".tab-pane#not_approved").fadeIn();
      $(".tab-pane#approved").hide();
    } else {

      $(".tab-pane#not_approved").hide();
      $(".tab-pane#approved").fadeIn();
    }
  })

  setTimeout(function() {
    $(".alert-success").hide(1000);
  }, 3000);

  $(".confirm-add").on('click', function(){
    location.href='{{ URL::to('/pkpt/surat_perintah/add/')}}/' + $('#type_pkpt_confirm').val();
  })
});
</script>
@endsection
