<div class="card-body">
    <div class="form-group row">
        <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
        Dasar Surat
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <textarea name='dasar_surat' class="form-control">{{ !is_null(old('dasar_surat')) ? old('dasar_surat') : (isset($data->dasar_surat) ? $data->dasar_surat : (isset($dasar_surat->dasar_surat) ? $dasar_surat->dasar_surat : '')) }}</textarea>
        </div>
    </div>
    </div>

    <div class="card-header">
    <h6 class="card-title float-left py-2">Program Kerja</h6>
    </div>
    <div class="card-body">
    <div class="form-group row" style="margin-bottom: 10px">
        <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
        Pilih Sasaran
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <select name='program_kerja' class="form-control select2 kegiatan" id='program_kerja'>
            @foreach($program_kerja as $idx => $row)
            @php
            $wilayah_pk = $row->wilayah->map(function($val) {
                return $val->id;
            });
            $selected = !is_null(old('kegiatan')) && old('kegiatan') == $row->id ? 'selected' : isset($data->id) && $data->id_program_kerja == $row->id ? 'selected' : '';
            @endphp
            <option value='{{$row->id}}'
                data-kegiatan='{{$row->kegiatan->id}}'
                data-kegiatan-str='{{$row->kegiatan->nama}}'
                data-program_kerja='{{$row->id}}'
                data-sasaran='{{ $row->sasaran }}'
                {{-- data-jenis-pengawasan='{{ count($row->jenis_pengawasan) ? $row->jenis_pengawasan->nama : '' }}'--}}
                data-wilayah='{{ json_encode($wilayah_pk) }}'
                data-dari='{{ date("d-m-Y",strtotime($row->dari)) }}'
                data-sampai='{{ date("d-m-Y",strtotime($row->sampai)) }}' {{$selected}}>{{$row->sasaran}}</option>
            @endforeach

        </select>
        </div>

    </div>

    <input type="hidden" name="wilayah">
    {{-- <div class="form-group row">
        <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
        Sasaran
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12 sasaran-pk">
        {{--<!-- Jika Form Edit -->
        @if(isset($data))
            <select name='sasaran[]' class="form-control select2 sasaran" multiple>
            </select>
        <!-- Jika Form Add -->
        @else
            <select name='sasaran[]' class="form-control select2 sasaran" multiple></select>
        @endif

        </div>
    </div>
    --}}
    <div class="form-group row">
        <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
        Kegiatan
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12 kegiatan-pk">
        </div>
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
        Dari
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="input-group">
            <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
            <input  type="text" name='dari' id="dari_kalendar" value="{{ !is_null(old('dari')) ? old('dari') : (isset($data->dari) ? date("d-m-Y", strtotime($data->dari)) : '') }}" class="form-control fc-datepicker" placeholder="DD-MM-YYYY" autocomplete="off">
        </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
        Sampai
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="input-group">
            <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
            <input type="text" name='sampai' id="sampai_kalendar" value="{{ !is_null(old('sampai')) ? old('sampai') : (isset($data->sampai) ? date("d-m-Y", strtotime($data->sampai)) : '') }}" class="form-control fc-datepicker" placeholder="DD-MM-YYYY" autocomplete="off">
        </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
        <div id="jadwal_warning" class="alert alert-warning" style="margin-bottom:10px; display: none;">
        </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3">
            <div class="card-header float-right" style="border-bottom: none;">
            <p><input id="more_info" name="more-info" type="checkbox" />
            <label id="data1">Jenis Kualifikasi</label></p>
        </div>
        </div>
        <div class="col-md-6">
        <div id="conditional_part">
        <div class="form-group">
            <label for="pwd">Unsur</label>
            <select name="" id="unsur" class="form-control">
            @foreach($unsur as $idx => $row)
                <option value="{{ $row->id }}">{{ $row->nama }}</option>
            @endforeach
            </select>
        </div>
        {{-- 
        <div class="form-group">
            <label for="pwd"> Sub Unsur</label>
            <select name="" id="sub_unsur" class="form-control"></select>
        </div>
        <div class="form-group">
            <label for="pwd">Butir Kegiatan</label>
            <select name="" id="butir_kegiatan" class="form-control"></select>
        </div>
        --}}
    </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
        Tembusan
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <textarea name='tembusan' class="form-control">{{ !is_null(old('tembusan')) ? old('tembusan') : (isset($data->tembusan) ? $data->tembusan : '') }}</textarea>
        </div>
    </div>
    </div>