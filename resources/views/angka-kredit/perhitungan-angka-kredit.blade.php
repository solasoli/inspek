@extends('layouts.app')
@section('content')
<div class="br-mainpanel" style="margin: 0px;">
  <div class="br-pagetitle">
   <div style="padding-top: 20px">
    <h5>Perhitungan Angka Kredit</h5>
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
            <div class="card bd-0">
              <div class="d-md-flex justify-content-between">
                <div>
                  <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1">Penilaian Angka Kredit</h6>
                  <div class="tab-content">

                    <div class="tab-pane fade" id="not_approved" aria-expanded="false" style="display: none;">
                     <div class="table-responsive">
                      <div id="oTable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                       <div class="row">
                        <div class="col-sm-6">
                         <div class="dataTables_length" id="oTable_length">
                          <label>
                           <select name="oTable_length" aria-controls="oTable" class="form-control input-sm select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                          </select>
                          <span class="select2 select2-container select2-container--default" dir="ltr" style="width: 73px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-oTable_length-yr-container"><span class="select2-selection__rendered" id="select2-oTable_length-yr-container" title="10">10</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span> items/page
                        </label>
                      </div>
                    </div>
                    <div class="col-sm-6">
                     <div id="oTable_filter" class="dataTables_filter"><label><input type="search" class="" placeholder="Search..." aria-controls="oTable"></label></div>
                   </div>
                 </div>
                 <div class="row">
                  <div class="col-sm-12">

                    <div id="oTable_processing" class="dataTables_processing panel panel-default" style="display: none;">Processing...</div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-5">
                   <div class="dataTables_info" id="oTable_info" role="status" aria-live="polite">Showing 1 to 2 of 2 entries</div>
                 </div>
                 <div class="col-sm-7">
                   <div class="dataTables_paginate paging_simple_numbers" id="oTable_paginate">
                    <ul class="pagination">
                     <li class="paginate_button previous disabled" id="oTable_previous"><a href="#" aria-controls="oTable" data-dt-idx="0" tabindex="0">Previous</a></li>
                     <li class="paginate_button active"><a href="#" aria-controls="oTable" data-dt-idx="1" tabindex="0">1</a></li>
                     <li class="paginate_button next disabled" id="oTable_next"><a href="#" aria-controls="oTable" data-dt-idx="2" tabindex="0">Next</a></li>
                   </ul>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
       <div class="tab-pane fade active show" id="approved" aria-expanded="true" style="display: block;">
        <div class="table-responsive">
          <div id="oTableApprove_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
           <div class="row">
            <div class="col-sm-6">
             <div class="dataTables_length" id="oTableApprove_length">
              <label>
               <select name="oTableApprove_length" aria-controls="oTableApprove" class="form-control input-sm select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
              </select>
              <span class="select2 select2-container select2-container--default" dir="ltr" style="width: 26.2222px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-oTableApprove_length-ob-container"><span class="select2-selection__rendered" id="select2-oTableApprove_length-ob-container" title="10">10</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span> items/page
            </label>
          </div>
        </div>
        <div class="col-sm-6">
         <div id="oTableApprove_filter" class="dataTables_filter" style="margin-left: 900px;"><label><input type="search" class="form-control input-sm" placeholder="Search..." aria-controls="oTableApprove"></label></div>
       </div>
     </div>
     <div class="row">
      <div class="col-sm-12">
        <table class="table table-bordered table-striped table-responsive dataTable no-footer" id="oTableApprove"  role="grid" aria-describedby="oTableApprove_info">
          <thead>
           <tr role="row">
            <th class="sorting_asc" tabindex="0" aria-controls="oTableApprove" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Type: activate to sort column descending" style="width: 65px;">Type</th>
            <th class="sorting" tabindex="0" aria-controls="oTableApprove" rowspan="1" colspan="1" aria-label="Irban: activate to sort column ascending" style="width: 134.889px;">Irban</th>
            <th class="sorting" tabindex="0" aria-controls="oTableApprove" rowspan="1" colspan="1" aria-label="Kegiatan: activate to sort column ascending" style="width: 149.889px;">Kegiatan</th>
            <th class="sorting" tabindex="0" aria-controls="oTableApprove" rowspan="1" colspan="1" aria-label="Sasaran: activate to sort column ascending" style="width: 199.889px;">No Surat Perintah</th>
            <th class="sorting" tabindex="0" aria-controls="oTableApprove" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 145.8889px;">Status</th>
            <th style="width: 200.889px;" class="sorting_disabled" rowspan="1" colspan="1" aria-label="Aksi">Aksi</th>
          </tr>
        </thead>
        <tbody>
         <tr role="row" class="odd">
          <td class="sorting_1">PKPT</td>
          <td>Inspektur Pembantu I</td>
          <td>percobaan kegiatan</td>
          <td>012818382392399233838</td>
          <td><span class="text-success">Belum Di Setujui</span></td>
          <td class="text-center">
            <a href="/angka-kredit/tambah-angka-kredit"><button class="btn btn-info mb-1">Tambah Angka Kredit</button></a>
            <a href="#"><button class="btn btn-primary mb-1" data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i> Detail</button></a>
            <a href="/angka-kredit/edit-angka-kredit"><button class="btn btn-success mb-1"><i class="fa fa-edit"></i> Edit</button>
            </td>
          </tr>
          <tr role="row" class="even">
            <td class="sorting_1">Non-PKPT</td>
            <td>Inspektur Pembantu I</td>
            <td>kegiatan non-pkpt</td>
            <td>012818382392399233838</td>
            <td><span class="text-success">Sudah Di Setujui</span></td>
            <td class="text-center">
              <a href="#"><button class="btn btn-info mb-1" >Tambah Angka Kredit</button></a>
              <a href="detail_penentuan1.html"><button class="btn btn-primary mb-1" data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i> Detail</button></a>
              <a href="edit_angka_kredit.html"><button class="btn btn-success mb-1"><i class="fa fa-edit"></i> Edit</button>
              </td>
            </tr>

          </tbody>
        </table>
        <div id="oTableApprove_processing" class="dataTables_processing panel panel-default" style="display: none;">Processing...</div>
      </div>
    </div>
    <div class="dataTables_info" id="oTable_info" role="status" aria-live="polite">Showing 1 to 10 of 444 entries</div>
    <div class="dataTables_paginate paging_simple_numbers" id="oTable_paginate"><a class="paginate_button previous disabled" aria-controls="oTable" data-dt-idx="0" tabindex="0" id="oTable_previous">Previous</a><span><a class="paginate_button current" aria-controls="oTable" data-dt-idx="1" tabindex="0">1</a><a class="paginate_button " aria-controls="oTable" data-dt-idx="2" tabindex="0">2</a><a class="paginate_button " aria-controls="oTable" data-dt-idx="3" tabindex="0">3</a><a class="paginate_button " aria-controls="oTable" data-dt-idx="4" tabindex="0">4</a><a class="paginate_button " aria-controls="oTable" data-dt-idx="5" tabindex="0">5</a><span class="ellipsis">…</span><a class="paginate_button " aria-controls="oTable" data-dt-idx="6" tabindex="0">45</a></span><a class="paginate_button next" aria-controls="oTable" data-dt-idx="7" tabindex="0" id="oTable_next">Next</a></div>
  </div>
</div>
</div>

</div>
</div>

</div><!-- d-flex -->
<br>

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