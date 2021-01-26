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
                <th>Irban</th>
                <th>Kegiatan</th>
                <th>Sasaran</th>
                <th>Dari</th>
                <th>Sampai</th>
                @if($is_avail_no == 1)
                    <th>No Surat</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->wilayah->implode('nama', ', ') }}</td>
                    <td>{{ $item->kegiatan->nama }}</td>
                    <td>{{ $item->program_kerja->sasaran }}</td>
                    <td>{{ date("d-m-Y", strtotime($item->dari)) }}</td>
                    <td>{{ date("d-m-Y", strtotime($item->sampai)) }}</td>
                    @if($is_avail_no == 1)
                        <td>{{ $item->no_surat }}</td>
                    @endif
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
