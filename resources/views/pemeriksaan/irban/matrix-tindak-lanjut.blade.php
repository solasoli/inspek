@extends('layouts.app')
@section('content')
<div class="br-mainpanel">
    <div class="br-pagetitle">
      <div>
        <h4>Matrik Tindak Lanjut</h4>
      </div>
    </div>

    <div class="br-pagebody">


      <div class="row row-sm mg-t-20">
        <div class="col-lg-12">
          <div class="card bd-0 shadow-base">
            <div class="row pd-25 pb-0">
                <div class="col-6">
                  <table class="table table-borderless">
                    <tr>
                      <td>Pilih Tim</td>
                      <td>:</td>
                      <td><input type="text" name="" class="form-control"></td>
                    </tr>
                    <tr>
                      <td>Tanggal</td>
                      <td>:</td>
                      <td><input type="text" name="" class="form-control"></td>
                    </tr>
                  </table>
                </div>
              </div>
            <div class="d-md-flex justify-content-between pd-25">
              
              <table class="table table-bordered table-striped responsive dataTable no-footer" id="oTable" style="width: 100%;" role="grid" aria-describedby="oTable_info">
                <thead>
                 <tr role="row">
                  <th class="sorting_asc" tabindex="0" aria-controls="oTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Type: activate to sort column descending" style="width: 0px;">No. LHP</th>
                  <th class="sorting" tabindex="0" aria-controls="oTable" rowspan="1" colspan="1" aria-label="Irban: activate to sort column ascending" style="width: 0px;">Uraian kegiatan</th>
                  <th class="sorting" tabindex="0" aria-controls="oTable" rowspan="1" colspan="1" aria-label="Kegiatan: activate to sort column ascending" style="width: 0px;">Irban</th>
                  <th class="sorting" tabindex="0" aria-controls="oTable" rowspan="1" colspan="1" aria-label="Sasaran: activate to sort column ascending" style="width: 0px;">Tanggal</th>
                  <th class="sorting" tabindex="0" aria-controls="oTable" rowspan="1" colspan="1" aria-label="Sasaran: activate to sort column ascending" style="width: 0px;">Status</th>
                  <th style="width: 0px;" class="text-center sorting_disabled" rowspan="1" colspan="1" aria-label="Aksi">Aksi</th>
                </tr>
              </thead>
              <tbody>
               <tr role="row" class="odd">
                <td class="sorting_1">111111222</td>
                <td>Urian Kegiatan Pembantu I</td>
                <td>Inspektur Pembantu</td>
                <td>20-10-2020</td>
                <td>Belum Di Setujui</td>
                <td class=" text-center">
                  <a class="btn btn-warning btn-xs" href="tindak_lanjut.html">
                    <i class="fa fa-pencil"></i> Tindak Lanjut</a> 
                    <a class="btn btn-info btn-xs" href="detail_matrik_tl.html"><i class="fa fa-eye"></i> Detail</a>
                    <a class="btn btn-info btn-xs" href=""><i class="fa fa-eye"></i> Approve</a>
                     <a class="btn btn-success btn-xs" href="tindak_lanjut.html">
                    <i class="fa fa-pencil"></i> Review</a> 
                    
                  </td>
                </tr>
                <tr role="row" class="even">
                  <td class="sorting_1">12122222</td>
                  <td>Urian Kegiatan Pembantu I</td>
                  <td>Inspektur Pembantu</td>
                  <td>20-10-2020</td>
                  <td>Sudah Disetujui</td>
                  <td class=" text-center">
                  <a class="btn btn-warning btn-xs" href="">
                    <i class="fa fa-pencil"></i> Tindak Lanjut</a> 
                    <a class="btn btn-info btn-xs" href=""><i class="fa fa-eye"></i> Detail</a>
                    <a class="btn btn-info btn-xs" href=""><i class="fa fa-eye"></i> Approve</a>
                     <a class="btn btn-success btn-xs" href="tindak_lanjut.html">
                    <i class="fa fa-pencil"></i> Review</a> 
                  </td>
                </tr>
              </tbody>
            </table>
            </div><!-- d-flex -->

           
          </div><!-- card -->

        </div><!-- col-8 -->

      </div><!-- row -->

    </div><!-- br-pagebody -->
    @endsection