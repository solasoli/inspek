@php
$alpha_prosedur = !is_null($idx) ? num2alpha($idx) : '[alpha_prosedur]';
$idx_prosedur = !is_null($idxProsedur) ? $idxProsedur : '[idx_prosedur]';
$id_prosedur = !is_null($data) ? $data->id : 0;
@endphp
<div class="prosedur-list">
    <div class="form-group row">
        
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                {{ $alpha_prosedur }}.
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12 border-left-success">
                <div class="input-group">
                    <textarea name='prosedur' class="form-control prosedur" data-idx='{{ $idx_prosedur }}-{{ $alpha_prosedur }}' data-id='{{ $id_prosedur }}'>{{ isset($data) ? $data->prosedur : ''}}</textarea>
                    
                    <button type="button" class="btn btn-sm btn-danger remove-prosedur" data-idx='{{ $idx_prosedur }}-{{ $alpha_prosedur }}'><i class="fa fa-close"></i></button>
                </div>
            </div>
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="cover-prosedur-detail" data-idx='{{ $idx_prosedur }}-{{ $alpha_prosedur }}'>
                @if(isset($data) && $data->prosedur_detail != null && $data->prosedur_detail->count() > 0)
                    @foreach($data->prosedur_detail as $iPrsD => $rPrsD)
                        {{ pka_lkp_rinci_prosedur_detail($iPrsD + 1, $rPrsD, $idxProsedur, $idx) }}
                    @endforeach
                @endif
            </div>
            <hr>
            <div class="form-group row">
                <label class="form-control-label col-md-2 col-sm-2 col-xs-12 ">
                </label>
                <div class="col-md-10 col-sm-10 col-xs-12">
                    <button type='button' class="btn btn-block btn-danger btn-sm btn-detail-prosedur" data-idx="{{ $idx_prosedur }}-{{ $alpha_prosedur }}"><i class="fa fa-plus"></i> Detail Prosedur</button>
                </div>
            </div>
        </div>
    </div>
</div>

