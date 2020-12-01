@extends('layouts.app')
@section('content')
<div class="br-mainpanel" style="margin: 0px;">
    <div class="br-pagetitle">
      <div style="padding-top: 20px">
        <h5>Detail Angka Kredit</h5>
      </div>
    </div>

  <div class="row row-sm mg-t-20">
    <div class="col-lg-12">
      <div class="card bd-0 shadow-base" style="margin: 20px;margin-top:0px">
      <div class="br-pagebody">

<!-- Tab panes -->
<div class="tab-content">
  <div class="row">
    <div class="col-12">
      <button class="btn btn-default" style="width: 63%">DETAIL ANGKA KREDIT</button>
      <div class="container mt-2">
        <div class="form-group row">
        <div class="col-3">
          <p><b>I. PENDIDIKAN SEKOLAH</b></p>
        </div>
        <div class="col-9">
          <input type="text" class="form-control w-50 mb-2" name="">
        </div>
        </div>
        
        <div class="form-group row">
        <div class="col-3">
          <p><b>II. ANGKA KREDIT PENJENJANGAN</b></p>
        </div>
        <div class="col-9">
          <input type="text" class="form-control w-50 mb-2" name="">
        </div>
        </div>

        <div class="form-group row">
        <div class="col-3">
          <p>&nbsp;&nbsp; A. UNSUR UTAMA</p>
        </div>
        <div class="col-9">
          <input type="text" class="form-control w-50 mb-2" name="">
        </div>
        </div>

        <div class="form-group row">
        <div class="col-3">
          <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1. Pendidikan dan Pelatihan</p>
        </div>
        <div class="col-9">
          <input type="text" class="form-control w-50 mb-2" name="">
        </div>
        </div>

        <div class="form-group row">
        <div class="col-3">
          <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2. Pengawasan  </p>
        </div>
        <div class="col-9">
          <input type="text" class="form-control w-50 mb-2" name="">
        </div>
        </div>

        <div class="form-group row">
        <div class="col-3">
          <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3. Pengembangan pengawasan </p>
        </div>
        <div class="col-9">
          <input type="text" class="form-control w-50 mb-2" name="">
        </div>
        </div>

        <div class="form-group row">
        <div class="col-3">
          <p>B. UNSUR PENUNJANG </p>
        </div>
        <div class="col-9">
          <input type="text" class="form-control w-50 mb-2" name="">
        </div>
        </div>

        <div class="form-group row">
        <div class="col-3">
          <p>&nbsp;&nbsp;&nbsp;&nbsp;Jumlah Penjenjangan</p>
        </div>
        <div class="col-9">
          <input type="text" class="form-control w-50 mb-2" name="">
        </div>
        </div>

        <div class="form-group row">
        <div class="col-3">
          <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Jumlah I + II  </p>
        </div>
        <div class="col-9">
          <input type="text" class="form-control w-50 mb-2" name="">
          <button class="btn btn-primary" style="width: 50%; margin-bottom: 30px">SIMPAN</button>
        </div>
        </div>
      
      </div>
      
    </div>
  </div>

  
</div>

</div>
    
      </div>
    </div>
  </div><!-- br-pagebody -->
</div>
    @endsection