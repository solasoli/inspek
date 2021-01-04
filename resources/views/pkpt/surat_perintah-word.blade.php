<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />


    <title>Inspektorat Bogor</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- vendor css -->
    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('admin_template/css/bracket.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/custom_css.css') }}" />

    <script src="{{ asset('admin_template/lib/jquery/jquery.js') }}"></script>

</head>

<body>
    <table style="width: 100%">
        <tr>
            <td width="100px" align="right"><img src="{{ asset('img/logo_kota_bogor.png') }}" width="110px" height="110px" /></td>
            <td align="center">
                <div style="margin-left: 0px">
                    <h5>PEMERINTAH DAERAH KOTA BOGOR</h5>
                    <h3>INSPEKTORAT DAERAH</h3>
                    <p>Jalan Pahlawan Belakang Nomor 144 Kota Bogor 16132\r\n
                        Telp. (0251) 8313274/Faks. (0251) 8373229\r\n
                        Website: inspektorat.kotabogor.go.id
                    </p>
                </div>
            </td>
            <td width="100px"></td>
        </tr>
        <tr>
            <td colspan="3" style="border-bottom: 1px solid #666">
            </td>
        </tr>
    </table>
    <div class="text-center">
        <h6 style="text-decoration: underline;">SURAT PERINTAH TUGAS</h6>
        <p>Nomor: {{ $data->no_surat }}</p>
        <p>INSPEKTUR KOTA BOGOR</p>
    </div>
    <div class="row">
        <div class="col-2">Dasar</div>
        <div class="col-1">:</div>
        <div class="col-8">{{ $data->dasar_surat }}</div>
    </div>
    <div class="text-center">
        \r\n
        <p>MEMERINTAHKAN</p>
    </div>

    @php
    $inspektur = $data->inspektur()->with(['pangkat','jabatan'])->first();
    $irban = $data->inspektur_pembantu()->with('jabatan')->first();
    $dalnis = $data->pengendali_teknis()->with('jabatan')->first();
    $ketua_tim = $data->ketua_tim()->with('jabatan')->first();
    @endphp

    <div class="row">
        <div class="col-2">Kepada</div>
        <div class="col-1">:</div>
        <div class="col-8">
            <div class="row">
                <div class="col-2">Nama</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $irban->nama }}</div>
            </div>
            <div class="row">
                <div class="col-2">Jabatan</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $irban->jabatan->name }}</div>
            </div>
            <div class="row">
                <div class="col-2"></div>
                <div class="col-1"></div>
                <div class="col-8">Selaku Wakil Penanggung Jawab</div>
            </div>

            \r\n

            <div class="row">
                <div class="col-2">Nama</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $dalnis->nama }}</div>
            </div>
            <div class="row">
                <div class="col-2">Jabatan</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $dalnis->jabatan->name }}</div>
            </div>
            <div class="row">
                <div class="col-2"></div>
                <div class="col-1"></div>
                <div class="col-8">Selaku Pengendali Teknis</div>
            </div>

            \r\n

            <div class="row">
                <div class="col-2">Nama</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $ketua_tim->nama }}</div>
            </div>
            <div class="row">
                <div class="col-2">Jabatan</div>
                <div class="col-1">:</div>
                <div class="col-8">{{ $ketua_tim->jabatan->name }}</div>
            </div>
            <div class="row">
                <div class="col-2"></div>
                <div class="col-1"></div>
                <div class="col-8">Selaku Ketua Tim</div>
            </div>

            \r\n

            <div class="row">
                <div class="col-2">Anggota</div>
                <div class="col-1">:</div>
                <div class="col-8">
                    <ol style="padding-left: 10px">
                        @foreach ($data->anggota as $idx => $row)
                            <li>{{ $row->nama }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-2">Untuk</div>
        <div class="col-1">:</div>
        <div class="col-8">
            <ol style="padding-left: 15px;">
                <li>{{ $data->kegiatan->nama }}, @foreach ($data->sasaran as $idx => $row)
                        {{ $row->nama }} pada {{ $skpd->name }}
                    @endforeach pada tanggal
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
            Dikeluarkan Di Bogor\r\n
            Pada tanggal
            {{ date('d', strtotime($data->dari)) }}
            {{ bulan_indonesia(date('m', strtotime($data->dari))) }}
            {{ date('Y', strtotime($data->dari)) }}\r\n\r\n

            <div class="col-12 text-center">
                <p>INSPEKTUR</p>
                \r\n\r\n
                <span style="text-decoration:underline">{{ $inspektur->nama }}</span>\r\n
                {{ $inspektur->pangkat->name }} - {{ $inspektur->pangkat_golongan->name }}\r\n
                NIP. {{ $inspektur->nip }}
            </div>
        </div>
    </div>
    \r\n
    {{-- Tembusan --}}
    @if (strlen(trim($data->tembusan)) > 0)
        <div class="tembusan">
            Tembusan : \r\n
            {!! nl2br($data->tembusan) !!}
        </div>
    @endif
</body>

</html>
