@php
$alpha_prosedur = !is_null($idx) ? num2alpha($idx) : '[alpha_prosedur]';
$idx_prosedur = !is_null($idxProsedur) ? $idxProsedur : '[idx_prosedur]';
$id_prosedur = !is_null($data) ? $data->id : 0;
@endphp
<div class="prosedur-list">
    <div class="form-group row">
        
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                <b>{{ $alpha_prosedur }}.</b>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                    {{ isset($data) ? $data->prosedur : ''}}
            </div>
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="cover-prosedur-detail" data-idx='{{ $idx_prosedur }}-{{ $alpha_prosedur }}'>
                @if(isset($data) && $data->prosedur_detail != null && $data->prosedur_detail->count() > 0)
                    @foreach($data->prosedur_detail as $iPrsD => $rPrsD)
                        {{ pka_lkp_rinci_prosedur_detail_review($iPrsD + 1, $rPrsD, $idxProsedur, $idx) }}
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

