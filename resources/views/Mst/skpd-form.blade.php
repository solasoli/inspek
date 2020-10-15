<script>
$(function() {
  $('#modal-form').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');

    if (id > 0) { // form edit
      $.get("{{url('')}}/mst/skpd/get_skpd_by_id?id=" + id, function(data) {
        // console.log(data);
        $('input[name="name"]').val(data.name);
        // $('input[name="singkatan_pd"]').val(data.singkatan_pd);
        $('input[name="pimpinan"]').val(data.pimpinan);
        $('select[name="wilayah"]').val(data.id_wilayah).trigger("change");
      });

      $("#form-skpd").attr('action', '{{url()->current()}}/edit/'+ id +'');
    }

    else { // form add
      $("#form-skpd").attr('action', '{{url()->current()}}/add');
    }

    $('#form-skpd').on('submit', function(e){
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
});
</script>
<div class="modal" id="modal-form">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Perangkat Daerah</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form id='form-skpd' class="form-layout form-layout-5" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Nama SKPD <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name='name' autocomplete="off" required="required" class="form-control" type="text" >
              <div class="text-danger error" data-error="name"></div>
            </div>
          </div>
          <!-- <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Singkatan PD :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name='singkatan_pd' autocomplete="off" class="form-control" type="text" >
            </div>
          </div> -->
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Pimpinan :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name='pimpinan' autocomplete="off" value='{{ !is_null(old('pimpinan')) ? old('pimpinan') : (isset($data->pimpinan) ? $data->pimpinan : '') }}' class="form-control" type="text" >
            </div>
          </div>
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Wilayah Kerja :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select2" name="wilayah">
                @foreach ($wilayah_kerja AS $row)
                  <option value="{{$row->id}}">{{$row->nama}}</option>
                @endforeach
              </select>
              <div class="text-danger error" data-error="wilayah"></div>
            </div>
          </div>
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
