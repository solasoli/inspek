@extends('layouts.app')
@section('content')
    <style type="text/css">
        @media print {
            body * {
                visibility: hidden;
            }

            #print_here,
            #print_here * {
                visibility: visible;
            }

            #print_here {
                position: absolute;
                top: 0;
            }

            .no-print {
                padding: 0 !important;
                margin: 0 !important;
                height: 0 !important;
            }

            .br-mainpanel {
                margin-top: 0 !important;
            }
        }

    </style>
    <div class="br-pageheader pd-y-15 pd-l-20 no-print">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="/">Dashboard</a>
            <a class="breadcrumb-item" href="#">Master</a>
            <span class="breadcrumb-item active">Surat Perintah</span>
        </nav>
    </div>

    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30 no-print">
        <h4 class="tx-gray-800 mg-b-5">Surat Perintah : {{ $data->no_surat }}</h4>
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

        <div class="row">
            <div class="col-lg-12 widget-2 px-0">
                <div class="card shadow-base">
                    <div class="card-header">
                        <h6 class="card-title float-left">Surat Perintah</h6>
                        <div class="float-right">

                            <a class='btn btn-sm btn-success' href='#' onclick="window.print()"><i
                                    class='menu-item-icon icon ion-print-outline'></i> Print</a>
                        </div>
                    </div>
                    <div class="card-body" style="color: black; font-size: 16px;">
                        <div id='print_here' style="width: 800px; margin: 0 auto">
                            <table style="width: 100%">
                                <tr>
                                    <td width="100px" align="right"><img src="{{ asset('img/kop-warna.jpeg') }}"
                                            width="100px" height="120px"></td>
                                    <td align="center">
                                        <div style="margin-left: 0px;">
                                            <h4 style="color:#000000; line-height: 1.2; font-family: arial, sans-serif;"><strong>PEMERINTAH DAERAH KOTA BOGOR</strong></h5>
                                            <h3 style="color:#000000; line-height: 0.3;"><strong>INSPEKTORAT DAERAH</strong></h3>
                                            <p style="font-family: times, sans-serif; font-size:16px; color:#000000; line-height:1.2;">Jalan Raya Pajajaran No. 5 Kota Bogor 16143<br>
                                                Telp. (0251) 8313274/Faks. (0251) 8373229<br>
                                                Website: inspektorat.kotabogor.go.id
                                            </p>
                                        </div>
                                    </td>
                                    <td width="100px"></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <hr style="margin-top: 0; color:#000000; border-top: 3px solid #000000; margin-bottom: 0px;">
                                        <hr style="margin-top: 0; color:#000000; border-bottom: 1px solid #000000;">
                                    </td>
                                </tr>
                            </table>
                            <div class="text-center" style="line-height: 0.5;">
                                <h6 style="text-decoration: underline;">SURAT PERINTAH TUGAS</h6>
                                <p>Nomor: {{ $data->no_surat }}</p>
                                <p>INSPEKTUR DAERAH</p>
                            </div>
                            <div class="row" style="line-height: 0.5;">
                                <div class="col-2" style="padding-left: 65px;">Dasar</div>
                                <div class="col-1 pl-4">:</div>
                                <div class="col-8">{{ $data->dasar_surat }}</div>
                            </div>
                            <div class="text-center" style="line-height: 1;">
                                <br>
                                <p>MEMERINTAHKAN</p>
                            </div>

                            @php
                              $inspektur = $data->inspektur()->with(['pangkat','jabatan'])->first();
                            @endphp
                            @foreach($data->tim as $idxTm => $rowTm)
                                @php 

                                $irban = $rowTm->inspektur_pembantu()->with('jabatan')->first();
                                $dalnis = $rowTm->pengendali_teknis()->with('jabatan')->first();
                                $ketua_tim = $rowTm->ketua_tim()->with('jabatan')->first();
                                @endphp
                                <div class="row">
                                    <div class="col-2" style="padding-left: 65px;">Kepada</div>
                                    <div class="col-1 pl-4">:</div>
                                    <div class="col-8">
                                        <div class="row">
                                            <div class="col-2">Nama</div>
                                            <div class="col-1">:</div>
                                            <div class="col-8">{{ $irban->nama }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">Jabatan</div>
                                            <div class="col-1">:</div>
                                            <div class="col-8">Wakil Penanggung Jawab</div>
                                            {{-- <div class="col-8">{{ $irban->jabatan->name }}</div> --}}
                                        </div>
                                        <div class="row">
                                            <div class="col-2"></div>
                                            <div class="col-1"></div>
                                            
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-2">Nama</div>
                                            <div class="col-1">:</div>
                                            <div class="col-8">{{ $dalnis->nama }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">Jabatan</div>
                                            <div class="col-1">:</div>
                                            <div class="col-8"> Pengendali Teknis</div>
                                            {{-- <div class="col-8">{{ $dalnis->jabatan->name }}</div> --}}
                                        </div>
                                        <div class="row">
                                            <div class="col-2"></div>
                                            <div class="col-1"></div>
                                            
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-2">Nama</div>
                                            <div class="col-1">:</div>
                                            <div class="col-8">{{ $ketua_tim->nama }}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">Jabatan</div>
                                            <div class="col-1">:</div>
                                            <div class="col-8">Ketua Tim</div>
                                            {{-- <div class="col-8">{{ $ketua_tim->jabatan->name }}</div> --}}
                                        </div>
                                        <div class="row">
                                            <div class="col-2"></div>
                                            <div class="col-1"></div>
                                            
                                        </div>

                                        <br>

                                        <div class="row">
                                            <div class="col-2">Anggota</div>
                                            <div class="col-1">:</div>
                                            <div class="col-8">
                                                <ol style="padding-left: 10px">
                                                    @foreach ($data->anggota_tim->where('id_surat_perintah_tim', $rowTm->id) as $idx => $row)
                                                        <li>{{ $row->anggota->nama }}</li>
                                                    @endforeach
                                                </ol>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach

                            <div class="row">
                                <div class="col-2" style="padding-left: 70px;">Untuk</div>
                                <div class="col-1 pl-4">:</div>
                                <div class="col-8">
                                    <ol style="padding-left: 15px;">
                                        <li>{{ $data->program_kerja->jenis_pengawasan->implode('nama',', ') }}, {{ $data->program_kerja->sasaran }} 
                                            pada  
                                            @if ($data->program_kerja->is_all_opd == 1)
                                                Semua Perangkat Daerah
                                                {{ $data->program_kerja->is_lintas_irban == 0 ? $data->program_kerja->wilayah->implode('nama', ', ') : '' }}
                                            @else
                                                <ul style="list-style-type: none; padding: 0">
                                                    @foreach ($data->program_kerja->skpd as $val)
                                                        <li>- {{ $val->name }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                            pada tanggal
                                            {{ date('d', strtotime($data->dari)) }}
                                            {{ bulan_indonesia(date('m', strtotime($data->dari))) }}
                                            {{ date('Y', strtotime($data->dari)) }}

                                            @if ($data->dari != $data->sampai)
                                                sampai dengan
                                                {{ date('d', strtotime($data->sampai)) }}
                                                {{ bulan_indonesia(date('m', strtotime($data->sampai))) }}
                                                {{ date('Y', strtotime($data->sampai)) }}
                                            @endif
                                        </li>
                                        <li>Melaporkan hasilnya pada Inspektur daerah Kota Bogor</li>
                                        <li>Melaksanakan surat perintah tugas ini dengan penuh tanggung jawab</li>

                                    </ol>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6"></div>
                                <div class="col-6">
                                    Dikeluarkan Di Bogor<br>
                                    Pada tanggal
                                    {{ date('d', strtotime($data->dari)) }}
                                    {{ bulan_indonesia(date('m', strtotime($data->dari))) }}
                                    {{ date('Y', strtotime($data->dari)) }}<br><br>

                                    <div class="col-12 text-center">
                                        <p>INSPEKTUR DAERAH,</p>
                                        <br><br>
                                        <span style="text-decoration:underline">{{ $inspektur->nama }}</span><br>
                                        Pembina Utama Muda - {{ $inspektur->pangkat_golongan->name }}<br>
                                        NIP. {{ $inspektur->nip }}
                                    </div>
                                </div>
                            </div>
                            <br>
                            {{-- Tembusan --}}
                            @if (strlen(trim($data->tembusan)) > 0)
                                <div class="tembusan">
                                    <p style="margin-bottom:0px;">Disampaikan kepada yang terhormat</p>
                                    Tembusan : <br>
                                    {!! nl2br($data->tembusan) !!}
                                </div>
                            @endif

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
    <script>
        $(function() {
            setTimeout(function() {
                $(".alert-success").hide(1000);
            }, 3000);

        });

    </script>
@endsection
