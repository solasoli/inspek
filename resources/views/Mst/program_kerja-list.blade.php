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
    <span class="breadcrumb-item active">Program Kerja</span>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">Program Kerja</h4>
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
        <div class="card-body">

          <ul class="nav nav-tabs nav-justified mb-4">
						<li class="nav-item"><a href="#list" class="nav-link rounded-top font-weight-bold active show" data-toggle="tab">List Program Kerja</a></li>
						<li class="nav-item"><a href="#kalendar" class="nav-link rounded-top font-weight-bold" data-toggle="tab">Kalendar</a></li>
					</ul>

					<div class="tab-content">
            <div class="text-right mb-4">
              @if(can_access("mst_skpd", "add"))
              <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#editModal" data-method='add'>Tambah Program Kerja</button>
              @endif
            </div>
						<div class="tab-pane fade active show" id="list">
              <div class="table-responsive">
                <table class="table table-bordered table-striped responsive" id="oTable" style="width:100%">
                  <thead>
                    <tr>
                      <th>Status</th>
                      <th>Kegiatan</th>
                      <th>Irban</th>
                      <th>Perangkat Daerah</th>
                      <th>Dari</th>
                      <th>Sampai</th>
                      <th style='width:150px'>Aksi</th>
                    </tr>
                  </thead>
                </table>
              </div>
						</div>

						<div class="tab-pane fade" id="kalendar">
              @include('Mst.program_kerja-kalendar')
						</div>
					</div>

        </div>
      </div>
    </div>
  </div>
</div>

<script>

  function get_pd(selected_skpd) {
    var id_wilayah = $("select[name='wilayah']").val();
    $.get("{{url('')}}/mst/skpd/get_skpd_by_id_wilayah?id=" + id_wilayah, function(data) {
      $("select[name='opd']").html(''); //
      $.each(data, function(idx, val){
        var selected = selected_skpd > 0 && selected_skpd == val.id ? 'selected' : '';
        var option = "<option value='"+val.id+"' " + selected + ">"+val.name+"</option>";
        $("select[name='opd']").append(option);
      });
    });
  }
</script>
<!-- modal edit -->
@include('Mst.program_kerja-form')

<!-- modal detail -->
@include('Mst.program_kerja-detail')

@endsection

@section('scripts')
<!-- Date range picker -->
<!-- <script type="text/javascript" src="{{ asset('admin_template/lib/daterangepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin_template/lib/daterangepicker/daterangepicker.js') }}"></script> -->
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

        { data: 'type_pkpt', name:'type_pkpt', orderable: false, render: function ( data, type, row ) {
          console.log(data);
          return data == 1 ? 'PKPT' : 'NON-PKPT'
        }},
        { data: 'kegiatan', name: 'kegiatan'},
        { data: 'wilayah', name: 'wilayah'},
        { data: 'skpd', name: 'skpd'},
        { data: 'dari', name:'dari', orderable: false, render: function ( data, type, row ) {
          var x = new Date(data);
          return moment(x).format("DD-MM-YYYY");
        }},
        { data: 'sampai', name:'sampai', orderable: false, render: function ( data, type, row ) {
          var x = new Date(data);
          return moment(x).format("DD-MM-YYYY");
        }},
        { data: null, name:null, orderable: false, render: function ( data, type, row ) {
          var return_button = "";
          @if(can_access("mst_skpd", "edit"))
          return_button += "<button class='btn btn-warning btn-xs' data-toggle='modal' data-target='#editModal' data-method='edit' data-id='" + data.id + "'><i class='fa fa-pencil'></i> Edit</button> ";
          @endif
          @if(can_access("mst_skpd", "delete"))
          return_button += "<a class='btn btn-danger btn-xs' href='{{url()->current()}}/delete/" + data.id + "' onclick='return confirm(\"Apakah anda ingin menghapus data ini?\")'><i class='fa fa-close'></i> Hapus</a>";
          @endif
          return_button += "<button class='btn btn-info btn-xs btn-detail' data-toggle='modal' data-target='#detailModal' data-id='" + data.id + "' data-kegiatan='" + data.kegiatan + "' data-wilayah='" + data.wilayah + "' data-skpd='" + data.skpd + "' data-dari='" + data.dari + "' data-sampai='" + data.sampai + "'><i class='fa fa-eye'></i> Detail</button> ";
          return return_button == "" ? "-" : return_button;
        }},
      ],
      columnDefs: [
      {
        targets: 6,
        className: "text-center",
     }],
  });
  $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

  setTimeout(function() {
    $(".alert-success").hide(1000);
  }, 3000);

  $('#editModal, #detailModal').on('show.bs.modal', function (e) {
    let labelPopup = 'Tambah'
    const elemButton = e.relatedTarget
    if($(elemButton).data('method') == 'edit') {
      labelPopup = 'Edit'
    }
    $("#popup-method-program-kerja").html(labelPopup)
    $(this).find('form').trigger('reset');
    $("#cover-sasaran").html('');
    $("#cover-sasaran_edit").html('');
    $("#cover-sasaran_detail").html('');
  });

});
</script>
@endsection
