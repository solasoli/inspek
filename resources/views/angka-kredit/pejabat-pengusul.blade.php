@extends('layouts.app')
@section('content')
<div class="br-mainpanel" style="margin: 0px;">
  <div class="br-pagetitle">
   <div style="padding-top: 20px">
    <h5>Pejabat Pengusul</h5>
  </div>
</div>
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="width: 120%">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <table class="table table-bordered" style="border: 3px solid #dee2e6">
          <tr>
            <td>Data SP</td>
            <td>Unsur</td>
            <td>Sub Unsur</td>
            <td>Butir Kegiatan</td>
            <td>Hasil Perhitungan</td>
            <td>Satuan Hasil</td>
          </tr>
          <tr>
            <td width="20%">Sp : <br> tanggal : <br> Jumlah HP : <br>Jam : <br>Posisi : <br>Atasan :</td>
            <td width="16%"></td>
            <td width="16%"></td>
            <td width="16%"></td>
            <td width="16%"></td>
            <td width="16%"></td>
          </tr>
        </table>
        <div class="row">
          <div class="col-6">
            <button class="btn btn-default w-100 mb-1">Dokumen 1</button>
            <button class="btn btn-default w-100 mb-1">Dokumen 1</button>
            <button class="btn btn-default w-100">Dokumen 1</button>
          </div>
          <div class="col-3">
            <button class="btn btn-info w-50 mb-1">Unduh</button>
            <button class="btn btn-info w-50 mb-1">Unduh</button>
            <button class="btn btn-info w-50">Unduh</button>
          </div>
        </div>
      </div>


    </div>
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
            <div class="col-md-5">
              <table class="table table-borderless">
                <tr>
                  <td>Nama</td>
                  <td><input type="text" class="form-control" name=""></td>
                </tr>
                <tr>
                  <td>Tanggal</td>
                  <td><input type="date" class="form-control" name=""></td>
                  <td><input type="date" class="form-control" name=""></td>
                </tr>
              </table>
            </div>
            <div class="col-7">
              <button class="btn btn-default" style="float: right; width: 150px">CARI</button>
            </div>
          </div>
          <table class="table table-striped table-bordered" style="border: 3px solid #dee2e6">
            <tr>
              <td>Data SP</td>
              <td>Unsur</td>
              <td>Sub Unsur</td>
              <td>Butir Kegiatan</td>
              <td>Hasil Perhitungan</td>
              <td>Satuan Hasil</td>
              <td>Status</td>
              <td>Aksi</td>
            </tr>
            <tr>
              <td width="23%">Sp : <br> tanggal : <br> Jumlah HP : <br>Jam : <br>Posisi : <br>Atasan :</td>
              <td width="11%"></td>
              <td width="11%"></td>
              <td width="11%"></td>
              <td width="11%"></td>
              <td width="11%"></td>
              <td width="11%"></td>
              <td width="11%"><a href="/angka-kredit/review-pejabat-pengusul"><button class="btn btn-info w-100">Review</button></a>
                <a href="#" data-toggle="modal" data-target="#myModal"><button class="btn btn-success w-100 mt-1">Detail</button></a>
              </td>
            </tr>
          </table>

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