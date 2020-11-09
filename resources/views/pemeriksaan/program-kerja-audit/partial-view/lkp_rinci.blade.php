@php
$tagIdx = !is_null($data) && !is_null($idx) ? $idx : '[idx]';
@endphp

<div class="br-pagebody mg-y-10">
    <div class="row">
        <div class="col-lg-12 widget-2 px-0">
            <div class="card shadow-base">
                
                <div class="card-header" 
                data-toggle="collapse" href="#lkpr-{{ $tagIdx }}" role="button" 
                aria-expanded="false" aria-controls="lkpr-{{ $tagIdx }}">
                    <h6 class="card-title">Langkah Kerja Pemeriksaan Rinci - <span class="tugas-label-{{ $tagIdx }}"></span></h6>
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
                                    Judul Tugas
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name='judul_tugas' class="form-control judul-tugas" data-idx='{{ $tagIdx }}'>{{ isset($data) ? $data->judul_tugas : '' }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12 align-items-start">
                                    Sub Judul Tugas
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12 sub-judul-tugas-cover">
                                    @if (isset($data) && $data->sub_judul != null && $data->sub_judul()->count() > 0)
                                        <textarea name='sub_judul_tugas' class="form-control sub-judul-tugas">{{ isset($data) ? $data->sub_judul_tugas : '' }}</textarea>
                                   
                                        @foreach($data->sub_judul as $idx => $row) 
                                            @include('pemeriksaan.program-kerja-audit.partial-view.sub_judul_tugas', ['sub_judul' => $row->sub_judul])
                                        @endforeach
                                    @else
                                        <textarea name='sub_judul_tugas' class="form-control sub-judul-tugas"></textarea>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <button type="button" class="btn btn-block btn-primary btn-sm add-sub-judul-tugas"><i class="fa fa-plus"></i> Sub Judul Tugas</button>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tujuan-pemeriksaan-tab-{{ $tagIdx }}">
                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                    Tujuan Pemeriksaan
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name='tujuan_pemeriksaan' class="form-control tujuan-pemeriksaan"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                    Prosedur Pemeriksaan
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name='prosedur_pemeriksaan' class="form-control prosedur-pemeriksaan"></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                    <h6 class="tx-gray-800 tx-uppercase tx-bold mg-b-10">Uraian</h6>
                                </label>
                            </div>

                            <div class="cover-uraian" data-idx="{{ $tagIdx }}">
                                <div class="row no-available-uraian">
                                    <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12 d-flex justify-content-center">
                                        Tidak ada uraian
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <button type='button' class="btn btn-block btn-success btn-sm btn-uraian" data-idx="{{ $tagIdx }}"><i class="fa fa-plus"></i> Uraian</button>
                                </div>
                            </div>   
                        </div>
                        
                        <div class="tab-pane fade" id="pelaksana-tab-{{ $tagIdx }}">
                            
                            <div class="row">
							    <div class="col-md-6">
                                    <h6 class="tx-gray-800 tx-uppercase tx-bold mg-b-10 text-center">Rencana</h6>
                                    <div class="form-group row">
                                        <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                            Pelaksana
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name='rencana_pelaksana' class="form-control pelaksana-rencana">
                                                @foreach($anggota as $idx => $row)
                                                    <option value='{{$row->id}}'>{{ $row->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                            Durasi
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input name='rencana_durasi' class="form-control durasi-rencana" value='{{ !is_null(old('judul_tugas')) ? old('judul_tugas') : '' }}' style='max-width: 50px; display:inline'> Jam
                                        </div>
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <h6 class="tx-gray-800 tx-uppercase tx-bold mg-b-10 text-center">Realisasi</h6>
									<div class="form-group row">
                                        <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                            Pelaksana
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name='rencana_pelaksana' class="form-control pelaksana-realisasi">
                                                @foreach($anggota as $idx => $row)
                                                    <option value='{{$row->id}}'>{{ $row->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                            Durasi
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input name='rencana_durasi' class="form-control durasi-realisasi" value='{{ !is_null(old('judul_tugas')) ? old('judul_tugas') : '' }}' style='max-width: 50px; display:inline'> Jam
                                        </div>
                                    </div>
								</div>
							</div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>