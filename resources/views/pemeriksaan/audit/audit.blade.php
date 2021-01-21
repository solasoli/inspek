@extends('layouts.app')
@section('content')
<div class="br-mainpanel" style="margin: 0px;">
    <div class="br-pagetitle">
     <div style="padding-top: 20px">
        <h5>Melaksanakan Pemeriksaan</h5>
      </div>
    </div>

    <div class="br-pagebody" style="margin-bottom: 10px">
      

      <div class="row row-sm mg-t-20">
        <div class="col-lg-12">
          <div class="card bd-0 shadow-base">
            <div class="d-md-flex justify-content-between pd-25">
              <div>
                <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1">Melaksanakan Pemeriksaan</h6>
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
                 <table class="table table-bordered table-striped responsive dataTable no-footer" id="oTable" style="width: 100%;" role="grid" aria-describedby="oTable_info">
                  <thead>
                   <tr role="row">
                    <th class="sorting_asc" tabindex="0" aria-controls="oTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Type: activate to sort column descending" style="width: 0px;">Type</th>
                    <th class="sorting" tabindex="0" aria-controls="oTable" rowspan="1" colspan="1" aria-label="Irban: activate to sort column ascending" style="width: 0px;">Irban</th>
                    <th class="sorting" tabindex="0" aria-controls="oTable" rowspan="1" colspan="1" aria-label="Kegiatan: activate to sort column ascending" style="width: 0px;">Kegiatan</th>
                    <th class="sorting" tabindex="0" aria-controls="oTable" rowspan="1" colspan="1" aria-label="Sasaran: activate to sort column ascending" style="width: 0px;">Sasaran</th>
                    <th class="sorting" tabindex="0" aria-controls="oTable" rowspan="1" colspan="1" aria-label="Dari: activate to sort column ascending" style="width: 0px;">Dari</th>
                    <th class="sorting" tabindex="0" aria-controls="oTable" rowspan="1" colspan="1" aria-label="Sampai: activate to sort column ascending" style="width: 0px;">Sampai</th>
                    <th class="sorting" tabindex="0" aria-controls="oTable" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 0px;">Status</th>
                    <th style="width: 0px;" class="text-center sorting_disabled" rowspan="1" colspan="1" aria-label="Aksi">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                 <tr role="row" class="odd">
                  <td class="sorting_1">Non-PKPT</td>
                  <td>Inspektur Pembantu I</td>
                  <td>tes kegiatan</td>
                  <td>sasaran 1; sasaran 2; sasaran 3</td>
                  <td>04-05-2020</td>
                  <td>07-05-2020</td>
                  <td><span class="text-danger">Belum Disetujui</span></td>
                  <td class=" text-center">
                    <a class="btn btn-warning btn-xs" href="http://inspektorat.summitbreak.com/pkpt/surat_perintah/edit/9">
                      <i class="fa fa-pencil"></i> Edit</a> 
                      <a class="btn btn-danger btn-xs" href="http://inspektorat.summitbreak.com/pkpt/surat_perintah/delete/9" onclick="return confirm(&quot;Apakah anda ingin menghapus data ini?&quot;)"><i class="fa fa-close"></i> Hapus</a> 
                      <a class="btn btn-success btn-xs" href="http://inspektorat.summitbreak.com/pkpt/surat_perintah/approve/9"><i class="fa fa-check"></i> Approve</a>  
                      <a class="btn btn-info btn-xs" href="http://inspektorat.summitbreak.com/pkpt/surat_perintah/info/9"><i class="fa fa-eye"></i> Detail</a>
                    </td>
                </tr>
                <tr role="row" class="even">
                  <td class="sorting_1">Non-PKPT</td>
                  <td>Inspektur Pembantu I</td>
                  <td>pemeriksaan baru</td>
                  <td>sasaran baru; sasaran lama</td>
                  <td>19-05-2020</td>
                  <td>26-05-2020</td>
                  <td><span class="text-danger">Belum Disetujui</span></td>
                  <td class=" text-center"><a class="btn btn-warning btn-xs" href="http://inspektorat.summitbreak.com/pkpt/surat_perintah/edit/12"><i class="fa fa-pencil"></i> Edit</a> <a class="btn btn-danger btn-xs" href="http://inspektorat.summitbreak.com/pkpt/surat_perintah/delete/12" onclick="return confirm(&quot;Apakah anda ingin menghapus data ini?&quot;)"><i class="fa fa-close"></i> Hapus</a> <a class="btn btn-success btn-xs" href="http://inspektorat.summitbreak.com/pkpt/surat_perintah/approve/12"><i class="fa fa-check"></i> Approve</a>  <a class="btn btn-info btn-xs" href="http://inspektorat.summitbreak.com/pkpt/surat_perintah/info/12"><i class="fa fa-eye"></i> Detail</a></td>
                </tr>
              </tbody>
            </table>
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
 <table class="table table-bordered table-striped responsive dataTable no-footer" id="oTableApprove" style="width: 100%;" role="grid" aria-describedby="oTableApprove_info">
  <thead>
   <tr role="row">
    <th class="sorting_asc" tabindex="0" aria-controls="oTableApprove" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Type: activate to sort column descending" style="width: 65px;">Type</th>
    <th class="sorting" tabindex="0" aria-controls="oTableApprove" rowspan="1" colspan="1" aria-label="Irban: activate to sort column ascending" style="width: 134.889px;">Irban</th>
    <th class="sorting" tabindex="0" aria-controls="oTableApprove" rowspan="1" colspan="1" aria-label="Kegiatan: activate to sort column ascending" style="width: 149.889px;">Kegiatan</th>
    <th class="sorting" tabindex="0" aria-controls="oTableApprove" rowspan="1" colspan="1" aria-label="Nomor SP: activate to sort column ascending" style="width: 199.889px;">No. Surat Perintah</th>
    <th class="sorting" tabindex="0" aria-controls="oTableApprove" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 60.8889px;">Status</th>
   
    <th style="width: 200.889px;" class="sorting_disabled" rowspan="1" colspan="1" aria-label="Aksi">Aksi</th>
  </tr>
