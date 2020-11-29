@extends('layouts.app')
@section('content')

    <style media="screen">
        .modal-lg {
            width: 100% !important;
        }

        .ui-datepicker {
            z-index: 99999 !important;
        }

        .table th,
        .table td {
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
            <span class="breadcrumb-item active">Audit</span>
        </nav>
    </div>

    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Audit</h4>
    </div>

    <div class="br-pagebody">
        @if (Session::has('success'))
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

        @if ($errors->any())
            <div class="row">
                <div class="alert alert-danger col-lg-12">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="d-flex align-items-center justify-content-start">
                        @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12 widget-2 px-0">
                <div class="card shadow-base">
                    <div class="card-header">
                        <h6 class="card-title float-left">List Kertas Kerja</h6>
                        <div class="float-right">

                            @if (can_access('audit', 'add'))
                                <a class='btn btn-sm btn-success'
                                    href='{{ URL::to('pemeriksaan/audit/add/' . $data->id) }}'><i
                                        class='menu-item-icon icon ion-plus'></i> Tambah</a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped responsive" id="oTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Uraian Singkat</th>
                                    <th>Jumlah Kertas Kerja Ikhtisar</th>
                                    <th>Oleh</th>
                                    <th>Status</th>
                                    <th style='width:195px'>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($data->audit_kertas_kerja as $row)

                                    <tr>
                                        <td>{!! $row->uraian_singkat !!}</td>
                                        <td>{{ $row->kertas_kerja_ikhtisar->count() }}</td>
                                        <td>{{ $row->oleh->username }}</td>
                                        <td>{!! kertas_kerja_status_label($row->status) !!}</td>
                                        <td>
                                            @if (can_access('audit', 'add') && ($row->status->id == 1 || $row->status->id == 2))
                                                <a href="{{ URL::to('/pemeriksaan/audit') }}/edit/{{ $row->id }}"
                                                    class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Edit</a>
                                            @endif
                                            @if (can_access('audit', 'edit') && $row->status->id <= 4)
                                                <a href="{{ URL::to('/pemeriksaan/audit') }}/review/{{ $row->id }}"
                                                    class="btn btn-xs btn-info"><i class="fa fa-star"></i> Review</a>
                                            @endif
                                            <a target='blank'
                                                href="{{ URL::to('/pemeriksaan/audit') }}/detail/{{ $row->id }}"
                                                class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> Detail</a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @foreach ($data->audit_kertas_kerja as $row)
        @foreach ($row->kertas_kerja_ikhtisar as $ix => $rw)
            <div class="modal" id="modal-kki-{{ $rw->id }}">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title">Kertas Kerja Ikhtisar {{ $ix + 1 }}</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            {{ adt_kertas_kerja_ikhtisar_detail_modal($rw) }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach

    <form action="{{ URL::to("pemeriksaan/audit/submit_kompilasi/". $data->id) }}" class="form-layout form-layout-5" id='form-audit' style="padding-top:0" method="post">
        {{ csrf_field() }}

        <div class="br-pagebody">
            <div class="row">
                <div class="col-lg-12 widget-2 px-0">
                    <div class="card shadow-base">
                        <div class="card-header">
                            <h6 class="card-title float-left">Kompilasi</h6>
                            <div class="float-right">
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped responsive" id="" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Oleh</th>
                                        <th class='text-center' style='width:100px'>Tambahkan</th>
                                        <th class='text-center' style='width:100px'>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($data->audit_kertas_kerja as $row)
                                        @foreach ($row->kertas_kerja_ikhtisar as $ix => $rw)
                                            <tr>
                                                <td>Kertas Kerja Ikhtisar {{ $ix + 1 }}</td>
                                                <td>{{ $row->oleh->username }}</td>
                                                <td class='text-center'>
                                                    <input type="checkbox" name='kompilasi[]' value='{{ $rw->id }}' {{ $row->id_status_kertas_kerja >= 5 ? 'disabled' : '' }} {{ $rw->is_compilation ? 'checked' : ''}}/>
                                                </td>
                                                <td class='text-center'>
                                                    <a href="#" class="btn btn-sm btn-info" data-toggle='modal'
                                                        data-target="#modal-kki-{{ $rw->id }}">Detail</a>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-info review-submit" {{ $row->id_status_kertas_kerja >= 5 ? 'disabled' : '' }}>Simpan</button>&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <!-- Datatables -->
    <script src="{{ asset('admin_template/lib/datatables/jquery.dataTables.js') }}"></script>
    <script>
        $(function() {

            $("#modal-form").modal('show')
            $('#oTable').DataTable({
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                },
            });

            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity
            });

            setTimeout(function() {
                $(".alert-success").hide(1000);
            }, 3000);

            $('#addModal, #editModal').on('show.bs.modal', function() {
                $(this).find('form').trigger('reset');
            });

        });

    </script>
@endsection
