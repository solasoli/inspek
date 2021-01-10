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
    <span class="breadcrumb-item active">Struktur</span>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">Struktur</h4>
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

  <div class="alert-submit">
  </div>

  <div class="row">
    <div class="col-lg-12 widget-2 px-0">
      <div class="card shadow-base">
        <div class="card-header">
          <h6 class="card-title float-left">List Struktur</h6>
          <div class="float-right">
          </div>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped responsive" id="oTable" style="width:100%">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Atasan Langsung</th>
                <!-- <th>Irban</th>
                <th>Peran Irban</th> -->
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
      { data: 'nama', name: 'nama'},
      { data: 'jabatan.name', name: 'jabatan.name'},

      { data: null, searchable: false, orderable: false, render: function ( data, type, row ) { // atasan langsung
        var a = "";
        a += `<select class='atasan_langsung' data-id='${row.id}'>`;
        @foreach($wilayah AS $row)
          var selected = '{{$row->id}}' == row.atasan_langsung ? 'selected' : '';
          a += "<option value='{{$row->id}}' "+ selected +">{{$row->nama}}</option>";
        @endforeach
        a += "</select>";
        return a;
      }},

      { data: null, searchable: false, orderable: false, render: function ( data, type, row ) {
        var f = "";
        f += "<form method='post' action='{{url()->current()}}/edit/"+ row.id +"' class='form-update'>";
        f += '{{ csrf_field() }}';
        f += "<input type='hidden' name='atasan_langsung' class='hidden_atasan_langsung'>";
        f += "<input type='submit' class='btn btn-primary btn-sm' value='simpan'>";
        f += "</form>";
        return f;
      }},
    ],
    columnDefs: [
      {
        targets: 3,
        className: "text-center",
      }],
    });
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

    $(document).on('submit', '.form-update', function(e){
      e.preventDefault();
      var tr = $(this).parent().parent();

      var atasan_langsung = tr.find($(".atasan_langsung")).val();
      var row_id = tr.find($(".atasan_langsung")).data('id');
      tr.find($(".hidden_atasan_langsung")).val(atasan_langsung);

      $.post(`/mst/struktur/edit/${row_id}`, {atasan_langsung}, function(res) {
        if(res.state == 'success') {
          $(".alert-submit").html(`<div class='alert alert-success'>${res.msg}</div>`)
        } else {
          
          $(".alert-submit").html(`<div class='alert alert-danger'>Terjadi Kesalahan Server</div>`)
        }

        setInterval(function() {
          $(".alert-submit").html('');
        }, 10000)
      })
      //  e.currentTarget.submit();
    });

    setTimeout(function() {
      $(".alert-success").hide(1000);
    }, 3000);

  });
</script>
@endsection
