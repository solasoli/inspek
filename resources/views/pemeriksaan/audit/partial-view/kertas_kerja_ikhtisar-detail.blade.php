@php
$tagIdx = !is_null($idx) && !is_null($idx) ? $idx : '[idx]';
@endphp
<style>
  .wizard > .content > .body ul.list-unstyled {
    list-style: none !important;
  }
</style>
<div class="br-pagebody mg-y-10 kertas-kerja-ikhtisar" data-idx='{{ $tagIdx }}' data-id="{{ isset($data) ? $data->id : 0 }}">
    <div class="row">
        <div class="col-lg-12 widget-2 px-0">
            <div class="card shadow-base">

                <div class="card-header">
                    <h6 class="card-title">
                        Kertas Kerja Utama Ikhtisar {{ $tagIdx }}</span>
                    </h6>
                </div>
                <div class="card-body collapse multi-collapse show" id="lkpr-{{ $tagIdx }}">

                    <div id="wizard{{ $tagIdx }}">
                        <h3>Judul Kondisi</h3>
                        <section>
                            <h5>Judul Kondisi</h5>
                            <div class='kode_temuan_cover'>
                              <br>
                              <h6>Kode Temuan</h6>
                              
                              @php
                                $valueLevelJk1 = $data->kode_temuan->where('tipe','judul_kondisi')->where('level', 1)->first();
                                $valueLevelJk2 = $data->kode_temuan->where('tipe','judul_kondisi')->where('level', 2)->first();
                                $valueLevelJk3 = $data->kode_temuan->where('tipe','judul_kondisi')->where('level', 3)->first();
                              @endphp
                              <ul class="list-unstyled">
                                <li>{{ $valueLevelJk1->kode_temuan->kode }}. {{ $valueLevelJk1->kode_temuan->temuan }}</li>
                                <li>{{ !is_null($valueLevelJk2) ? $valueLevelJk2->kode_temuan->kode : ''}}. {{ !is_null($valueLevelJk2) ? $valueLevelJk2->kode_temuan->temuan : ''}}</li>
                                <li>{{ !is_null($valueLevelJk3) ? $valueLevelJk3->kode_temuan->kode : ''}}. {{ !is_null($valueLevelJk3) ? $valueLevelJk3->kode_temuan->temuan : ''}}</li>
                              </ul>
                              <hr>
                            </div>
                            <h6>Judul Kondisi</h6>
                            {!! $data->judul_kondisi !!}
                        </section>

                        <h3>Uraian Kondisi</h3>
                        <section>
                            <h5>Uraian Kondisi</h5>
                            <div class='kode_temuan_cover'>
                              <br>
                              <h6>Kode Temuan</h6>
                              @php
                                $valueLevelUk1 = $data->kode_temuan->where('tipe','uraian_kondisi')->where('level', 1)->first();
                                $valueLevelUk2 = $data->kode_temuan->where('tipe','uraian_kondisi')->where('level', 2)->first();
                                $valueLevelUk3 = $data->kode_temuan->where('tipe','uraian_kondisi')->where('level', 3)->first();
                                
                              @endphp
                              <ul class="list-unstyled">
                                <li>{{ $valueLevelUk1->kode_temuan->kode }}. {{ $valueLevelUk1->kode_temuan->temuan }}</li>
                                <li>{{ !is_null($valueLevelUk2) ? $valueLevelUk2->kode_temuan->kode : ''}}. {{ !is_null($valueLevelUk2) ? $valueLevelUk2->kode_temuan->temuan : ''}}</li>
                                <li>{{ !is_null($valueLevelUk3) ? $valueLevelUk3->kode_temuan->kode : ''}}. {{ !is_null($valueLevelUk3) ? $valueLevelUk3->kode_temuan->temuan : ''}}</li>
                              </ul>
                              <hr>
                            </div>
                            <h6>Uraian Kondisi</h6>
                            {!! $data->uraian_kondisi !!}
                        </section>

                        <h3>Kriteria</h3>
                        <section>
                            <h5>Kriteria</h5>
                            {!! $data->kriteria !!}
                        </section>

                        <h3>Sebab</h3>
                        <section>
                            <h5>Sebab</h5>
                            {!! $data->sebab !!}
                        </section>

                        <h3>Akibat</h3>
                        <section>
                            <h5>Akibat</h5>
                            {!! $data->akibat !!}
                        </section>

                        <h3>Rekomendasi</h3>
                        <section>
                            <h5>Rekomendasi</h5>
                            <br>
                            <div class='kode_rekomendasi_cover'>
                              <h6>Kode Rekomendasi</h6>
                              @php
                                $valueLevelKk1 = $data->kode_rekomendasi->where('level', 1)->first();
                                $valueLevelKk2 = $data->kode_rekomendasi->where('level', 2)->first();
                              @endphp
                              <ul class="list-unstyled">
                                <li>{{ $valueLevelKk1->kode_rekomendasi->kode }}. {{ $valueLevelKk1->kode_rekomendasi->rekomendasi }}</li>
                                <li>{{ $valueLevelKk2->kode_rekomendasi->kode }}. {{ $valueLevelKk2->kode_rekomendasi->rekomendasi }}</li>
                              </ul>
                            </div>
                            <hr>
                            <h6>Rekomendasi</h6>
                            {!! $data->rekomendasi !!}
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>