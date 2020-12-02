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
        <div class="col-lg-12 widget-2 px-0" style="margin-bottom:20px">
          <div class="card shadow-base">
            
            <div style="margin: 20px"><center><img class="img-fluid" style="width: 90%; margin: 10px" src="{{ asset('img/review_perbandingan1.png') }}"><img class="img-fluid" style="width: 90%; margin: 10px" src="{{ asset('img/form7.jpg') }}"></center>
              <div class="row">
                <div class="col-6">
                  <button class="btn btn-default w-100">Revisi / Masukan</button>
              <textarea rows="4" class="form-control"></textarea>
            <br>
            <div class="row">
              <div class="col-6">
                <a href="tim_penilai.html"><button class="btn btn-danger w-100">Revisi</button></a>
              </div>
              <div class="col-6">
                <a href="tim_penilai.html"><button class="btn btn-success w-100">Approve</button></a>
              </div>
            </div>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>

    </div><!-- row -->
@endsection