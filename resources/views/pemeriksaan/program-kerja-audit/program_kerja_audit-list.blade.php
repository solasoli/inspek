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
            <span class="breadcrumb-item active">Program Kerja Pemeriksaan</span>
        </nav>
    </div>

    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Program kerja Pemeriksaan</h4>
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
                        <h6 class="card-title float-left">List Surat Perintah</h6>
                        <div class="float-right">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Klik No. Surat untuk melihat detail Surat Perintah
                        </div>
                        <table class="table table-bordered table-striped responsive" id="oTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Irban</th>
                                    <th>Kegiatan</th>
                                    <th>Status</th>
                                    <th>No Surat Perintah</th>
                                    <th style='width:195px'>Aksi</th>
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
                ajax: '{{ url()->current() }}/datatables/',
                columns: [{
                        data: 'is_pkpt',
                        name: 'is_pkpt',
                        render: function(data, type, row) {
                            console.log(data.is_pkpt);
                            return data == 2 ? 'Non-PKPT' : 'PKPT';
                        }
                    },
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
                    {
                        data: 'kegiatan.nama',
                        name: 'kegiatan.nama'
                    },
                    
                    {
                        data: null,
                        orderable: false,
                        searcable: false,
                        render: function(data, type, row) {
                            return data.is_approved_pka == 0 ? 'Not Approved' : 'Approved'
                        }
                    },
                    {
                        data: 'no_surat',
                        name: 'no_surat',
                        render: function(data, type, row) {
                            return `<a target='_blank' href='{{ URL::to('/pkpt/surat_perintah/info') }}/${row.id}'>${data}</a>`
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searcable: false,
                        render: function(data, type, row) {
                            var return_button = "";

                            if(data.is_approved_pka == 0) {
                                @if(can_access("program_kerja_audit", "add"))
                                @if(Auth::user()->role->id != 1)
                                if(data.id_ketua_tim == {{ $id_pegawai }})
                                @endif
                                    return_button += `<a href='{{ URL::to('/pemeriksaan/program-kerja-audit') }}/edit/${row.id}' class="btn btn-xs btn-success"><i class='fa fa-pencil'></i> Program Kerja</a> `
                                @endif
                                
                                @if(can_access("program_kerja_audit", "edit"))
                                @if(Auth::user()->role->id != 1)
                                if(data.id_pengendali_teknis == {{ $id_pegawai }})
                                @endif
                                return_button += `<a href="{{ URL::to('/pemeriksaan/program-kerja-audit') }}/review/${row.id}" class="btn btn-xs btn-info"><i class="fa fa-star"></i> Review</a> `
                                @endif
                            }

                            return_button += `<a href="{{ URL::to('/pemeriksaan/program-kerja-audit') }}/detail/${row.id}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> Detail</a>`
                            return return_button == "" ? "-" : return_button
                        }
                    },
                ],
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
