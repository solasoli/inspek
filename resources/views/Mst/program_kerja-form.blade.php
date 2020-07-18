<script>
$(function() {
  $('#editModal').on('show.bs.modal', function(e) {
    $("select[name='wilayah']").val('').trigger('change');
    $("select[name='opd']").html(''); // api na benang , kakara di clir
    var id = $(e.relatedTarget).data('id');

    if(id > 0) {
      $.get("{{url('')}}/mst/program_kerja/get_program_kerja_by_id?id=" + id, function(data) {
        // console.log(data);
        $('input[name="nama"]').val(data.nama);
        $('select[name="wilayah"]').val(data.id_wilayah).trigger("change");
        // $('select[name="opd"]').val(data.id_skpd).trigger("change");
        get_pd(data.id_skpd);
        $('input[name="dari"]').val(moment(new Date(data.dari)).format("DD-MM-YYYY"));
        $('input[name="sampai"]').val(moment(new Date(data.sampai)).format("DD-MM-YYYY"));

      }).done(function(res) {

        $.get("{{url('')}}/mst/program_kerja/get_sasaran_by_id_kegiatan?id=" + res.id, function(data) {
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
      });


      $("#form_edit").attr('action', '{{url()->current()}}/edit/'+ id +'');
    } else {

      $("#form_edit").attr('action', '{{url()->current()}}/add');
    }

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

  $('.fc-datepicker').datepicker({
    dateFormat: "dd-mm-yy"
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
    $("#cover-sasaran").append(am);
  });

  $(document).on('click', ".remove-sasaran", function(){
    $(this).parent().closest("tr").remove();
  });


  $("select[name='wilayah']").on('change', function(){
    get_pd();
  });

});
</script>
<div class="modal" id="editModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><span id='popup-method-program-kerja'></span> Program Kerja</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form class="form-layout form-layout-5" method="post" enctype="multipart/form-data" id="form_edit">
          {{ csrf_field() }}
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Irban :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select2" name="wilayah">
                <option value="" >- Pilih -</option>
                @foreach ($wilayah AS $row)
                  <option value="{{$row->id}}">{{$row->nama}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Perangkat Daerah :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select2" name="opd">
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
                    <th>Kegiatan *</th>
                    <th style="width:60px"></th>
                  </tr>
                </thead>
                <tr>
                  <td colspan="2">
                    <input name='nama' autocomplete="off" value='{{ !is_null(old('nama')) ? old('nama') : (isset($data->nama) ? $data->nama : '') }}' required="required" class="form-control" type="text" >
                  </td>
                </tr>
              </table>
              <table class="table" width="100%">
                <thead>
                  <tr>
                    <th>Sasaran</th>
                    <th style="width:60px"></th>
                  </tr>
                </thead>
                <tbody id='cover-sasaran_edit'>
                </tbody>
                <tr>
                  <td colspan="2">
                    <button type="button" class="btn btn-info add-sasaran"> Tambah Sasaran</button>
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
