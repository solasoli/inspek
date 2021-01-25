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
            <span class="breadcrumb-item active">Pemeriksaan</span>
        </nav>
    </div>

    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Pemeriksaan</h4>
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
                                    {{--  <th>Uraian Singkat</th>  --}}
                                    <th>Jumlah Kertas Kerja Ikhtisar</th>
                                    <th>Oleh</th>
                                    <th>Status</th>
                                    <th style='width:195px'>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($data->audit_kertas_kerja as $errors)

                                    <tr>
                                        {{--  <td>{!! $errors->uraian_singkat !!}</td>  --}}
                                        <td>{{ $errors->kertas_kerja_ikhtisar->count() }}</td>
                                        <td>{{ $errors->oleh->user_pegawai != null ? $errors->oleh->user_pegawai->pegawai->nama : $errors->oleh->username }}</td>
                                        <td>{!! kertas_kerja_status_label($errors->status) !!}</td>
                                        <td>
                                            @if (can_access('audit', 'add') && ($errors->status->id == 1 || $errors->status->id == 2))
                                                @if((Auth::user()->role->id != 1 && $id_pegawai != $data->id_ketua_tim) || Auth::user()->role->id ==1)
                                                    <a href="{{ URL::to('/pemeriksaan/audit') }}/edit/{{ $errors->id }}"
                                                        class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Edit</a>
                                                @endif
                                            @endif
                                            @if (can_access('audit', 'edit') && $errors->status->id <= 4)
                                                @if((Auth::user()->role->id != 1 && $id_pegawai == $data->id_ketua_tim) || Auth::user()->role->id ==1)
                                                    <a href="{{ URL::to('/pemeriksaan/audit') }}/review/{{ $errors->id }}"
                                                        class="btn btn-xs btn-info"><i class="fa fa-star"></i> Review</a>
                                                @endif
                                            @endif
                                            <a target='blank'
                                                href="{{ URL::to('/pemeriksaan/audit') }}/detail/{{ $errors->id }}"
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

    @if((Auth::user()->role->id != 1 && $id_pegawai == $data->id_ketua_tim) || Auth::user()->role->id ==1)
        @foreach ($data->audit_kertas_kerja as $errors)
            @foreach ($errors->kertas_kerja_ikhtisar as $ix => $rw)
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

                                        @foreach ($data->audit_kertas_kerja->where('id_status_kertas_kerja','>=',3) as $errors)
                                            @foreach ($errors->kertas_kerja_ikhtisar as $ix => $rw)
                                                <tr>
                                                    <td>Kertas Kerja Ikhtisar {{ $ix + 1 }}</td>
                                                    <td>{{ $errors->oleh->user_pegawai != null ? $errors->oleh->user_pegawai->pegawai->nama : $errors->oleh->username }}</td>
                                                    <td class='text-center'>
                                                        <input type="checkbox" name='kompilasi[]' value='{{ $rw->id }}' {{ $errors->id_status_kertas_kerja >= 5 ? 'disabled' : '' }} {{ $rw->is_compilation ? 'checked' : ''}}/>
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
                                    <button type="submit" class="btn btn-info review-submit" {{ $data->id_status_sp >= 5 ? 'disabled' : '' }}>Simpan</button>&nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
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
