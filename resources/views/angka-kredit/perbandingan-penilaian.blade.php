@extends('layouts.app')
@section('content')
<div class="br-mainpanel" style="margin: 0px;">
  <div class="br-pagetitle">
   <div style="padding-top: 20px">
    
  </div>
</div>

    <div class="card bd-0 shadow-base" style="margin: 20px;margin-top:0px">

      
    <div class="br-pagebody">

        <!-- Tab panes -->
        <div class="tab-content">
          <div class="row">
            <div class="col-md-5">
              <table class="table table-borderless">
                <tr>
                  <td>Nama</td>
                  <td><input type="text" class="form-control" name=""></td>
                  <td><button class="btn btn-primary" style="float: right; width: 150px">CARI</button></td>
                </tr>
              </table>
            </div>
            <div class="col-7">
                
            </div>
          </div>
          <table class="table table-striped table-bordered" style="border: 3px solid #dee2e6">
            <tr>
              <td>No</td>
              <td>Nama</td>
              <td>Status</td>
              <td>Aksi</td>
            </tr>
            <tr>
              <td>1</td>
              <td>Lorem Ipsum Lorem Ipsum</td>
              <td>Sudah Di Setujui</td>
              <td><a href="/angka-kredit/review-perbandingan-penilaian"><button class="btn btn-info w-100">Review</button></a>
                <a href="/angka-kredit/detail-penetapan-dupak"><button class="btn btn-success w-100 mt-1">Detail</button></a>
              </td>

            </tr>
            <tr>
              <td>2</td>
              <td>Lorem Ipsum Lorem Ipsum</td>
              <td>Sudah Di Setujui</td>
              <td><a href="review_penetapan_dupak.html"><button class="btn btn-info w-100">Review</button></a>
                <a href="detail_perbandingan_nilai.html"><button class="btn btn-success w-100 mt-1">Detail</button></a>
              </td>
            </tr>
            <tr>
              <td>3</td>
              <td>Lorem Ipsum Lorem Ipsum</td>
              <td>Sudah Di Setujui</td>
              <td><a href="review_penetapan_dupak.html"><button class="btn btn-info w-100">Review</button></a>
                <a href="detail_perbandingan_nilai.html"><button class="btn btn-success w-100 mt-1">Detail</button></a>
              </td>
            </tr>
          </table>

        </div>

      </div>      


    </div><!-- row -->
@endsection