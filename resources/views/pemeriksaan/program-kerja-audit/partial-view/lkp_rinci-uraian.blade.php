<div class="uraian">
    <div class="form-group row">
        <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
            [alpha_uraian].
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12 border-left-success">
            <textarea name='judul_tugas' class="form-control">{{ !is_null(old('judul_tugas')) ? old('judul_tugas') : (isset($data->dasar_surat) ? $data->dasar_surat : (isset($dasar_surat->dasar_surat) ? $dasar_surat->dasar_surat : '')) }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="cover-detail-uraian" data-idx='[idx_uraian]-[alpha_uraian]'>
                
            </div>
            <hr>
            <div class="form-group row">
                <label class="form-control-label col-md-2 col-sm-2 col-xs-12 ">
                </label>
                <div class="col-md-10 col-sm-10 col-xs-12">
                    <button type='button' class="btn btn-block btn-danger btn-sm btn-detail-uraian" data-idx="[idx_uraian]-[alpha_uraian]"><i class="fa fa-plus"></i> Detail Uraian</button>
                </div>
            </div>
        </div>
    </div>
</div>