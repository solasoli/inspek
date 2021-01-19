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
    <span class="breadcrumb-item active">Program Kerja Pengawasan</span>
  </nav>
</div>

<div class="modal" id="tahun_print_modal">
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
              Tahun <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id='tahun_print' class="form-control">
                @for($i = $tahun_awal_program_kerja; $i <= date("Y"); $i++)
                  <option value='{{ $i }}'>{{ $i }}</option>
                @endfor
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

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <div class="row">
    <div class="col-6">
      <h4 class="tx-gray-800 mg-b-5">Program Kerja Pengawasan</h4>
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

  <form class="form-layout form-layout-5" id="form-sp" style="padding-top:0" method="get">
    <div class="row">
      <div class="col-lg-12 widget-2 px-0">
        <div class="card shadow-base">
          <div class="card-header">
            <h6 class="card-title float-left">Filter</h6>
          </div>
          <div class="card-body">
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Penanggung Jawab:
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='wilayah_filter' autocomplete="off" class="form-control wilayah_filter">    
                  <option value='0'>- Semua Penanggung Jawab -</option>              
                  @foreach($wilayah as $row) 
                    <option value='{{ $row->id }}' {{ isset($filter['wilayah_filter']) && $filter['wilayah_filter'] == $row->id ? 'selected' : '' }}>{{$row->nama}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Perangkat Daerah :
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">    
                <select name='opd_filter' autocomplete="off" class="form-control perangkat_daerah opd_filter">
                </select>
              </div>
            </div>
            
            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Jenis Pengawasan
                 :
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='jenis_pengawasan_filter' autocomplete="off" class="form-control jenis_pengawasan_filter">    
                  <option value='0'>- Semua Jenis Pengawasan -</option>
                  @foreach($jenis_pengawasan as $row)
                    <option value='{{ $row->id }}' {{ isset($filter['jenis_pengawasan_filter']) && $filter['jenis_pengawasan_filter'] == $row->id ? 'selected' : '' }}>{{$row->nama}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            
            <div class="form-group row d-flex justify-content-center">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 text-right">      
                <button type="submit" class="btn btn-primary" >Filter</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <br>
  <div class="row">
    <div class="col-lg-12 widget-2 px-0">
      <div class="card shadow-base">
        <div class="card-body">

          <ul class="nav nav-tabs nav-justified mb-4">
						<li class="nav-item"><a href="#list" class="nav-link rounded-top font-weight-bold active show" data-toggle="tab">Program Kerja Pengawasan</a></li>
						<li class="nav-item"><a href="#kalendar" class="nav-link rounded-top font-weight-bold" data-toggle="tab">Kalender Program Kerja Pengawasan</a></li>
					</ul>

					<div class="tab-content">
            <div class="text-right mb-4">
              @if(can_access("mst_program_kerja", "add"))
              <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-form"><i class='menu-item-icon icon ion-plus'></i> Tambah Program Kerja</button>
              @endif
            </div>
						<div class="tab-pane fade active show" id="list">
              <div class="table-responsive">
                <table class="table table-bordered table-striped responsive" id="oTable" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Status</th>
                      <th>Nama Kegiatan</th>
                      <th>Jenis Pengawasan</th>
                      <th>Penanggung Jawab</th>
                      <th>Sasaran</th>
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
    }).done(function(){
      $(".opd").trigger('change')
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

  var urlPrint = ''

  $("#print-page").on('click', function() {
    $(".confirm-print").html($(this).html());
    urlPrint = "{{url()->current()}}/print/html"
    $("#tahun_print_modal").modal('show');
  })

  $("#download-excel").on('click', function() {
    $(".confirm-print").html($(this).html());
    urlPrint = "{{url()->current()}}/print/excel"
    $("#tahun_print_modal").modal('show');
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
      ajax: {
        url: '{{url()->current()}}/datatables/',
        data: {
          wilayah: {{ isset($filter['wilayah_filter']) ? $filter['wilayah_filter'] : 0 }},
          opd: {{ isset($filter['opd_filter']) ? $filter['opd_filter'] : 0 }},
          jenis_pengawasan: {{ isset($filter['jenis_pengawasan_filter']) ? $filter['jenis_pengawasan_filter'] : 0 }}
        }
      },
      columns: [
        
        { data: null, orderable: false, render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }  
        },
        { data: 'type_pkpt', name:'type_pkpt', orderable: false, render: function ( data, type, row ) {
          return data == 1 ? 'PKPT' : 'NON-PKPT'
        }},
        // { data: 'kegiatan.nama', name: 'kegiatan.nama'},
        { data: null, name:null, orderable: false, render: function ( data, type, row ) {
          return data.kegiatan != null ? data.kegiatan.nama : '';
        }},
        { data: null, name:null, orderable: false, render: function ( data, type, row ) {
          const jenis_pengawasan = []
          for (const jpn of data.jenis_pengawasan) {
            jenis_pengawasan.push(jpn.nama)
          }

          return jenis_pengawasan.join(', ');
        }},
        // { data: 'wilayah.nama', name: 'wilayah.nama'},
        { data: null, name:null, orderable: false, render: function ( data, type, row ) {
          const wilayah = []
          if(data.is_lintas_irban == 1) {
            return 'Lintas Irban'
          } else if(data.wilayah != null && data.is_lintas_irban == 0) {
            for (const wly of data.wilayah) {
              wilayah.push(wly.nama)
            }
            return wilayah.join(', ');
          }

          return ''
        }},
        { data: 'sasaran', name:'sasaran'},
        { data: null, name:null, orderable: false, render: function ( data, type, row ) {
          const skpd = []
          if(data.is_all_opd == 1) {
            const wilayah = []
            if(data.is_lintas_irban == 0) {
              for (const wly of data.wilayah) {
                wilayah.push(wly.nama)
              }
              wilayah.join(', ');
            }
            return `Semua Perangkat Daerah ${wilayah}`;
          } else {
            for (const opd of data.skpd) {
              skpd.push(opd.name)
              if(skpd.length > 2) {
                skpd.push(`<a href='#' class='selengkapnya-opd btn btn-xs btn-info' data-toggle='modal' data-target='#detailModal' data-id='${data.id}' >Selengkapnya</a>`)
                break;
              }
            }
          }

          return skpd.join(', ');
        }},
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

          @if(can_access("mst_program_kerja", "edit"))
          return_button += "<button class='btn btn-warning btn-xs' data-toggle='modal' data-target='#modal-form' data-id='" + data.id + "'  data-kegiatan='" + data.id_kegiatan + "'><i class='fa fa-pencil'></i> Edit</button> ";
          @endif

          @if(can_access("mst_program_kerja", "delete"))
          return_button += "<a class='btn btn-danger btn-xs' href='{{url()->current()}}/delete/" + data.id + "' onclick='return confirm(\"Apakah anda ingin menghapus data ini?\")'><i class='fa fa-close'></i> Hapus</a> ";
          @endif

          const kegiatan_nama = data.kegiatan != null ? data.kegiatan.nama : '';
          const wilayah_nama = data.wilayah != null ? data.wilayah.nama : '';
          const skpd_nama = data.skpd != null ? data.skpd.name : '';
          return_button += "<button class='btn btn-info btn-xs btn-detail' data-toggle='modal' data-target='#detailModal' data-id='" + data.id + "' data-kegiatan='" + kegiatan_nama + "' data-sub_kegiatan='"+ data.sub_kegiatan +"' data-wilayah='" + wilayah_nama + "' data-skpd='" + skpd_nama + "' data-dari='" + data.dari + "' data-sampai='" + data.sampai + "'><i class='fa fa-eye'></i> Detail</button> ";

          return return_button == "" ? "-" : return_button;
        }},
      ],
      columnDefs: [
      {
        targets: 9,
        className: "text-center",
     }],
  });
  $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

  setTimeout(function() {
    $(".alert-success").hide(1000);
  }, 3000);

  $('#editModal, #detailModal').on('show.bs.modal', function (e) {
    $(this).find('form').trigger('reset');
    $("#cover-sasaran").html('');
    $("#cover-sasaran_edit").html('');
    $("#cover-sasaran_detail").html('');
    $(this).find('.error').html('');
  });

  change_wilayah_filter($(".wilayah_filter"));

  $(".wilayah_filter").on('change', function() {
    change_wilayah_filter($(this));
  })

  function change_wilayah_filter(el) {
    console.log($(el).val())
    get_opd_filter($(el).val());
  }
  
  function get_opd_filter(val){    
    $.get("{{url('')}}/mst/skpd/get_skpd_by_id_wilayah?id=" + val, function(res) {
      if(res != null){
        $("select.opd_filter").html(`<option value='0'>- Semua Perangkat Daerah -</option>`);

        $.when($.each(res, function(idx, val){
          const data_edit = '{{ isset($filter['opd_filter']) ? $filter['opd_filter'] : 0 }}'
          const selected = data_edit == val.id ? 'selected' : ''
          $("select.opd_filter").append(`<option value='${val.id}' ${selected}>${val.name}</option>`);
        }))
      }
    });
  }

  $(document).on('click', ".selengkapnya-opd", function() {
    $("#detailModal").modal('show')
  })

});
</script>
@endsection
