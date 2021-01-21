@php
$tagIdx = !is_null($idx) && !is_null($idx) ? $idx : '[idx]';
$tagIdx = $multiple_pkpt ? $tagIdx : '';
@endphp


<div class="tim" data-id='0' data-idx='{{ $tagIdx }}'>
    <div class="card-header">
        <div class="pull-left d-flex align-items-center">
            <h6 class="card-title float-left py-2">Susunan Tim {{$tagIdx}}</h6>
            &nbsp;
            @if($multiple_pkpt)
                <button type='button' class='btn btn-danger btn-xs delete-tim'><i class='fa fa-close'></i> Hapus Tim</button>
            @endif
            <input id="jadikan_lampiran" class="ml-4" name="jadikan_lampiran" type="checkbox"/>
            <label style="font-size:13px;" class="ml-3 mt-2">Lampiran Surat Perintah</label>
        </div>
        <div class="pull-right">
            
        </div>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">

            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Objek Pemeriksaan</th>
                            <th style="width:60px"></th>
                        </tr>
                    </thead>
                    <tbody id='cover-opd-{{ $tagIdx}}'>
                        @if(isset($data->id))
                            @php
                                $idxA = 0;
                            @endphp
                            @foreach ($data->skpd as $idx => $row)
                            <tr>
                                <td>
                                    <select name='opd[]' class="form-control select2 opd" data-selected='{{ $row->id }}'>
                                        [option_opd]
                                    </select>
                                </td>
                                <td>
                                    @if($idxA > 0)
                                    <button type='button' class='btn btn-danger btn-xs delete-opd'><i class='fa fa-close'></i></button>
                                    @endif
                                </td>
                            </tr>
                            @php 
                                $idxA++;
                            @endphp
                            @endforeach
                        @else
                            <tr>
                                <td>
                                    <select name='opd[]' class="form-control select2 opd">
                                        [option_opd]
                                    </select>
                                </td>
                                <td>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    <tr>
                        <td colspan="2">
                            <button type="button" class="btn btn-info add-opd"  data-tim='{{$tagIdx}}'>Tambah Obrik</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Penanggung Jawab
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='inspektur' class="form-control select2">
                    @foreach ($list_inspektur as $idx => $row)
                        @php
                        $selected = !is_null(old('inspektur')) && old('inspektur') == $row->id ? "selected" :
                        (isset($data->id_inspektur) && $row->id == $data->id_inspektur ? 'selected' : '');
                        @endphp
                        <option value='{{ $row->id }}' {{ $selected }} data-nama="{{ $row->nama }}">{{ $row->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Wakil Penanggung Jawab
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='inspektur_pembantu' class="form-control select2 inspektur_pembantu" data-selected='{{ isset($data->id) ? $data->id_inspektur_pembantu : 0 }}'>
                    [option_inspektur_pembantu]
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Pengendali Teknis
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='pengendali_teknis' class="form-control select2 pengendali_teknis"  data-selected='{{ isset($data->id) ? $data->id_pengendali_teknis : 0 }}'>
                    [option_pengendali_teknis]
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Ketua Tim
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='ketua_tim' class="form-control select2 ketua_tim"  data-selected='{{ isset($data->id) ? $data->id_ketua_tim : 0 }}'>
                    [option_ketua_tim]
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">

            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Anggota</th>
                            <th style="width:60px"></th>
                        </tr>
                        
                    </thead>
                    <tbody id='cover-anggota-{{ $tagIdx}}'>
                        @if (!is_null(old('anggota')))
                            @foreach (old('anggota') as $i => $r)
                                <tr>
                                    <td>
                                        <select name='anggota[]' class="form-control select2 anggota">
                                            @foreach ($pegawai as $idx => $row)
                                                @php
                                                $selected = $row->id == $r ? "selected" : "";
                                                @endphp
                                                <option value='{{ $row->id }}' {{ $selected }}>{{ $row->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                            @endforeach
                        @elseif(isset($data->id))
                            @php
                                $idxA = 0;
                            @endphp
                            @foreach ($anggota as $idx => $row)
                            <tr>
                                <td>
                                    <select name='anggota[]' class="form-control select2 anggota" data-selected='{{ $row->id_anggota }}'>
                                        [option_anggota]
                                    </select>
                                </td>
                                <td>
                                    @if($idxA > 0)
                                    <button type='button' class='btn btn-danger btn-xs delete-anggota'><i class='fa fa-close'></i></button>
                                    @endif
                                </td>
                            </tr>
                            @php 
                                $idxA++;
                            @endphp
                            @endforeach
                        @else
                            <tr>
                                <td>
                                    <select name='anggota[]' class="form-control select2 anggota">
                                        [option_anggota]
                                    </select>
                                </td>
                                <td>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    <tr>
                        <td colspan="2">
                            <button type="button" class="btn btn-info add-anggota"  data-tim='{{$tagIdx}}'> Tambah Anggota</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

