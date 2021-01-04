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
                <th>NIP</th>
                <th>Nama</th>
                <th>Pangkat Golongan</th>
                <th>Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->nip }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->pangkat_golongan->name }}</td>
                    <td>{{ $item->jabatan->name }}</td>
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
