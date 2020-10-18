<div class="form-group row">
    <label class="form-control-label col-md-2 col-sm-2 col-xs-12 ">
        [num_uraian]
    </label>
    <div class="col-md-10 col-sm-10 col-xs-12 border-left-danger">
        <textarea name='judul_tugas' class="form-control">{{ !is_null(old('judul_tugas')) ? old('judul_tugas') : (isset($data->dasar_surat) ? $data->dasar_surat : (isset($dasar_surat->dasar_surat) ? $dasar_surat->dasar_surat : '')) }}</textarea>
    </div>
</div>