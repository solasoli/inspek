@extends('layouts.app')
@section('content')
<style type="text/css">
@media print {
  body * {
    visibility: hidden;
  }
  #print_here, #print_here * {
    visibility: visible;
  }
  #print_here {
    position: absolute;
    top: 0;
  }

  .no-print {
    padding:0 !important;
    margin:0 !important;
    height: 0 !important;
  }

  .br-mainpanel {
    margin-top:0 !important;
  }
}
</style>
<div class="br-pageheader pd-y-15 pd-l-20 no-print">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="#">Master</a>
    <span class="breadcrumb-item active">Surat Perintah</span>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30 no-print">
  <h4 class="tx-gray-800 mg-b-5">Surat Perintah : {{$data->no_surat}}</h4>
</div>

<div class="br-pagebody">
  @if(Session::has('success'))
  <div class="row">
    <div class="alert alert-success col-lg-12">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="d-flex align-items-center justify-content-start">
        <span>{!! Session::get('success') !!}</span>
      </div>
    </div>
  </div>
  @endif

  <div class="row">
    <div class="col-lg-12 widget-2 px-0">
      <div class="card shadow-base">
        <div class="card-header">
          <h6 class="card-title float-left">Surat Perintah</h6>
          <div class="float-right">

            <a class='btn btn-sm btn-success' href='#' onclick="window.print()"><i class='menu-item-icon icon ion-print-outline'></i> Print</a>
          </div>
        </div>
        <div class="card-body">
          <div id='print_here' style="width: 800px; margin: 0 auto">
            <table  style="width: 100%">
              <tr>
                <td width="100px" align="right"><img src="{{ asset('img/logo_kota_bogor.png') }}" width="110px" height="110px"></td>
                <td align="center">
                  <div style="margin-left: 0px">
                    <h5>PEMERINTAH DAERAH KOTA BOGOR</h5>
                    <h3>INSPEKTORAT DAERAH</h3>
                    <p>Jalan Pahlawan Belakang Nomor 144 Kota Bogor 16132\n
                      Telp. (0251) 8313274/Faks. (0251) 8373229\n
                      Website: inspektorat.kotabogor.go.id
                    </p>
                  </div>
                </td>
                <td width="100px"></td>
              </tr>
              <tr>
                <td colspan="3"><hr></td>
              </tr>
            </table>
            <div class="text-center">
              <h6 style="text-decoration: underline;">SURAT PERINTAH TUGAS</h6>
              <p>Nomor: {{$data->no_surat}}</p>
              <p>INSPEKTUR KOTA BOGOR</p>
            </div>
            <div class="row">
              <div class="col-2">Dasar</div>
              <div class="col-1">:</div>
              <div class="col-8">{{$data->dasar_surat}}</div>
            </div>
            <div class="text-center">
              <br>
              <p>MEMERINTAHKAN</p>
            </div>

            <div class="row">
              <div class="col-2">Kepada</div>
              <div class="col-1">:</div>
              <div class="col-8">
                <div class="row">
                  <div class="col-2">Nama</div>
                  <div class="col-1">:</div>
                  <div class="col-8">{{$data->nama_inspektur_pembantu}}</div>
                </div>
                <div class="row">
                  <div class="col-2">Jabatan</div>
                  <div class="col-1">:</div>
                  <div class="col-8">{{$data->inspektur_pembantu_jabatan}}</div>
                </div>
                <div class="row">
                  <div class="col-2"></div>
                  <div class="col-1"></div>
                  <div class="col-8">Selaku Wakil Penanggung Jawab</div>
                </div>

                <br>

                <div class="row">
                  <div class="col-2">Nama</div>
                  <div class="col-1">:</div>
                  <div class="col-8">{{$data->nama_pengendali_teknis}}</div>
                </div>
                <div class="row">
                  <div class="col-2">Jabatan</div>
                  <div class="col-1">:</div>
                  <div class="col-8">{{$data->pengendali_teknis_jabatan}}</div>
                </div>
                <div class="row">
                  <div class="col-2"></div>
                  <div class="col-1"></div>
                  <div class="col-8">Selaku Pengendali Teknis</div>
                </div>

                <br>
                
                <div class="row">
                  <div class="col-2">Nama</div>
                  <div class="col-1">:</div>
                  <div class="col-8">{{$data->nama_ketua_tim}}</div>
                </div>
                <div class="row">
                  <div class="col-2">Jabatan</div>
                  <div class="col-1">:</div>
                  <div class="col-8">{{$data->ketua_tim_jabatan}}</div>
                </div>
                <div class="row">
                  <div class="col-2"></div>
                  <div class="col-1"></div>
                  <div class="col-8">Selaku Ketua Tim</div>
                </div>

                <br>

                <div class="row">
                  <div class="col-2">Anggota</div>
                  <div class="col-1">:</div>
                  <div class="col-8">
                    <ol style="padding-left: 10px">
                    @foreach($anggota as $idx => $row)
                      <li>{{$row->nama}}</li>
                    @endforeach
                    </ol>
                  </div>
                </div>

              </div>
            </div>

            <div class="row">
              <div class="col-2">Untuk</div>
              <div class="col-1">:</div>
              <div class="col-8">{{$data->untuk}}</div>
            </div>
            <br>
            <div class="row">
              <div class="col-2">Sasaran</div>
              <div class="col-1">:</div>
              <div class="col-8">

                @if($sasaran->count() > 1)
                  <ol style="padding-left: 15px">
                  @foreach($sasaran as $idx => $row)
                    <li>{{ $row->nama }}</li>
                  @endforeach
                @else

                  @foreach($sasaran as $idx => $row)
                    {{ $row->nama }}
                  @endforeach
                @endif
              </ol></div>
            </div>
            <br>
            <div class="row">
              <div class="col-2">Waktu</div>
              <div class="col-1">:</div>
              <div class="col-8">Tanggal 
                {{date("d", strtotime($data->dari)) }} 
                {{bulan_indonesia(date("m", strtotime($data->dari)))}}
                {{date("Y", strtotime($data->dari)) }} 

                @if($data->dari != $data->sampai)
                sampai dengan
                {{date("d", strtotime($data->sampai)) }} 
                {{bulan_indonesia(date("m", strtotime($data->sampai)))}}
                {{date("Y", strtotime($data->sampai)) }} 
                @endif
              </div>
            </div>
            <br>
            <br>

            <div class="row">
              <div class="col-6"></div>
              <div class="col-6">
                Dikeluarkan Di Bogor<br>
                Pada tanggal 
                {{date("d", strtotime($data->dari)) }} 
                {{bulan_indonesia(date("m", strtotime($data->dari)))}}
                {{date("Y", strtotime($data->dari)) }}<br><br>
                
                <div class="col-12 text-center">
                  <p>INSPEKTUR</p>
                  <br><br>
                  <span class="text-decoration:underline">{{$data->nama_inspektur}}</span><br>
                  {{$data->inspektur_pangkat}}<br>
                  NIP. {{$data->nip_inspektur}}
                </div>
              </div>
            </div>
            <br>
            
            

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<!-- Datatables -->
<script src="{{ asset('admin_template/lib/datatables/jquery.dataTables.js') }}"></script>
<script>
$(function() {
  setTimeout(function() {
    $(".alert-success").hide(1000);
  }, 3000);

});
</script>
@endsection