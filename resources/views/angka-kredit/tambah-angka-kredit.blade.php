@extends('layouts.app')
@section('content')
<div class="br-mainpanel" style="margin: 0px;">
  <div class="br-pagetitle">
   <div style="padding-top: 20px">
    <h5>Tambah Angka Kredit</h5>
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
        <table class="table table-  " style="border: 3px solid #dee2e6">
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
        <div class="row">
          <div class="col-6">
            <div class="tab-content">
              <table class="table table-borderless">
                <tr style="border:0px">
                  <td width="15%">Nama</td>
                  <td width="5%">:</td>
                  <td width="80%">Lorem Ipsum</td>
                </tr>
                <tr>
                  <td>NIP</td>
                  <td>:</td>
                  <td>9821771727127711</td>
                </tr>
                <tr>
                  <td>Jabatan</td>
                  <td>:</td>
                  <td>Eselon 1</td>
                </tr>
              </table>

            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <button class="btn btn-default w-100">Pilih Unsur</button>
            <select class="form-control"><option>Pengawasan</option></select>
            
            <button style="margin-top: 15px" class="btn btn-default w-100">Pilih Sub Unsur</button>
            <select class="form-control"><option>Pelaksanaan Kegiatan Teknis Pengawasan, Per Jam</option></select>
            
            <button style="margin-top: 15px" class="btn btn-default w-100">Pilih Butr Kegiatan</button>
            <select class="form-control"><option>Melaksanakan tugas-tugas pengawasan sederhana</option></select>
            
            <button style="margin-top: 15px" class="btn btn-default w-100">Angka Kredit</button>
            <input type="text" class="form-control" name="">
            
            <button style="margin-top: 15px" class="btn btn-default w-100">Satuan Hasil</button>
            <textarea rows="3" class="form-control"></textarea>
            
          </div>
          <div class="col-6">
            <button class="btn btn-default w-100">Data SP</button>
            <table class="table table-borderless" style="border: 5px solid #efefef">
              <tr>
                <td width="20%">SP</td>
                <td width="5%">:</td>
                <td width="75%"></td>
              </tr>
              <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td></td>
              </tr>
              <tr>
                <td>Jumlah HP</td>
                <td>:</td>
                <td></td>
              </tr>
              <tr>
                <td>Jam</td>
                <td>:</td>
                <td></td>
              </tr>
              <tr>
                <td>Posisi</td>
                <td>:</td>
                <td></td>
              </tr>
              <tr>
                <td>Atasan</td>
                <td>:</td>
                <td></td>
              </tr>
              <tr>
                <td>Uraian Kegiatan</td>
                <td>:</td>
                <td></td>
              </tr>

            </table>

            <form action="">

              <div class="input-group control-group after-add-more">
                <label for="nama">Upload Dokumen</label>

                <table class="table table-borderless">
                  <tr>
                    <td width="75%"><input type="file" style="width: 100%" name="addmore[]" class="form-control" placeholder="Enter Name Here"></td>
                    <td width="25%"><div class="input-group-btn">
                      <button class="btn btn-success add-more" type="button">
                        <i class="glyphicon glyphicon-plus"></i> + Tambah Upload File
                      </button>
                    </div></td>
                  </tr>
                </table>



              </div>
            </form>
            <div class="copy-fields hide" style="display: none;">
              <div class="control-group input-group" style="margin-top:-20px;">
                <table class="table table-borderless">
                  <tr>
                    <td width="75%"><input type="file" name="addmore[]" class="form-control" placeholder="Enter Name Here" style="width: 100%"></td>
                    <td width="25%"><div class="input-group-btn">
                      <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> X</button>
                    </div></td>
                  </tr>
                </table>


              </div>
            </div>

            <a href="penilaian_angka.html"><button class="btn btn-info w-100" style="margin-bottom: 50px">SIMPAN</button>
            </a>
          </div>
        </div>





      </div><!-- card -->



    </div><!-- row -->

    <br>


    <br>


    <br>


  </div><!-- br-pagebody -->
   <script type="text/javascript">
  $(document).ready(function() {
  //here first get the contents of the div with name class copy-fields and add it to after "after-add-more" div class.
  $(".add-more").click(function() {
    var html = $(".copy-fields").html();
    $(".after-add-more").after(html);
  });
  //here it will remove the current value of the remove button which has been pressed
  $("body").on("click", ".remove", function() {
    $(this)
    .parents(".control-group")
    .remove();
  });
});

</script>
  @endsection