</thead>
<tbody>
 <tr role="row" class="odd">
  <td class="sorting_1">PKPT</td>
  <td>Inspektur Pembantu I</td>
  <td>percobaan kegiatan</td>
  <td>700/222/NKT/2020	</td>
  <td><span class="text-success">Setuju</span></td>
  <td class="text-center">
    <a href="/pemeriksaan/audit/buat-kertaskerja"><button class="btn btn-info" data-toggle="modal" data-target="#myModal">Buat Kertas Kerja</button></a>
    <a href="detail_penentuan.html"><button class="btn btn-primary"><i class="fa fa-eye"></i> Rinci</button></a>
    <a href="review.html"><button class="btn btn-success mt-1"><i class="fa fa-star"></i> Review</button></a>
    <button class="btn btn-warning mt-1"><i class="fa fa-edit"></i> Edit</button>
  </td>
</tr>
<tr role="row" class="even">
  <td class="sorting_1">Non-PKPT</td>
  <td>Inspektur Pembantu I</td>
  <td>kegiatan non-pkpt</td>
  <td>700/222/NKT/2020	</td>
  <td><span class="text-success">Approved</span></td>
  <td class="text-center">
    <a href="#"><button class="btn btn-info" data-toggle="modal" data-target="#myModal">Buat Kertas Kerja</button></a>
    <a href="detail_penentuan.html"><button class="btn btn-primary"><i class="fa fa-eye"></i> Detail</button></a>
    <a href="review.html"><button class="btn btn-success mt-1"><i class="fa fa-star"></i> Review</button></a>
    <button class="btn btn-warning mt-1"><i class="fa fa-edit"></i> Edit</button>
  </td>
</tr>
<tr role="row" class="odd">
  <td class="sorting_1">PKPT</td>
  <td>Inspektur Pembantu I</td>
  <td>kegiatan baru</td>
  <td>700/222/NKT/2020	</td>
  <td><span class="text-success">Approved</span></td>
  <td class="text-center">
    <a href="#"><button class="btn btn-info" data-toggle="modal" data-target="#myModal">Buat Kertas Kerja</button></a>
    <a href="detail_penentuan.html"><button class="btn btn-primary"><i class="fa fa-eye"></i> Detail</button></a>
    <a href="review.html"><button class="btn btn-success mt-1"><i class="fa fa-star"></i> Review</button></a>
    <button class="btn btn-warning mt-1"><i class="fa fa-edit"></i> Edit</button>
  </td>
</tr>
<tr role="row" class="even">
  <td class="sorting_1">PKPT</td>
  <td>Inspektur Pembantu I</td>
  <td>contoh kegiatan terbaru</td>
  <td>700/222/NKT/2020	</td>
  <td><span class="text-success">Approved</span></td>
  <td class="text-center">
    <a href="#"><button class="btn btn-info" data-toggle="modal" data-target="#myModal">Buat Kertas Kerja</button></a>
    <a href="detail_penentuan.html"><button class="btn btn-primary"><i class="fa fa-eye"></i> Detail</button></a>
    <a href="review.html"><button class="btn btn-success mt-1"><i class="fa fa-star"></i> Review</button></a>
    <button class="btn btn-warning mt-1"><i class="fa fa-edit"></i> Edit</button>
  </td>
</tr>
<tr role="row" class="odd">
  <td class="sorting_1">Non-PKPT</td>
  <td>Inspektur Pembantu I</td>
  <td>kegiatan terbaru</td>
  <td>700/222/NKT/2020	</td>
  <td><span class="text-success">Approved</span></td>
  <td class="text-center">
    <a href="#"><button class="btn btn-info" data-toggle="modal" data-target="#myModal">Buat Kertas Kerja</button></a>
    <a href="detail_penentuan.html"><button class="btn btn-primary"><i class="fa fa-eye"></i> Detail</button></a>
    <a href="review.html"><button class="btn btn-success mt-1"><i class="fa fa-star"></i> Review</button></a>
    <button class="btn btn-warning mt-1"><i class="fa fa-edit"></i> Edit</button>
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

            
          </div><!-- card -->

        </div><!-- col-8 -->
        
      </div><!-- row -->

      <br>


          <br>
       

          <br>


    </div><!-- br-pagebody -->
   
  </div><!-- br-mainpanel -->
@endsection