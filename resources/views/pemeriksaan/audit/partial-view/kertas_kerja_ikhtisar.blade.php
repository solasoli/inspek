@php
$tagIdx = !is_null($idx) && !is_null($idx) ? $idx : '[idx]';
@endphp

<div class="br-pagebody mg-y-10 lkp-rinci" data-idx='{{ $tagIdx }}' data-id="{{ isset($data) ? $data->id : 0 }}">
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
                              <select name='kode_temuan_1' class="form-control select2 kode_temuan" data-level='1'>
                                @foreach($kode_temuan as $row) 
                                  <option value={{$row->id}}>{{$row->kode.'. '.$row->temuan}}</option>
                                @endforeach
                              </select>
                              <select name='kode_temuan_2' class="form-control select2 kode_temuan" data-level='2'>
                                @foreach($kode_temuan_2 as $row) 
                                  <option value={{$row->id}}>{{$row->kode.'. '.$row->temuan}}</option>
                                @endforeach
                              </select>
                              <select name='kode_temuan_3' class="form-control select2 kode_temuan" data-level='3'>
                                @foreach($kode_temuan_3 as $row) 
                                  <option value={{$row->id}}>{{$row->kode.'. '.$row->temuan}}</option>
                                @endforeach
                              </select>
                              <hr>
                            </div>
                            <textarea name="judul_kondisi" class='text-wizard' id="judul_kondisi_{{ $tagIdx }}" rows="10" cols="80">
                            </textarea>
                        </section>

                        <h3>Uraian Kondisi</h3>
                        <section>
                            <h5>Uraian Kondisi</h5>
                            <div class='kode_temuan_cover'>
                              <br>
                              <h6>Kode Temuan</h6>
                              <select name='kode_temuan_1' class="form-control select2 kode_temuan" data-level='1'>
                                @foreach($kode_temuan as $row) 
                                  <option value={{$row->id}}>{{$row->kode.'. '.$row->temuan}}</option>
                                @endforeach
                              </select>
                              <select name='kode_temuan_2' class="form-control select2 kode_temuan" data-level='2'>
                                @foreach($kode_temuan_2 as $row) 
                                  <option value={{$row->id}}>{{$row->kode.'. '.$row->temuan}}</option>
                                @endforeach
                              </select>
                              <select name='kode_temuan_3' class="form-control select2 kode_temuan" data-level='3'>
                                @foreach($kode_temuan_3 as $row) 
                                  <option value={{$row->id}}>{{$row->kode.'. '.$row->temuan}}</option>
                                @endforeach
                              </select>
                              <hr>
                            </div>
                            <textarea name="uraian_kondisi" class='text-wizard' id="uraian_kondisi_{{ $tagIdx }}" rows="10" cols="80">
                            </textarea>
                        </section>

                        <h3>Kriteria</h3>
                        <section>
                            <h5>Kriteria</h5>
                            <textarea name="kriteria" class='text-wizard' id="kriteria_{{ $tagIdx }}" rows="10" cols="80">
                            </textarea>
                        </section>

                        <h3>Sebab</h3>
                        <section>
                            <h5>Sebab</h5>
                            <textarea name="sebab" class='text-wizard' id="sebab_{{ $tagIdx }}" rows="10" cols="80">
                            </textarea>
                        </section>

                        <h3>Akibat</h3>
                        <section>
                            <h5>Akibat</h5>
                            <textarea name="akibat" class='text-wizard' id="akibat_{{ $tagIdx }}" rows="10" cols="80">
                            </textarea>
                        </section>

                        <h3>Rekomendasi</h3>
                        <section>
                            <h5>Rekomendasi</h5>
                            <div class='kode_rekomendasi_cover'>
                              <br>
                              <h6>Kode Rekomendasi</h6>
                              <select name='kode_rekomendasi_1' class="form-control select2 kode_rekomendasi" data-level='1'>
                                @foreach($kode_rekomendasi_1 as $row) 
                                  <option value={{$row->id}}>{{$row->kode.'. '.$row->rekomendasi}}</option>
                                @endforeach
                              </select>
                              <select name='kode_rekomendasi_2' class="form-control select2 kode_rekomendasi" data-level='2'>
                                @foreach($kode_rekomendasi_2 as $row) 
                                  <option value={{$row->id}}>{{$row->kode.'. '.$row->rekomendasi}}</option>
                                @endforeach
                              </select>
                              <hr>
                            </div>
                            <textarea name="rekomendasi" class='text-wizard' id="rekomendasi_{{ $tagIdx }}" rows="10" cols="80">
                            </textarea>
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
