
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>App name | Login</title>

    <!-- vendor css -->
    <link href="{{ asset('admin_template/lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_template/lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_template/css/login.css')}}" re>
    <link rel="stylesheet" href="{{ asset('admin_template/css/bracket.css') }}">
  </head>

  {{-- <body>

    <div class="d-flex align-items-center justify-content-center bg-gray-100 ht-100v">

      <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base">
        <div class="signin-logo tx-center tx-28 tx-bold tx-inverse mg-b-30">
          App Name
        </div>

        <form action="{{ route('login') }}" method="post">
          {{ csrf_field() }}
          @if(Session::has('status'))
          <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <strong class="d-block d-sm-inline-block-force">{{ Session::get('status') }}</strong>
          </div>
          @endif
          <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Username">
          </div><!-- form-group -->
          <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password">
          </div><!-- form-group -->
          <button type="submit" class="btn btn-info btn-block">Login</button>
        </form>

        <div class="mg-t-50 tx-center"></div>
      </div><!-- login-wrapper -->
    </div><!-- d-flex -->

    <script src="{{ asset('admin_template/lib/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin_template/lib/popper.js/popper.js') }}"></script>
    <script src="{{ asset('admin_template/lib/bootstrap/bootstrap.js') }}"></script>

  </body> --}}

<body>

  <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">

    <div class="login-wrapper wd-300 wd-xs-500 pd-25 pd-xs-40 bg-white rounded shadow-base">
      <div class="signin-logo tx-center tx-48 tx-bold tx-inverse"><span class="tx-normal"></span>SIMAPAN INSPEKTORAT</span></div><br>
       <center> <img src=" {{ asset('admin_template/img/logo2.png') }}" class="img-fluid" width="250"></center>
      <div class="tx-center mg-b-60"></div>


      <form action="{{ route('login') }}" method="post">
        {{ csrf_field() }}
        @if(Session::has('status'))
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <strong class="d-block d-sm-inline-block-force">{{ Session::get('status') }}</strong>
        </div>
        @endif
        <div class="form-group">
          <input type="text" name="username" class="form-control" placeholder="Username">
        </div><!-- form-group -->
        <div class="form-group">
          <input type="password" name="password" class="form-control" placeholder="Password">
        </div><!-- form-group -->
        <button type="submit" class="btn btn-info btn-lg" style="float: right;">Login</button>
      </form>


</div>


      
    </div><!-- login-wrapper -->
  </div><!-- d-flex -->

  <script src="{{ asset('admin_template/lib/jquery/jquery.js') }}"></script>
  <script src="{{ asset('admin_template/lib/popper.js/popper.js') }}"></script>
  <script src="{{ asset('admin_template/lib/bootstrap/bootstrap.js') }}"></script>

</body>
</html>
