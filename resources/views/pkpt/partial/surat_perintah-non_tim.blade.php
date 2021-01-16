<div class="tim" data-id='0' data-idx=''>
    <div class="card-body">
        
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

            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Objek Pemeriksaan</th>
                            <th style="width:60px"></th>
                        </tr>
                    </thead>
                    <tbody id='cover-opd'>
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
                            <button type="button" class="btn btn-info add-opd"  data-tim=''> Pilih Obrik</button>
                        </td>
                    </tr>
                </table>
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
                    <tbody id='cover-anggota'>
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
                            <button type="button" class="btn btn-info add-anggota"  data-tim=''> Tambah Anggota</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
