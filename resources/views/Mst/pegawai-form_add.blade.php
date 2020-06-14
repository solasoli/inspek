<!-- modal add -->
<div class="modal" id="addModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Pegawai</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form class="form-layout form-layout-5" method="post" enctype="multipart/form-data" action="{{url()->current()}}/add">
          {{ csrf_field() }}

          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              NIP <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nip" value='{{ !is_null(old('nip')) ? old('nip') : (isset($data->nip) ? $data->nip : '') }}' required="required" class="form-control" type="text">
            </div>
          </div>


          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Nama & Gelar<span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nama" value='{{ !is_null(old('nama')) ? old('nama') : (isset($data->nama) ? $data->nama : '') }}' required="required" class="form-control" type="text">
            </div>
          </div>

          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Nama Asli <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nama_asli" value='{{ !is_null(old('nama_asli')) ? old('nama_asli') : (isset($data->nama_asli) ? $data->nama_asli : '') }}' required="required" class="form-control" type="text">
            </div>
          </div>
          
          <div class="form-group row" style="display: none">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              OPD <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name='opd' class="form-control select2">
                @foreach($opd as $idx => $row)
                @php
                $selected = !is_null(old('opd')) && old('opd') == $row->id ? "selected" : (isset($data->id_skpd) && $row->id == $data->id_skpd ? 'selected' : '');
                @endphp
                <option value='{{$row->id}}' {{$selected}}>{{$row->name}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group row" style="display: none">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Eselon <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name='eselon' class="form-control select2">
                @foreach($eselon as $idx => $row)
                @php
                $selected = !is_null(old('eselon')) && old('eselon') == $row->id ? "selected" : (isset($data->id_eselon) && $row->id == $data->id_eselon ? 'selected' : '');
                @endphp
                <option value='{{$row->id}}' {{$selected}}>{{$row->name}}</option>
                @endforeach
              </select>
            </div>
          </div>



          <div class="form-group row" style="display: none">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Pangkat <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name='pangkat' class="form-control select2">
                @foreach($pangkat as $idx => $row)
                @php
                $selected = !is_null(old('pangkat')) && old('pangkat') == $row->id ? "selected" : (isset($data->id_pangkat) && $row->id == $data->id_pangkat ? 'selected' : '');
                @endphp
                <option value='{{$row->id}}' {{$selected}}>{{$row->name}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Pangkat Golongan <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name='pangkat_golongan' class="form-control select2">
                @foreach($pangkat_golongan as $idx => $row)
                @php
                $selected = !is_null(old('pangkat_golongan')) && old('pangkat_golongan') == $row->id ? "selected" : (isset($data->id_pangkat_golongan) && $row->id == $data->id_pangkat_golongan ? 'selected' : '');
                @endphp
                <option value='{{$row->id}}' {{$selected}}>{{$row->name}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Jabatan <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name='jabatan' class="form-control select2" id='jabatan'>
                @foreach($jabatan as $idx => $row)
                @php
                $selected = !is_null(old('jabatan')) && old('jabatan') == $row->id ? "selected" : (isset($data->id_jabatan) && $row->id == $data->id_jabatan ? 'selected' : '');
                @endphp
                <option value='{{$row->id}}' {{$selected}}>{{$row->name}}</option>
                @endforeach
              </select>
            </div>
          </div>


          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Jenjang Jabatan <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="jenjab" value='{{ !is_null(old('jenjab')) ? old('jenjab') : (isset($data->jenjab) ? $data->jenjab : '') }}' required="required" class="form-control" type="text">
            </div>
          </div>


          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Score Angka Credit <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="score_angka_credit" value='{{ !is_null(old('score_angka_credit')) ? old('score_angka_credit') : (isset($data->score_angka_credit) ? $data->score_angka_credit : '') }}' required="required" class="form-control" type="text">
            </div>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group row mt-4 d-flex justify-content-center">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  $(function(){
    
  });
</script>
