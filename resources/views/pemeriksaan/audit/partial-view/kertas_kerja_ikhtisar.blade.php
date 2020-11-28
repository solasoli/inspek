@php
$tagIdx = !is_null($idx) && !is_null($idx) ? $idx : '[idx]';
@endphp

<div class="br-pagebody mg-y-10 kertas-kerja-ikhtisar" data-idx='{{ $tagIdx }}' data-id="{{ isset($data) ? $data->id : 0 }}">
    <div class="row">
        <div class="col-lg-12 widget-2 px-0">
            <div class="card shadow-base">

                <div class="card-header">
                    <h6 class="card-title">
                        Kertas Kerja Utama Ikhtisar {{ $tagIdx }}</span>
                    </h6>
                    <button type="button" class="btn btn-danger btn-sm btn-delete-kki">Hapus</button>
                </div>
                <div class="card-body collapse multi-collapse show" id="lkpr-{{ $tagIdx }}">

                    <div id="wizard{{ $tagIdx }}">
                        <h3>Judul Kondisi</h3>
                        <section>
                            <h5>Judul Kondisi</h5>
                            @if(isset($data) && $data->review->where('judul_kondisi', '!=','')->count() > 0)
                              <h6>Review :</h6>
                              @foreach($data->review as $row)
                              
                                @if($row->judul_kondisi !='')
                                  <li>Dari <b>{{ pemeriksaan_get_reviewer_tipe($row->tipe) }}</b> : {!! $row->judul_kondisi !!} </li>
                                @endif
                              @endforeach
                            @endif
                            <div class='kode_temuan_cover'>
                              <br>
                              <h6>Kode Temuan</h6>
                              
                              @php
                                $valueLevelJk1 = 0;
                                $valueLevelJk2 = 0;
                                $valueLevelJk3 = 0; 
                                if(isset($data)) {
                                  $valueLevelJk1 = $data->kode_temuan->where('tipe','judul_kondisi')->where('level', 1)->first();
                                  $valueLevelJk2 = $data->kode_temuan->where('tipe','judul_kondisi')->where('level', 2)->first();
                                  $valueLevelJk3 = $data->kode_temuan->where('tipe','judul_kondisi')->where('level', 3)->first();
                                  
                                  $valueLevelJk1 = !is_null($valueLevelJk1) ? $valueLevelJk1->id_kode_temuan : 0;
                                  $valueLevelJk2 = !is_null($valueLevelJk2) ? $valueLevelJk2->id_kode_temuan : 0;
                                  $valueLevelJk3 = !is_null($valueLevelJk3) ? $valueLevelJk3->id_kode_temuan : 0; 
                                }
                              @endphp
                              <select name='kode_temuan_1' class="form-control select2 kode_temuan" data-level='1'>
                                @foreach($kode_temuan as $row)
                                  @php 
                                  $selected = !is_null($valueLevelJk1) && $valueLevelJk1 == $row->id ? 'selected' : '';
                                  @endphp
                                  <option value={{$row->id}} {{ $selected }}>{{$row->kode.'. '.$row->temuan}}</option>
                                @endforeach
                              </select>
                              <select name='kode_temuan_2' class="form-control select2 kode_temuan" data-level='2' data-value='{{ $valueLevelJk2 }}'>
                              </select>
                              <select name='kode_temuan_3' class="form-control select2 kode_temuan" data-level='3' data-value='{{ $valueLevelJk3 }}'>
                              </select>
                              <hr>
                            </div>
                            <textarea name="judul_kondisi" class='text-wizard' id="judul_kondisi_{{ $tagIdx }}" rows="10" cols="80">{{ isset($data) ? $data->judul_kondisi : "" }}</textarea>
                        </section>

                        <h3>Uraian Kondisi</h3>
                        <section>
                            <h5>Uraian Kondisi</h5>
                            @if(isset($data) && $data->review->where('uraian_kondisi', '!=','')->count() > 0)
                              <h6>Review :</h6>
                              @foreach($data->review as $row)
                              
                                @if($row->uraian_kondisi !='')
                                  <li>Dari <b>{{ pemeriksaan_get_reviewer_tipe($row->tipe) }}</b> : {!! $row->uraian_kondisi !!} </li>
                                @endif
                              @endforeach
                            @endif
                            <div class='kode_temuan_cover'>
                              <br>
                              <h6>Kode Temuan</h6>
                              @php
                                $valueLevelUk1 = 0;
                                $valueLevelUk2 = 0;
                                $valueLevelUk3 = 0; 
                                if(isset($data)) {
                                  $valueLevelUk1 = $data->kode_temuan->where('tipe','uraian_kondisi')->where('level', 1)->first();
                                  $valueLevelUk2 = $data->kode_temuan->where('tipe','uraian_kondisi')->where('level', 2)->first();
                                  $valueLevelUk3 = $data->kode_temuan->where('tipe','uraian_kondisi')->where('level', 3)->first();
                                  
                                  $valueLevelUk1 = !is_null($valueLevelUk1) ? $valueLevelUk1->id_kode_temuan : 0;
                                  $valueLevelUk2 = !is_null($valueLevelUk2) ? $valueLevelUk2->id_kode_temuan : 0;
                                  $valueLevelUk3 = !is_null($valueLevelUk3) ? $valueLevelUk3->id_kode_temuan : 0; 
                                }
                              @endphp
                              <select name='kode_temuan_1' class="form-control select2 kode_temuan" data-level='1'>
                                @foreach($kode_temuan as $row) 
                                  @php 
                                  $selected = !is_null($valueLevelUk1) && $valueLevelUk1 == $row->id ? 'selected' : '';
                                  @endphp
                                  <option value={{$row->id}} {{ $selected }}>{{$row->kode.'. '.$row->temuan}}</option>
                                @endforeach
                              </select>
                              <select name='kode_temuan_2' class="form-control select2 kode_temuan" data-level='2' data-value='{{ $valueLevelUk2 }}'>
                              </select>
                              <select name='kode_temuan_3' class="form-control select2 kode_temuan" data-level='3' data-value='{{ $valueLevelUk3 }}'>
                              </select>
                              <hr>
                            </div>
                            <textarea name="uraian_kondisi" class='text-wizard' id="uraian_kondisi_{{ $tagIdx }}" rows="10" cols="80">{{ isset($data) ? $data->uraian_kondisi : "" }}</textarea>
                        </section>

                        <h3>Kriteria</h3>
                        <section>
                            <h5>Kriteria</h5>
                            @if(isset($data) && $data->review->where('kriteria', '!=','')->count() > 0)
                              <h6>Review :</h6>
                              @foreach($data->review as $row)
                              
                                @if($row->kriteria !='')
                                  <li>Dari <b>{{ pemeriksaan_get_reviewer_tipe($row->tipe) }}</b> : {!! $row->kriteria !!} </li>
                                @endif
                              @endforeach
                            @endif
                            <textarea name="kriteria" class='text-wizard' id="kriteria_{{ $tagIdx }}" rows="10" cols="80">{{ isset($data) ? $data->kriteria : "" }}</textarea>
                        </section>

                        <h3>Sebab</h3>
                        <section>
                            <h5>Sebab</h5>
                            @if(isset($data) && $data->review->where('sebab', '!=','')->count() > 0)
                              <h6>Review :</h6>
                              @foreach($data->review as $row)
                              
                                @if($row->sebab !='')
                                  <li>Dari <b>{{ pemeriksaan_get_reviewer_tipe($row->tipe) }}</b> : {!! $row->sebab !!} </li>
                                @endif
                              @endforeach
                            @endif
                            <textarea name="sebab" class='text-wizard' id="sebab_{{ $tagIdx }}" rows="10" cols="80">{{ isset($data) ? $data->sebab : "" }}</textarea>
                        </section>

                        <h3>Akibat</h3>
                        <section>
                            <h5>Akibat</h5>
                            @if(isset($data) && $data->review->where('akibat', '!=','')->count() > 0)
                              <h6>Review :</h6>
                              @foreach($data->review as $row)
                              
                                @if($row->akibat !='')
                                  <li>Dari <b>{{ pemeriksaan_get_reviewer_tipe($row->tipe) }}</b> : {!! $row->akibat !!} </li>
                                @endif
                              @endforeach
                            @endif
                            <textarea name="akibat" class='text-wizard' id="akibat_{{ $tagIdx }}" rows="10" cols="80">{{ isset($data) ? $data->akibat : "" }}</textarea>
                        </section>

                        <h3>Rekomendasi</h3>
                        <section>
                            <h5>Rekomendasi</h5>
                            <div class='kode_rekomendasi_cover'>
                              <br>
                              <h6>Kode Rekomendasi</h6>
                                  
                              @if(isset($data) && $data->review->where('rekomendasi', '!=','')->count() > 0)
                                <h6>Review :</h6>
                                @foreach($data->review as $row)
                                
                                  @if($row->rekomendasi !='')
                                    <li>Dari <b>{{ pemeriksaan_get_reviewer_tipe($row->tipe) }}</b> : {!! $row->rekomendasi !!} </li>
                                  @endif
                                @endforeach
                              @endif
                              @php
                                $valueLevelKk1 = 0;
                                $valueLevelKk2 = 0; 
                                if(isset($data)) {
                                  $valueLevelKk1 = $data->kode_rekomendasi->where('level', 1)->first();
                                  $valueLevelKk2 = $data->kode_rekomendasi->where('level', 2)->first();
                                  
                                  $valueLevelKk1 = !is_null($valueLevelKk1) ? $valueLevelKk1->id_kode_rekomendasi : 0;
                                  $valueLevelKk2 = !is_null($valueLevelKk2) ? $valueLevelKk2->id_kode_rekomendasi : 0;
                                }
                              @endphp
                              <select name='kode_rekomendasi_1' class="form-control select2 kode_rekomendasi" data-level='1' data-value='{{ $valueLevelKk1 }}'>
                                @foreach($kode_rekomendasi_1 as $row) 
                                  @php
                                  $selected = $row->id == $valueLevelKk1 ? 'selected' : '';   
                                  @endphp
                                  <option value={{$row->id}} {{ $selected }}>{{$row->kode.'. '.$row->rekomendasi}}</option>
                                @endforeach
                              </select>
                              <select name='kode_rekomendasi_2' class="form-control select2 kode_rekomendasi" data-level='2' data-value='{{ $valueLevelKk2 }}'>
                                @foreach($kode_rekomendasi_2 as $row)
                                  @php
                                  $selected = $row->id == $valueLevelKk2 ? 'selected' : '';   
                                  @endphp 
                                  <option value={{$row->id}} {{ $selected }}>{{$row->kode.'. '.$row->rekomendasi}}</option>
                                @endforeach
                              </select>
                              <hr>
                            </div>
                            <textarea name="rekomendasi" class='text-wizard' id="rekomendasi_{{ $tagIdx }}" rows="10" cols="80">{{ isset($data) ? $data->rekomendasi : "" }}</textarea>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>