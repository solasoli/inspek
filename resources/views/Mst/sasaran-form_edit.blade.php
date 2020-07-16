<script>
$(function() {
  $('#editModal').on('show.bs.modal', function(e) {
    var id_skpd = $(e.relatedTarget).data('idkegiatan');

    $.get("{{url('')}}/mst/kegiatan/get_kegiatan_by_id?id=" + id_skpd, function(data) {
      // console.log(data);
      $('input[name="nama"]').val(data.nama);
      $('select[name="skpd"]').val(data.id_skpd).trigger("change");
    });

    $("#form_edit").attr('action', '{{url()->current()}}/edit/'+ id_skpd +'');
  });
});
</script>
<div class="modal" id="editModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Sasaran</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form class="form-layout form-layout-5" method="post" enctype="multipart/form-data" id="form_edit">
          {{ csrf_field() }}
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Nama Kegiatan <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name='nama' autocomplete="off" required="required" class="form-control" type="text" >
            </div>
          </div>
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Perangkat Daerah :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select2" name="skpd">
                @foreach ($skpd AS $row)
                  <option value="{{$row->id}}">{{$row->name}}</option>
                @endforeach
              </select>
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
