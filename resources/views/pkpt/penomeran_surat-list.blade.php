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
    <a class="breadcrumb-item" href="#">PKPT</a>
    <span class="breadcrumb-item active">Penomeran Surat Perintah</span>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <div class="row">
    <div class="col-6">
      <h4 class="tx-gray-800 mg-b-5">Penomeran Surat Perintah</h4>
    </div>

    <div class="col-6 text-right">
      <button type="button" class='btn btn-info' id='print-page'><i class='fa fa-print'></i> Print</button>
      <button type="button" class='btn btn-info' id='download-excel'><i class="fa fa-file-excel-o"></i> Download Excel</button>
    </div>
  </div>
</div>

{{-- Modal pilihan  --}}
<div class="modal" id="modal_pilihan">
  <div class="modal-dialog modal-lg col-md-6" style="min-width: 600px">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Print Program Kerja Pengawasan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form class="form-layout form-layout-5">
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Untuk <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id='tahun_print' class="form-control">
                <option value='0'>Belum Memiliki Nomor</option>
                <option value='1'>Sudah Memiliki Nomor</option>
              </select>
            </div>
          </div>
          <div class="form-group row mt-4 d-flex justify-content-center">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary confirm-print"></button>
            </div>
          </div>
        </form>
      </div>

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
          <h6 class="card-title float-left">Daftar Surat Perintah</h6>
          <div class="float-right">
          </div>
        </div>
        <div class="card-body">


          <ul class="nav nav-tabs nav-justified mb-4">
            <li class="nav-item"><a href="#not_avail" class="nav-link rounded-top font-weight-bold active show" data-toggle="tab">Belum Memiliki nomor</a></li>
            <li class="nav-item"><a href="#avail" class="nav-link rounded-top font-weight-bold" data-toggle="tab">Sudah Memiliki nomor</a></li>
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
@include('pkpt.penomeran_surat-form')

@endsection

@section('scripts')
<!-- Datatables -->
<script src="{{ asset('admin_template/lib/datatables/jquery.dataTables.js') }}"></script>
<script>
$(function() {

  var urlPrint = ''

  $("#print-page").on('click', function() {
    $(".confirm-print").html($(this).html());
    urlPrint = "{{url()->current()}}/print/html"
    $("#modal_pilihan").modal('show');
  })

  $("#download-excel").on('click', function() {
    $(".confirm-print").html($(this).html());
    urlPrint = "{{url()->current()}}/print/excel"
    $("#modal_pilihan").modal('show');
  })

  $(".confirm-print").on('click', function() {
    window.open(urlPrint + "/" + $('#tahun_print').val())
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
      ajax: '{{URL::to('pkpt/surat_perintah/datatables_penomeran_api/0')}}',
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
          return_button += " <a class='btn btn-success btn-xs btn-modal-nomer' data-toggle='modal' data-target='#nomerModal' data-id='" + data.id + "' href='#'><i class='fa fa-edit'></i> Beri nomer</a>";
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
      ajax: '{{URL::to('pkpt/surat_perintah/datatables_penomeran_api/1')}}',
      columns: [
        { data: 'no_surat', name: 'no_surat'},
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
          return_button += " <a class='btn btn-success btn-xs btn-modal-nomer' data-toggle='modal' data-target='#nomerModal' data-id='" + data.id + "' data-nomer='" + data.no_surat + "' href='#'><i class='fa fa-edit'></i> Rubah nomer</a>";
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
