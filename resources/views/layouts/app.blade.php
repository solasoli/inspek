@component('layouts.head')
@endcomponent
  <body>

    <!-- ########## START: LEFT PANEL ########## -->
    <div class="br-logo justify-content-center"><img src="{{ asset('img/LOGOPinITDABogor.png') }}" class="img-fluid" width="50"></div>

    <div class="br-sideleft overflow-y-auto">
      <label class="sidebar-label pd-x-15 mg-t-20">Navigation</label>
      <div class="br-sideleft-menu">
        @component('layouts.menu')
        @endcomponent
      </div><!-- br-sideleft-menu -->
    </div><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <div class="br-header">
      <div class="br-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>

        <h6
          style="
          display: flex;
          align-self: center;
          margin-top: 10px;
          margin-left: 20px">INSPEKTORAT DAERAH KOTA BOGOR</h6>
      </div><!-- br-header-left -->
      <div class="br-header-right">
        <nav class="nav">
          <div class="dropdown">
            <!-- dropdown notif -->
          </div>
          <div class="dropdown">
            <span class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name hidden-md-down">Username</span>
              <img src="{{ asset('img/user.png') }}" class="wd-32 rounded-circle" alt="">
              <!-- <span class="square-10 bg-success"></span> -->
            </span>
            <div class="dropdown-menu dropdown-menu-header wd-250">
              <div class="tx-center">
                <a href=""><img src="https://via.placeholder.com/500" class="wd-80 rounded-circle" alt=""></a>
                <h6 class="logged-fullname">Username</h6>
                <p>username@domain.com</p>
              </div>

              <hr>
              <ul class="list-unstyled user-profile-nav">
                <li><a href="user.html"><i class="icon ion-ios-person"></i> Edit Profile</a></li>
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();"><i class="icon ion-power"></i> Sign Out</a></li>
              </ul>
            </div><!-- dropdown-menu -->
        </nav>
        <!-- <div class="navicon-right"> -->
          <!-- <a id="btnRightMenu" href="" class="pos-relative"> -->
            <!-- <i class="icon ion-ios-chatboxes-outline"></i> -->
            <!-- start: if statement -->
            <!-- <span class="square-8 bg-danger pos-absolute t-10 r--5 rounded-circle"></span> -->
            <!-- end: if statement -->
          <!-- </a> -->
        <!-- </div> -->
        <!-- navicon-right -->
      </div><!-- br-header-right -->
    </div><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      @yield('content')
      <footer class="br-footer">
      </footer>
    </div>
    <!-- ########## END: MAIN PANEL ########## -->

    <script src="{{ asset('admin_template/lib/popper.js/popper.js') }}"></script>
    <script src="{{ asset('admin_template/lib/bootstrap/bootstrap.js') }}"></script>
    <script src="{{ asset('admin_template/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js') }}"></script>
    <script src="{{ asset('admin_template/lib/moment/moment.js') }}"></script>
    <script src="{{ asset('admin_template/lib/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('admin_template/lib/jquery-switchbutton/jquery.switchButton.js') }}"></script>
    <script src="{{ asset('admin_template/lib/peity/jquery.peity.js') }}"></script>
    <script src="{{ asset('admin_template/lib/highlightjs/highlight.pack.js') }}"></script>
    <script src="{{ asset('admin_template/lib/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('admin_template/js/bracket.js') }}"></script>
    <!-- autonumeric -->
    <script src="{{ asset('admin_template/lib/auto-numeric/autoNumeric.js') }}"></script>
    <script>
      $(function(){
        /* aktif menu otomatis */
        var activeMenu = $(".nav-link[href='/{{ Request::segment(1) }}/{{ Request::segment(2) }}']");

        var activeMenuFull = $(".nav-link[href='/{{ Request::segment(1) }}/{{ Request::segment(2) }}/{{ Request::segment(3) }}']");
        if(activeMenuFull.html() != null){
          activeMenuFull.addClass('active');
          activeMenuFull.parent().parent().prev().addClass('active');
          activeMenuFull.parent().parent().prev().addClass('show-sub');
          activeMenuFull.parent().parent().slideDown();
        } else if(activeMenu.html() != null){
          activeMenu.addClass('active');
          activeMenu.parent().parent().prev().addClass('active');
          activeMenu.parent().parent().prev().addClass('show-sub');
          activeMenu.parent().parent().slideDown();
        }

        var base_url = window.location.origin;
        var current_url = $(location).attr("href");
        var link_menu = current_url.split(base_url)[1];

        if(current_url == base_url + link_menu){
          $(".br-menu-link[href='"+ link_menu +"']").addClass('active');
        }
        /* end aktif menu otomatis */

        //  initial select2
        $('select').select2({
          width:"100%"
        });


      });

      function generate_select_filter_datatables(column) {

        var select = $('<select><option value=""></option></select>')
            .appendTo( $(column.footer()).empty() )
            .on( 'change', function () {
                var val = $.fn.dataTable.util.escapeRegex(
                    $(this).val()
                );

                column
                    .search( val ? '^'+val+'$' : '', true, false )
                    .draw();
            } );

        column.data().unique().sort().each( function ( d, j ) {
            select.append( '<option value="'+d+'">'+d+'</option>' )
        } );
        return select;
      }

      function generate_text_filter_datatables(column) {

        var text = $('<input type="text" placeholder="Search">')
            .appendTo( $(column.footer()).empty() ).on( 'keyup change clear', function () {
              if ( column.search() !== this.value ) {
                  column
                      .search( this.value )
                      .draw();
              }
          } );
        return text;
      }

      $(".rupiah-format").autoNumeric('init',{
        aSep: '.',
        aDec: ',',
        mDec: 0
      });

      function set_number_formated(value){
        value.toLocaleString('id-ID')
      }
    </script>
    @yield('scripts')
  </body>
</html>
