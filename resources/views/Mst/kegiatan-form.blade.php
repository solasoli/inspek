<script>
$(function() {
  $('#modal-form').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');

    if (id > 0) { // form edit
      $.get("{{url('')}}/mst/kegiatan/get_kegiatan_by_id?id=" + id, function(data) {
        $('input[name="nama"]').val(data.nama);
      });

      $("#form-kegiatan").attr('action', '{{url()->current()}}/edit/'+ id +'');
    }

    else { // form add
      $("#form-kegiatan").attr('action', '{{url()->current()}}/add');
    }

    $('#form-kegiatan').on('submit', function(e){
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
        <h4 class="modal-title">Kegiatan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form id="form-kegiatan" class="form-layout form-layout-5" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Nama Kegiatan <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name='nama' autocomplete="off" required="required" class="form-control" type="text" >
              <div class="text-danger error" data-error="nama"></div>
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
