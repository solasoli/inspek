@extends('layouts.app')
@section('content')
<div class="br-mainpanel" style="margin: 0px;">
  <div class="br-pagetitle">
   <div style="padding-top: 20px">
    <h5>Review Sekretariat Dupak</h5>
  </div>
</div>


<div class="row row-sm mg-t-20">
  <div class="col-lg-12">
    <div class="card bd-0 shadow-base" style="margin: 20px;margin-top:0px">

      <div class="br-pagebody">


        <div class="row row-sm mg-t-20">
          <div class="col-lg-12">
            <!-- Tab panes -->
            <div class="tab-content">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-borderless">
                    <tr>
                      <td>Nama</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>NIP</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Jabatan</td>
                      <td></td>
                    </tr>
                  </table>
                </div>
                
              </div>
              <div class="container">
                <div class="row">
                  <div class="col-md-8">
                    <button class="btn btn-default w-100 mb-2">Dokumen 1</button>
                    <button class="btn btn-default w-100 mb-2">Dokumen 1</button>
                    <button class="btn btn-default w-100 mb-2">Dokumen 1</button>
                  </div>
                  <div class="col-md-4">
                    <button class="btn btn-info w-100 mb-2">Unduh</button>
                    <button class="btn btn-info w-100 mb-2">Unduh</button>
                    <button class="btn btn-info w-100 mb-2">Unduh</button>
                  </div>
                  <div class="col-md-4">
                    <button class="btn btn-default w-100">Beri Keterangan</button>
                    <textarea class="form-control mb-2" rows="2"></textarea>
                  </div>
                  <div class="col-md-8"></div>
                  <div class="col-md-4"><a href="tim_sekretariat.html"><button class="btn btn-danger w-100">Revisi</button></a></div>
                  <div class="col-md-4"><a href="tim_sekretariat.html"><button class="btn btn-success w-100">Approve</button></a></div>
                </div>
              </div>
              <br><br>
            </div>   
          </div>
        </div>

      </div>



    </div><!-- row -->

    <br>


    <br>


    <br>


  </div><!-- br-pagebody -->
  @endsection