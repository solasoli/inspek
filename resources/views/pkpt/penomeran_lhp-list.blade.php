@extends('layouts.app')
@section('content')
<style media="screen">
  .modal-lg{
    width: 750px !important;
  }
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
    <a class="breadcrumb-item" href="#">Pemeriksaan</a>
    <span class="breadcrumb-item active">Penomoran LHP</span>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">Penomoran LHP</h4>
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
          <h6 class="card-title float-left">Daftar Surat Perintah</h6>
          <div class="float-right">
          </div>
        </div>
        <div class="card-body">


          <ul class="nav nav-tabs nav-justified mb-4">
            <li class="nav-item"><a href="#not_avail" class="nav-link rounded-top font-weight-bold active show" data-toggle="tab">Belum Memiliki Nomor</a></li>
            <li class="nav-item"><a href="#avail" class="nav-link rounded-top font-weight-bold" data-toggle="tab">Sudah Memiliki Nomor</a></li>
          </ul>

          <div class="tab-content">

            <div class="tab-pane fade active show" id="not_avail">
              <div class="table-responsive">
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

            <div class="tab-pane fade" id="avail">              
              <div class="table-responsive">
                <table class="table table-bordered table-striped responsive" id="oTableAvail" style="width:100%">
                  <thead>
                    <tr>
                      <th>No. Surat</th>
                      <th>No. LHP</th>
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
    </div>
  </div>

<!-- modal add -->
@include('pkpt.penomeran_lhp-form')

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
      ajax: '{{URL::to('pkpt/surat_perintah/datatables_penomeran_lhp_api/0')}}',
      columns: [
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
        { data: 'program_kerja.sasaran', name: 'program_kerja.sasaran'},
        { data: 'dari', name: 'dari', render: function(data, type, row){
          var x = new Date(data);
          return moment(x).format("DD-MM-YYYY");
        }},
        { data: 'sampai', name: 'sampai', render: function(data, type, row){
          var x = new Date(data);
          return moment(x).format("DD-MM-YYYY");
        }},

        { data: null, name:null, orderable: false, render: function ( data, type, row ) {
          var return_button = "";
          return_button += " <a class='btn btn-success btn-xs btn-modal-nomer' data-toggle='modal' data-target='#nomerModal' data-id='" + data.id + "' href='#'><i class='fa fa-edit'></i> Beri Nomor</a>";
          return return_button == "" ? "-" : return_button;
        }},
      ],
      columnDefs: [
      {
        targets: 5,
        className: "text-center",
     }],
  });


  $('#oTableAvail').DataTable({
    language: {
        searchPlaceholder: 'Search...',
        sSearch: '',
        lengthMenu: '_MENU_ items/page',
      },
      responsive: true,
      processing: true,
      serverSide: true,
      ajax: '{{URL::to('pkpt/surat_perintah/datatables_penomeran_lhp_api/1')}}',
      columns: [
        { data: 'no_surat', name: 'no_surat'},
        { data: 'no_lhp', name: 'no_lhp'},
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
        { data: 'program_kerja.sasaran', name: 'program_kerja.sasaran'},
        { data: 'dari', name: 'dari', render: function(data, type, row){
          var x = new Date(data);
          return moment(x).format("DD-MM-YYYY");
        }},
        { data: 'sampai', name: 'sampai', render: function(data, type, row){
          var x = new Date(data);
          return moment(x).format("DD-MM-YYYY");
        }},


        { data: null, name:null, orderable: false, render: function ( data, type, row ) {
          var return_button = "";
          return_button += " <a class='btn btn-success btn-xs btn-modal-nomer' data-toggle='modal' data-target='#nomerModal' data-id='" + data.id + "' data-nomer='" + data.no_surat + "' href='#'><i class='fa fa-edit'></i> Rubah Nomor</a>";
          return return_button == "" ? "-" : return_button;
        }},
      ],
      columnDefs: [
      {
        targets: 5,
        className: "text-center",
     }],
  });


  $(document).on('click', '.btn-modal-nomer', function() {
    $("#id_penomeran").val($(this).data('id'))
    $(".no-surat").val('');
      if(typeof $(this).data('nomer') != 'undefined') {
        $(".no-surat").val($(this).data('nomer'));
      }
  })

    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

    setTimeout(function() {
      $(".alert-success").hide(1000);
    }, 3000);

    $('#nomerModal').on('show.bs.modal', function () {
      $(this).find('form').trigger('reset');
    });

  });
</script>
@endsection
