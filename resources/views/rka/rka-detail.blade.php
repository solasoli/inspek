@extends('layouts.app')
@section('content')
<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="/rka">RKA</a>
    <a class="breadcrumb-item Active" href="/rka">Detail</a>
  </nav>
</div>


<div class="br-pagebody">
  @if(Session::has('error'))
    <div class="row">
      <div class="alert alert-danger col-lg-12">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex align-items-center justify-content-start">
          <span>{!! Session::get('error') !!}</span>
        </div>
      </div>
    </div>
  @endif
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
  <style type="text/css">
    .table-bordered, .table-bordered tr, .table-bordered td, .table-bordered th {
      border:1px solid #dee2e6 !important;
    }
  </style>
  <div class="row">
    <div class="col-lg-12 widget-2 px-0">
      <div class="card shadow-base">
        <div class="card-header">
          <h6 class="card-title float-left py-2">Rencana Kerja dan Anggaran</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-4 text-right font-weight-bold">Urusan Pemerintahan</div>
            <div class="col-6">{{$data->urusan_pemerintahan->label}}</div>
          </div>
          <div class="row">
            <div class="col-4 text-right font-weight-bold">Organisasi</div>
            <div class="col-6">{{$data->organisasi->label}}</div>
          </div>
          <div class="row">
            <div class="col-4 text-right font-weight-bold">Program</div>
            <div class="col-6">{{$data->program->label}}</div>
          </div>

          <div class="row">
            <div class="col-4 text-right font-weight-bold">Kegiatan</div>
            <div class="col-6">{{$data->kegiatan->label}}</div>
          </div>

          <div class="row">
            <div class="col-4 text-right font-weight-bold">Lokasi Kegiatan</div>
            <div class="col-6">{{$data->lokasi_kegiatan}}</div>
          </div>

          <!-- <div class="row">
            <div class="col-4 text-right font-weight-bold">Waktu Pelaksanaan</div>
            <div class="col-6">{{$data->waktu_pelaksanaan}}</div>
          </div>

          <div class="row">
            <div class="col-4 text-right font-weight-bold">Sumber Dana</div>
            <div class="col-6">{{$data->sumber_dana}}</div>
          </div> -->


          <div class="row mg-y-10">
            <div class="col-4 text-right font-weight-bold">Jumlah Tahun</div>
            <div class="col-6"></div>
          </div>

          <div class="row">
            <div class="col-4 text-right font-weight-bold">{{ $data->n_min_year }}</div>
            <div class="col-8">Rp. {{number_format($data->n_min,0,',','.')}},- ({{terbilang_translate($data->n_min)}})</div>
          </div>

          <div class="row">
            <div class="col-4 text-right font-weight-bold">{{ $data->n_min_year+1 }}</div>
            <div class="col-8">Rp. {{number_format($data->n,0,',','.')}},- ({{terbilang_translate($data->n)}})</div>
          </div>

          <div class="row">
            <div class="col-4 text-right font-weight-bold">{{ $data->n_min_year+2 }}</div>
            <div class="col-8">Rp. {{number_format($data->n_max,0,',','.')}},- ({{terbilang_translate($data->n_max)}})</div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="row mg-y-20">
    <div class="col-lg-12 widget-2 px-0">
      <div class="card shadow-base">
        <div class="card-header">
          <h6 class="card-title float-left py-2">Indikator Kinerja Belanja Langsung</h6>
        </div>
        <div class="card-body">
         <table class="table table-bordered">
          <thead>
            <tr>
              <th>Indikator</th>
              <th>Tolak Ukur Kinerja</th>
              <th>Target Kinerja</th>
            </tr>
          </thead>
          <tbody>
            @php
              $indikator_kinerja_detail = $data->indikator_kinerja_detail()->get();
            @endphp
            @foreach($data->indikator_kinerja as $idx => $row)
              @php
              $j = 1;
              @endphp
              @foreach($indikator_kinerja_detail->where("id_indikator_kinerja", $row->id) as $i => $r)
                <tr>
                  @if($j == 1)
                  <td rowspan="{{$indikator_kinerja_detail->where('id_indikator_kinerja', $row->id)->count()}}" class="font-weight-bold">{{$row->indikator}}</td>
                  @endif
                  <td>{{$r->tolak_ukur_kinerja}}</td>
                  <td>{{$r->target_kinerja}}</td>

                  @php
                  $j++;
                  @endphp
                </tr>
              @endforeach
            @endforeach
          </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>

  <div class="row mg-y-20">
    <div class="col-lg-12 widget-2 px-0">
      <div class="card shadow-base">
        <div class="card-header">
          <h6 class="card-title float-left py-2">RINCIAN ANGGARAN BELANJA LANGSUNG</h6>
        </div>
        <div class="card-body">
         <table class="table table-bordered">
          <thead>
            <tr>
              <th rowspan="2">Kode Rekening</th>
              <th rowspan="2">Uraian</th>
              <th colspan="3">Rincian Perhitungan</th>
              <th rowspan="2">Jumlah<br>(Rp)</th>
            </tr>
            <tr>
              <th>Volume</th>
              <th>Satuan</th>
              <th>Harga</th>
            </tr>
          </thead>
          <tbody>
            @php
              $rincian_anggaran_detail = $data->rincian_anggaran_detail()->get();
              $total_anggaran = 0;
            @endphp
            @foreach($data->rincian_anggaran as $idx => $row)
              <tr  class="font-weight-bold">
                <td>{{$row->kode_rekening->kode_rekening}}</td>
                @if($row->jumlah > 0)
                <td  colspan="4">{{$row->kode_rekening->uraian}}</td> 
                <td class="text-right">{{number_format($row->jumlah,0,',','.')}}</td>
                @else
                <td  colspan="5">{{$row->kode_rekening->uraian}}</td> 
                @endif
              </tr>
              @foreach($rincian_anggaran_detail->where("id_rincian_anggaran", $row->id) as $i => $r)
                <tr>
                  <td></td>
                  @if($r->satuan != null)

                    @php
                      $total_anggaran += $r->jumlah;
                    @endphp

                    <td>{{$r->uraian}}</td>
                    <td class="text-right">{{number_format($r->volume,0,',','.')}}</td>
                    <td>{{$r->satuan != null ? $r->satuan->nama : ''}}</td>
                    <td class="text-right">{{number_format($r->harga,0,',','.')}}</td>
                    <td class="text-right">{{number_format($r->jumlah,0,',','.')}}</td>
                  @else
                    @if($r->jumlah > 0)
                      <td colspan="4">{{$r->uraian}}</td>
                      <td class="text-right">{{number_format($r->jumlah,0,',','.')}}</td>
                    @else
                      <td colspan="5">{{$r->uraian}}</td>
                    @endif
                  @endif

                </tr>
              @endforeach
            @endforeach
            <tr>
              <th colspan="5" class="text-right">Jumlah</th>
              <th class="text-right">{{ number_format($total_anggaran,0,',','.') }}</th>
            </tr>
          </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
