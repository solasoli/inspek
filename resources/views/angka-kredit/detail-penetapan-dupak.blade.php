@extends('layouts.app')
@section('content')
<div class="br-mainpanel" style="margin: 0px;">
  <div class="br-pagetitle">
   <div style="padding-top: 20px">
   
  </div>
</div>

    <div class="card bd-0 shadow-base" style="margin: 20px;margin-top:0px">

      
    <div class="br-pagebody">
  
      <div class="row">
        <div class="col-lg-12 widget-2 px-0">
          <div class="card shadow-base">
            <div class="card-header">
              <h6 class="card-title float-left"></h6>
              <div class="float-right">

                <a class="btn btn-sm btn-success" href="#" onclick="window.print()"><i class="menu-item-icon icon ion-print-outline"></i> Print</a>
              </div>
            </div>
            <div><center><img class="img-fluid" style="width: 90%; margin: 10px" src="{{ asset('img/detail_dupak.jpg') }}"></center></div> 
          </div>
         
        </div>
      </div>
    </div> 


    </div><!-- row -->
@endsection