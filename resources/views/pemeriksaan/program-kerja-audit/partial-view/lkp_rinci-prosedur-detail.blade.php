@php
$num_prosedur = isset($idx) ? $idx : '[num_prosedur]';
$idx_prosedur = isset($idxProsedur) ? $idxLkp.'-'.num2alpha($idxProsedur) : '[idx_prosedur]';
@endphp
<div class="form-group row">
    <label class="form-control-label col-md-2 col-sm-2 col-xs-12 ">
        {{ $num_prosedur }}
    </label>
    <div class="col-md-10 col-sm-10 col-xs-12 border-left-danger">
        <div class="input-group">
        <textarea name='prosedur_detail' class="form-control prosedur-detail" data-idx='{{ $idx_prosedur }}-{{ $num_prosedur }}' data-id='{{ isset($data) ? $data->id : 0 }}'>{{ isset($data) ? $data->prosedur_detail : ''}}</textarea>
    
        <button type="button" class="btn btn-sm btn-danger remove-sub-judul-tugas"><i class="fa fa-close"></i></button>
    </div>
    </div>
</div>