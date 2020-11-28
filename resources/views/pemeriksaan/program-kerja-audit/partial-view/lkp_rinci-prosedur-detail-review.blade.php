@php
$num_prosedur = isset($idx) ? $idx : '[num_prosedur]';
$idx_prosedur = isset($idxProsedur) ? $idxLkp.'-'.num2alpha($idxProsedur) : '[idx_prosedur]';
@endphp
<div class="form-group row">
    <label class="form-control-label col-md-2 col-sm-2 col-xs-12 ">
        <b>{{ $num_prosedur }}.</b>
    </label>
    <div class="col-md-10 col-sm-10 col-xs-12">
        {{ isset($data) ? $data->prosedur_detail : ''}}
    </div>
</div>