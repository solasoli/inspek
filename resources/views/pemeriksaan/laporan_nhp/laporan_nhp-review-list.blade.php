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
            <span class="breadcrumb-item active">Laporan NHP</span>
        </nav>
    </div>

    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Laporan NHP</h4>
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

                                @foreach($data->audit_kertas_kerja as $row)
                                    <tr>
                                        <td>{!! $row->uraian_singkat !!}</td>
                                        <td>{{ $row->kertas_kerja_ikhtisar->count() }}</td>
                                        <td>{{ $row->oleh->username }}</td>
                                        <td>{!! kertas_kerja_status_label($row->status) !!}</td>
                                        <td>
                                            @if(can_access("laporan_nhp", "edit") && ($row->status->id >= 3 && $row->status->id <= 6))
                                                <a href="{{ URL::to('/pemeriksaan/laporan_nhp') }}/review/{{ $row->id }}" class="btn btn-xs btn-info"><i class="fa fa-star"></i> Review</a>
                                            @endif
                                            <a href="detail_penentuan.html" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> Detail</a>
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
            });

            $('#oTable2').DataTable({
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
