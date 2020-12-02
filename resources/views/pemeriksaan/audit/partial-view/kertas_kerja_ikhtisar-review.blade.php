@php
$tagIdx = !is_null($idx) && !is_null($idx) ? $idx : '[idx]';
$review = $data->review->where('tipe',$tipe_review)->first();
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
                            <hr>
                            <h6>Review</h6>
                            
                            @foreach($data->review->where('tipe','!=', $tipe_review) as $row)
                              @if($row->judul_kondisi !='')
                                <li>Dari <b>{{ pemeriksaan_get_reviewer_tipe($row->tipe) }}</b> : {!! $row->judul_kondisi !!} </li>
                              @endif
                            @endforeach
                            <textarea name="judul_kondisi" class='text-wizard' id="judul_kondisi_{{ $tagIdx }}" rows="10" cols="80">{{ isset($review) ? $review->judul_kondisi : "" }}</textarea>
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
                            <hr>
                            <h6>Review</h6>
                            
                            @foreach($data->review->where('tipe','!=', $tipe_review) as $row)
                            
                              @if($row->uraian_kondisi !='')
                                <li>Dari <b>{{ pemeriksaan_get_reviewer_tipe($row->tipe) }}</b> : {!! $row->uraian_kondisi !!} </li>
                              @endif
                            @endforeach
                            <textarea name="uraian_kondisi" class='text-wizard' id="uraian_kondisi_{{ $tagIdx }}" rows="10" cols="80">{{ isset($review) ? $review->uraian_kondisi : "" }}</textarea>
                        </section>

                        <h3>Kriteria</h3>
                        <section>
                            <h5>Kriteria</h5>
                            {!! $data->kriteria !!}
                            <hr>
                            <h6>Review</h6>
                            
                            @foreach($data->review->where('tipe','!=', $tipe_review) as $row)
                              @if($row->kriteria !='')
                                <li>Dari <b>{{ pemeriksaan_get_reviewer_tipe($row->tipe) }}</b> : {!! $row->kriteria !!} </li>
                              @endif
                            @endforeach
                            <textarea name="kriteria" class='text-wizard' id="kriteria_{{ $tagIdx }}" rows="10" cols="80">{{ isset($review) ? $review->kriteria : "" }}</textarea>
                        </section>

                        <h3>Sebab</h3>
                        <section>
                            <h5>Sebab</h5>
                            {!! $data->sebab !!}
                            <hr>
                            <h6>Review</h6>
                            
                            @foreach($data->review->where('tipe','!=', $tipe_review) as $row)
                              @if($row->sebab !='')
                                <li>Dari <b>{{ pemeriksaan_get_reviewer_tipe($row->tipe) }}</b> : {!! $row->sebab !!} </li>
                              @endif
                            @endforeach
                            <textarea name="sebab" class='text-wizard' id="sebab_{{ $tagIdx }}" rows="10" cols="80">{{ isset($review) ? $review->sebab : "" }}</textarea>
                        </section>

                        <h3>Akibat</h3>
                        <section>
                            <h5>Akibat</h5>
                            {!! $data->akibat !!}
                            <h6>Review</h6>
                            
                            @foreach($data->review->where('tipe','!=', $tipe_review) as $row)
                              @if($row->akibat !='')
                                <li>Dari <b>{{ pemeriksaan_get_reviewer_tipe($row->tipe) }}</b> : {!! $row->akibat !!} </li>
                              @endif
                            @endforeach
                            <textarea name="akibat" class='text-wizard' id="akibat_{{ $tagIdx }}" rows="10" cols="80">{{ isset($review) ? $review->akibat : "" }}</textarea>
                        </section>

                        <h3>Rekomendasi</h3>
                        <section>
                            <h5>Rekomendasi</h5>
                            {!! $data->rekomendasi !!}
                            <hr>
                            <h6>Review</h6>
                            <div class='kode_rekomendasi_cover'>
                              <br>
                              <h6>Kode Rekomendasi</h6>
                              @php
                                $valueLevelKk1 = $data->kode_rekomendasi->where('level', 1)->first();
                                $valueLevelKk2 = $data->kode_rekomendasi->where('level', 2)->first();
                              @endphp
                              <ul class="list-unstyled">
                                <li>{{ $valueLevelKk1->kode_rekomendasi->kode }}. {{ $valueLevelKk1->kode_rekomendasi->rekomendasi }}</li>
                                <li>{{ $valueLevelKk2->kode_rekomendasi->kode }}. {{ $valueLevelKk2->kode_rekomendasi->rekomendasi }}</li>
                              </ul>
                              <hr>
                            </div>
                            {!! $data->judul_kondisi !!}
                            <hr>
                            <h6>Review</h6>
                            
                            @foreach($data->review->where('tipe','!=', $tipe_review) as $row)
                              @if($row->rekomendasi !='')
                                <li>Dari <b>{{ pemeriksaan_get_reviewer_tipe($row->tipe) }}</b> : {!! $row->rekomendasi !!} </li>
                              @endif
                            @endforeach
                            <textarea name="rekomendasi" class='text-wizard' id="rekomendasi_{{ $tagIdx }}" rows="10" cols="80">{{ isset($review) ? $review->rekomendasi : "" }}</textarea>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>