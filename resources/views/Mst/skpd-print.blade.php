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
                <th>Nama SKPD</th>
                <!-- <th>Singkatan PD</th> -->
                <th>Pimpinan</th>
                <th>Wilayah Kerja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->pimpinan }}</td>
                    <td>{{ $item->wilayah->nama }}</td>
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
