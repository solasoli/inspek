<script>
$(function() {
  $('#modal-form').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');

    if (id > 0) { // form edit
      $.get("{{url('')}}/mst/pegawai/get_pegawai_by_id/" + id, function(data) {
        // $('select[name="opd"]').val(data.id_skpd).trigger("change");
        $('select[name="eselon"]').val(data.id_eselon).trigger("change");
        $('select[name="pangkat"]').val(data.id_pangkat).trigger("change");
        $('select[name="wilayah"]').val(data.id_wilayah).trigger("change");
        $('select[name="pangkat_golongan"]').val(data.id_pangkat_golongan).trigger("change");
        $('select[name="jabatan"]').val(data.id_jabatan).trigger("change");
        $('input[name="nip"]').val(data.nip);
        $('input[name="nama"]').val(data.nama);
        $('input[name="nama_asli"]').val(data.nama_asli);
        $('input[name="jenjab"]').val(data.jenjab);
        $('input[name="score_angka_credit"]').val(data.score_angka_credit);
      });
      $("#form-pegawai").attr('action', '{{url()->current()}}/edit/'+ id +'');
    }

    else { // form add
      $("#form-pegawai").attr('action', '{{url()->current()}}/add');
    }

    $('#form-pegawai').on('submit', function(e){
      e.preventDefault();
      $('.error').html('');
      $.ajax({
       url: $(this).attr('action'),
       method: $(this).attr('method'),
       data: $(this).serialize(),
       dataType: 'json',
       success(response)
       {
         window.location.href = '{{url()->current()}}';
       },
       error(error)
       {
         let errors = error.responseJSON.errors;
         for(let key in errors) {
           let errorDiv = $(`.error[data-error="${key}"]`);
           if(errorDiv.length) {
             errorDiv.text(errors[key][0]);
           }
         }
       }
     });
    });

  });
  //
});
</script>
<div class="modal" id="modal-form">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Pegawai</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form id="form-pegawai" class="form-layout form-layout-5" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}


          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              NIP <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nip" value='{{ !is_null(old('nip')) ? old('nip') : (isset($data->nip) ? $data->nip : '') }}' required="required" class="form-control" type="text">
              <div class="text-danger error" data-error="nip"></div>
            </div>
          </div>


          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Nama & Gelar<span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nama" value='{{ !is_null(old('nama')) ? old('nama') : (isset($data->nama) ? $data->nama : '') }}' required="required" class="form-control" type="text">
              <div class="text-danger error" data-error="nama"></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Nama Asli <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="nama_asli" value='{{ !is_null(old('nama_asli')) ? old('nama_asli') : (isset($data->nama_asli) ? $data->nama_asli : '') }}' required="required" class="form-control" type="text">
              <div class="text-danger error" data-error="nama_asli"></div>
            </div>
          </div>

          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Irban <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name='wilayah' class="form-control select2">
                @foreach($wilayah as $idx => $row)
                @php
                $selected = !is_null(old('wilayah')) && old('wilayah') == $row->id ? "selected" : (isset($data->id_wilayah) && $row->id == $data->id_wilayah ? 'selected' : '');
                @endphp
                <option value='{{$row->id}}' {{$selected}}>{{$row->nama}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row" style="display: none">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              OPD <span class="">*</span> :
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
              <div class="text-danger error" data-error="opd"></div>
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
              <div class="text-danger error" data-error="eselon"></div>
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
              <div class="text-danger error" data-error="pangkat"></div>
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
              <div class="text-danger error" data-error="pangkat_golongan"></div>
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
              <div class="text-danger error" data-error="jabatan"></div>
            </div>
          </div>


          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Jenjang Jabatan <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="jenjab" value='{{ !is_null(old('jenjab')) ? old('jenjab') : (isset($data->jenjab) ? $data->jenjab : '') }}' required="required" class="form-control" type="text">
              <div class="text-danger error" data-error="jenjab"></div>
            </div>
          </div>


          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Score Angka Credit <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" name="score_angka_credit" value='{{ !is_null(old('score_angka_credit')) ? old('score_angka_credit') : (isset($data->score_angka_credit) ? $data->score_angka_credit : '') }}' required="required" class="form-control" type="text">
              <div class="text-danger error" data-error="score_angka_credit"></div>
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
        <a href="/mst/pegawai/detail-angka-kredit"><button type="submit" class="btn btn-success" >Detail Angka Kredit</button></a>
      </div>
    </div>
  </div>
</div>
