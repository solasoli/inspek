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
    <link href="{{ asset('admin_template/lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_template/lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_template/lib/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_template/lib/jquery-switchbutton/jquery.switchButton.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_template/lib/highlightjs/github.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_template/lib/datatables/jquery.dataTables.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_template/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_template/css/buat-sasaran.css')}}" rel="stylesheet">
    
    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('admin_template/css/bracket.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/custom_css.css') }}">

    <script src="{{ asset('admin_template/lib/jquery/jquery.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
  </head>
