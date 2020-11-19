@php
$alpha_prosedur = !is_null($idxProsedur) ? num2alpha($idxProsedur) : '[alpha_prosedur]';
$idx_prosedur = !is_null($idxLkp) ? $idxLkp : '[idx_prosedur]';
$id_prosedur = !is_null($prosedur) ? $prosedur->id : 0;
@endphp
<div class="row pelaksana-row" data-idx='{{ $idx_prosedur }}-{{ $alpha_prosedur }}'>
    <div class="col-md-6">
        <h6 class="tx-gray-800 tx-uppercase tx-bold mg-b-10">Prosedur Pemeriksaan :</h6>
        <h6 class="tx-gray-800 tx-uppercase tx-bold mg-b-10">{{ $alpha_prosedur }}. <span class='prosedur-label-{{ $idx_prosedur }}-{{ $alpha_prosedur }}'>{{ isset($prosedur) ? $prosedur->prosedur : ''}}</span></h6>
        <ol class='list-prosedur-detail' data-idx='{{ $idx_prosedur }}-{{ $alpha_prosedur }}'>
            @if(isset($prosedur))
                @foreach($prosedur->prosedur_detail as $iPd => $rPd)
                    <li class='prosedur-detail-list' data-idx='{{ $idx_prosedur }}-{{ $alpha_prosedur }}-{{ $iPd + 1 }}'>{{ $rPd->prosedur_detail }}</li>
                @endforeach
            @endif
        </ol>
    </div>
    <div class="col-md-6">
        <h6 class="tx-gray-800 tx-uppercase tx-bold mg-b-10 text-center">Rencana</h6>
        <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Pelaksana
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='rencana_pelaksana' class="form-control pelaksana-rencana">
                    @foreach($anggota as $idx => $row)
                        @php 
                            $selected = isset($data) && $data->id_pelaksana_rencana == $row->id ? 'selected' : '';
                        @endphp
                        <option value='{{$row->id}}' {{ $selected }}>{{ $row->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Durasi
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input name='rencana_durasi' class="form-control durasi-rencana" value='{{ isset($data) ? $data->durasi_rencana : '' }}' style='max-width: 50px; display:inline'> Jam
            </div>
        </div>

        <h6 class="tx-gray-800 tx-uppercase tx-bold mg-b-10 text-center">Realisasi</h6>
        <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Pelaksana
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='rencana_pelaksana' class="form-control pelaksana-realisasi">
                    @foreach($anggota as $idx => $row)
                        @php 
                            $selected = isset($data->id_pelaksana_realisasi) && $data->id_pelaksana_realisasi == $row->id ? 'selected' : '';
                        @endphp
                        <option value='{{$row->id}}' {{ $selected }}>{{ $row->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Durasi
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input name='rencana_durasi' class="form-control durasi-realisasi" value='{{ isset($data) ? $data->durasi_realisasi : '' }}' style='max-width: 50px; display:inline'> Jam
            </div>
        </div>
    </div>
</div>
<hr>