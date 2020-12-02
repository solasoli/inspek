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
            <div class="col-md-7">
              <button class="btn btn-default w-100">KETERANGAN PERORANGAN</button>
              <table class="table table-borderless">
                <tr>
                  <td width="30%">Nama</td>
                  <td width="5%">:</td>
                  <td></td>
                </tr>
                <tr>
                  <td>NIP/Nomor Seri Karpeg</td>
                  <td>:</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Tempat dan tanggal lahir</td>
                  <td>:</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Jenis kelamin</td>
                  <td>:</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Pendidikan tertinggi</td>
                  <td>:</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Pangkat / Gol. Ruang / TMT</td>
                  <td>:</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Jabatan Auditor / TMT</td>
                  <td>:</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Masa Kerja Golongan</td>
                  <td>:</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Lama</td>
                  <td>:</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Baru</td>
                  <td>:</td>
                  <td></td>
                </tr>
                <tr>
                  <td>Unit Kerja</td>
                  <td>:</td>
                  <td></td>
                </tr>
              </table>
            </div>
            <div class="col-5">
              
            </div>
            <div class="col-12">
              <button class="btn btn-default w-50">PENETAPAN ANGKA KREDIT</button>
              <table class="table table-bordered" style="border: 3px solid #efefef">
                <tr>
                  <td>I. Pendidikan Sekolah</td>
                  <td>Angka Lama</td>
                  <td>Angka Baru</td>
                  <td>Jumlah</td>
                  <td>Angka Kredit untuk kenaikan Jabatan / Pangkat</td>
                </tr>
                <tr>
                  <td></td>
                  <td>75</td>
                  <td>55</td>
                  <td>124</td>
                  <td>210</td>
                </tr>
                <tr>
                  <td>II. Angka Kredit Penjenjangan</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp; A. Unsur Utama</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;1. Pendidikan dan Pelatihan</td>
                  <td>75</td>
                  <td>55</td>
                  <td>124</td>
                  <td>210</td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;2. Pengawasan</td>
                  <td>75</td>
                  <td>55</td>
                  <td>124</td>
                  <td>210</td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;3. Pengembangan pengawasan</td>
                  <td>75</td>
                  <td>55</td>
                  <td>124</td>
                  <td>210</td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;B. Unsur Penunjang</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Jumlah Penjenjangan</td>
                  <td>75</td>
                  <td>55</td>
                  <td>124</td>
                  <td>210</td>
                </tr>
                <tr>
                  <td>&nbsp;&nbsp;&nbsp;&nbsp;Jumlah I + II</td>
                  <td>75</td>
                  <td>55</td>
                  <td>124</td>
                  <td>210</td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </table>
            </div>
          </div>

          <div class="row mb-4">
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


    </div><!-- row -->
@endsection