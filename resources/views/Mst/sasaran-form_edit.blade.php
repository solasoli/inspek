<script>
$(function() {
  $('#editModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');

    $.get("{{url('')}}/mst/sasaran/get_kegiatan_by_id?id=" + id, function(data) {
      // console.log(data);
      $('input[name="nama"]').val(data.nama);
      $('select[name="opd"]').val(data.id_skpd).trigger("change");
      $('input[name="dari"]').val(moment(new Date(data.dari)).format("DD-MM-YYYY"));
      $('input[name="sampai"]').val(moment(new Date(data.sampai)).format("DD-MM-YYYY"));
    });

    $.get("{{url('')}}/mst/sasaran/get_sasaran_by_id_kegiatan?id=" + id, function(data) {
      // console.log(data);
      $.each(data, function(idx, val){
        var r = "<tr>";
        r += "<td>";
        r += "<input name='sasaran[]' value='"+ val.nama +"' autocomplete='off' required='required' class='form-control' type='text'>";
        r += "</td>";
        r += "<td>";
        r += "<button type='button' class='btn btn-danger btn-xs remove-sasaran'><i class='fa fa-close'></i></button>";
        r += "</td>";
        r += "</tr>";
        $("#cover-sasaran_edit").append(r);
      });
    });

    $(".add-sasaran").on('click', function(){
      var am = "<tr>";
      am += "<td>";
      am += "<input name='sasaran[]' autocomplete='off' required='required' class='form-control' type='text'>";
      am += "</td>";
      am += "<td>";
      am += "<button type='button' class='btn btn-danger btn-xs remove-sasaran'><i class='fa fa-close'></i></button>";
      am += "</td>";
      am += "</tr>";
      $("#cover-sasaran_edit").append(am);
    });

    $("#form_edit").attr('action', '{{url()->current()}}/edit/'+ id +'');
  });
});
</script>
<div class="modal" id="editModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Edit Kegiatan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form class="form-layout form-layout-5" method="post" enctype="multipart/form-data" id="form_edit">
          {{ csrf_field() }}
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Kegiatan <span class="required"></span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name='nama' autocomplete="off" value='{{ !is_null(old('nama')) ? old('nama') : (isset($data->nama) ? $data->nama : '') }}' required="required" class="form-control" type="text" >
            </div>
          </div>
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Perangkat Daerah :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select2" name="opd">
                @foreach ($opd AS $row)
                  <option value="{{$row->id}}">{{$row->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Dari <span class="required"></span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                <input name='dari' placeholder="DD-MM-YYYY" required="required" class="form-control fc-datepicker" type="text" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Sampai <span class="required"></span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="input-group">
                <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                <input name='sampai' placeholder="DD-MM-YYYY" required="required" class="form-control fc-datepicker" type="text" autocomplete="off">
              </div>
            </div>
          </div>
          <hr>
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">

            </label>
            <div class="col-md-12">
              <table class="table" width="100%">
                <thead>
                  <tr>
                    <th>Program Kerja</th>
                    <th style="width:60px"></th>
                  </tr>
                </thead>
                <tbody id='cover-sasaran_edit'>
                </tbody>
                <tr>
                  <td colspan="2">
                    <button type="button" class="btn btn-info add-sasaran"> Tambah Program Kerja</button>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div class="form-group row mt-4 d-flex justify-content-center">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 d-flex justify-content-center">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>&nbsp;
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
