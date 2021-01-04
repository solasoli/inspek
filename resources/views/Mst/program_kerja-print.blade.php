<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title>Inspektorat Bogor</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- vendor css -->
    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('admin_template/css/bracket.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/custom_css.css') }}">

    <script src="{{ asset('admin_template/lib/jquery/jquery.js') }}"></script>

</head>

<body>
    <table class="table table-bordered table-striped responsive" id="oTable" style="width:100%">
        <thead>
            <tr>
                <th rowspan='2'>Status</th>
                <th rowspan='2'>Kegiatan</th>
                <th rowspan='2'>Irban</th>
                <th rowspan='2'>Perangkat Daerah</th>
                <th rowspan='2'>Dari</th>
                <th rowspan='2'>Sampai</th>
                <th rowspan='2'>Anggaran</th>
                <th colspan='5' class="text-center">Man Power</th>
            </tr>
            <tr>
                <th class="text-center">Wakil Penganggung Jawab</th>
                <th class="text-center">Pengendali Teknis</th>
                <th class="text-center">Ketua Tim</th>
                <th class="text-center">Anggota</th>
                <th class="text-center">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->type_pkpt == 1 ? 'PKPT' : 'NON-PKPT' }}</td>
                    <td>{{ $item->kegiatan->nama }}</td>
                    <td>{{ $item->wilayah->nama }}</td>
                    <td>{{ $item->skpd->name }}</td>
                    <td>{{ date("d-m-Y", strtotime($item->dari)) }}</td>
                    <td>{{ date("d-m-Y", strtotime($item->sampai)) }}</td>
                    <td>{{ $item->anggaran }}</td>
                    <td>{{ $item->jml_wakil_penanggung_jawab }}</td>
                    <td>{{ $item->jml_pengendali_teknis }}</td>
                    <td>{{ $item->jml_ketua_tim }}</td>
                    <td>{{ $item->jml_anggota }}</td>
                    <td>{{ $item->jml_man_power }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        $(window).on('load', function() {
            window.print();
            setTimeout(function () { window.close(); }, 500)
        })
    </script>
</body>

</html>
