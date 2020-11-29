@php
$tagIdx = !is_null($idx) && !is_null($idx) ? $idx : '[idx]';
@endphp

<div class="br-pagebody mg-y-10 lkp-rinci" data-idx='{{ $tagIdx }}' data-id="{{ isset($data) ? $data->id : 0 }}">
    <div class="row">
        <div class="col-lg-12 widget-2 px-0">
            <div class="card shadow-base">
                
                <div class="card-header" 
                data-toggle="collapse" href="#lkpr-{{ $tagIdx }}" role="button" 
                aria-expanded="false" aria-controls="lkpr-{{ $tagIdx }}">
                    <h6 class="card-title">
                        Langkah Kerja Pemeriksaan Rinci - <span class="tugas-label-{{ $tagIdx }}">{{ isset($data) ? $data->judul_tugas : '' }}</span>
                    </h6>
                </div>
                <div class="card-body collapse multi-collapse show" id="lkpr-{{ $tagIdx }}">
                    
                    <ul class="nav nav-tabs nav-justified mb-4">
                        <li class="nav-item"><a href="#tugas-{{ $tagIdx }}" class="nav-link rounded-top font-weight-bold active show" data-toggle="tab">Tugas</a></li>
                        <li class="nav-item"><a href="#tujuan-pemeriksaan-tab-{{ $tagIdx }}" class="nav-link rounded-top font-weight-bold" data-toggle="tab">Prosedur Pemeriksaan</a></li>
                        <li class="nav-item"><a href="#pelaksana-tab-{{ $tagIdx }}" class="nav-link rounded-top font-weight-bold" data-toggle="tab">Pelaksana</a></li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane fade active show tugas-tab" id="tugas-{{ $tagIdx }}">
                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                    <b>Judul Tugas</b>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{ isset($data) ? $data->judul_tugas : '' }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12 align-items-start">
                                    <b>Sub Judul Tugas</b>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12 sub-judul-tugas-cover">
                                    <ul>
                                        <li>{{ $data->sub_judul_tugas }}</li>
                                        @if (isset($data) && $data->sub_judul != null && $data->sub_judul()->count() > 0)
                                    
                                            @foreach($data->sub_judul as $idx => $row) 
                                                <li>{{ $row->sub_judul }}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tujuan-pemeriksaan-tab-{{ $tagIdx }}">
                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                    <b>Tujuan Pemeriksaan</b>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{ isset($data) ? $data->tujuan_pemeriksaan : '' }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    {{--  @if(isset($data) && $data->)  --}}
                                    <h6 class="tx-gray-800 tx-uppercase tx-bold mg-b-10">Prosedur Pemeriksaan</h6>
                                </div>
                            </div>

                            <div class="cover-prosedur" data-idx="{{ $tagIdx }}">
                                @if(isset($data) && $data->prosedur != null && $data->prosedur->count() > 0) 
                                    @foreach($data->prosedur as $iPsd => $rPsd)
                                        {{ pka_lkp_rinci_prosedur_review($idx + 1, $iPsd, $rPsd) }}
                                    @endforeach
                                @else
                                    <div class="row no-available-prosedur">
                                        <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12 d-flex justify-content-center">
                                            Tidak ada Prosedur Pemeriksaan
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="pelaksana-tab-{{ $tagIdx }}">
                            @if(isset($data) && $data->prosedur != null && $data->prosedur->count() > 0) 
                                @foreach($data->prosedur as $iPsd => $rPsd)
                                    @if($rPsd->prosedur_pelaksana != null && $rPsd->prosedur_pelaksana->count() > 0)
                                        {{ pka_lkp_pelaksana_review($anggota, $tagIdx, $rPsd, $iPsd, $rPsd->prosedur_pelaksana) }}
                                    @endif
                                @endforeach
                            @else
                                <div class="row no-available-prosedur">
                                    <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12 d-flex justify-content-center">
                                        Tidak ada Prosedur Pemeriksaan
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr>
                    <h6>Review</h6>
                    <textarea name="lkp_review_{{ $data->id }}" class='text-wizard' id="lkp_review_{{ $data->id }}" rows="10" cols="80">
                        {{ $data->review != null ? $data->review->isi : ''}}
                    </textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@php
// clearing the variable
unset($idx);

@endphp