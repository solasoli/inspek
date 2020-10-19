<div class="br-pagebody mg-y-10">
    <div class="row">
        <div class="col-lg-12 widget-2 px-0">
            <div class="card shadow-base">
                
                <div class="card-header" 
                data-toggle="collapse" href="#lkpr-[idx]" role="button" 
                aria-expanded="false" aria-controls="lkpr-[idx]">
                    <h6 class="card-title">Langkah Kerja Pemeriksaan Rinci - <span class="tugas-label-[idx]"></span></h6>
                </div>
                <div class="card-body collapse multi-collapse show" id="lkpr-[idx]">
                    
                    <ul class="nav nav-tabs nav-justified mb-4">
                        <li class="nav-item"><a href="#tugas-[idx]" class="nav-link rounded-top font-weight-bold active show" data-toggle="tab">Tugas</a></li>
                        <li class="nav-item"><a href="#tujuan-pemeriksaan-tab-[idx]" class="nav-link rounded-top font-weight-bold" data-toggle="tab">Prosedur Pemeriksaan</a></li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane fade active show tugas-tab" id="tugas-[idx]">
                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                    Judul Tugas
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name='judul_tugas' class="form-control judul-tugas" data-idx='[idx]'>{{ !is_null(old('judul_tugas')) ? old('judul_tugas') : (isset($data->dasar_surat) ? $data->dasar_surat : (isset($dasar_surat->dasar_surat) ? $dasar_surat->dasar_surat : '')) }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12 align-items-start">
                                    Sub Judul Tugas
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12 sub-judul-tugas-cover">
                                    <textarea name='sub_judul_tugas' class="form-control">{{ !is_null(old('sub_judul_tugas')) ? old('sub_judul_tugas') : (isset($data->dasar_surat) ? $data->dasar_surat : (isset($dasar_surat->dasar_surat) ? $dasar_surat->dasar_surat : '')) }}</textarea>
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

                        <div class="tab-pane fade" id="tujuan-pemeriksaan-tab-[idx]">
                            {{-- <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <h4 class="tx-gray-800 tx-uppercase tx-bold mg-b-10 tugas-label-[idx]"></h4>
                                </div>
                            </div> --}}
                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                    Tujuan Pemeriksaan
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name='judul_tugas' class="form-control">{{ !is_null(old('judul_tugas')) ? old('judul_tugas') : (isset($data->dasar_surat) ? $data->dasar_surat : (isset($dasar_surat->dasar_surat) ? $dasar_surat->dasar_surat : '')) }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                    Prosedur Pemeriksaan
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name='judul_tugas' class="form-control">{{ !is_null(old('judul_tugas')) ? old('judul_tugas') : (isset($data->dasar_surat) ? $data->dasar_surat : (isset($dasar_surat->dasar_surat) ? $dasar_surat->dasar_surat : '')) }}</textarea>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                    <h6 class="tx-gray-800 tx-uppercase tx-bold mg-b-10">Uraian</h6>
                                </label>
                            </div>

                            <div class="cover-uraian" data-idx="[idx]">
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
                                    <button type='button' class="btn btn-block btn-success btn-sm btn-uraian" data-idx="[idx]"><i class="fa fa-plus"></i> Uraian</button>
                                </div>
                            </div>
                            <div class="row">
							    <div class="col-md-6">
									<h4 class="text-center">RENCANA</h4>
								    <table class="table table-borderless">
										<tbody><tr>
									    	<td width="25%">Pelaksana</td>
											<td width="5">:</td>
											<td width="70%"><select class="form-control"><option></option></select></td>
										</tr>
										<tr>
											<td>Jam</td>
											<td>:</td>
											<td><select class="form-control"><option></option></select></td>
											</tr>
										</tbody></table>
                                </div>
								<div class="col-md-6">
									<h4 class="text-center">REALISASI</h4>
									<table class="table table-borderless">
										<tbody><tr>
											<td width="25%">Pelaksana</td>
											<td width="5">:</td>
								    		<td width="70%"><select class="form-control"><option></option></select></td>
										</tr>
										<tr>
											<td>Jam</td>
											<td>:</td>
											<td><select class="form-control"><option></option></select></td>
									    </tr>
									</tbody></table>
								</div>
							</div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>