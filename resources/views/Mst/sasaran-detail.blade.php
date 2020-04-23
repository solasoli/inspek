<script>
$(function() {
  $('#detailModal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    var el_btn_detail = $(".btn-detail[data-id='" + id + "']");
    var i = 0;
    var q = "";

    $("#cover-sasaran_detail_1").html('');
    $("#cover-sasaran_detail_2").html('');

    q += "<tr>";
    q +=  "<td width='20%'>Kegiatan</td>";
    q +=  "<td>: "+ $(el_btn_detail).data('kegiatan') +"</td>";
    q +="</tr>";
    q += "<tr>";
    q +=  "<td width='1%'>Irban</td>";
    q +=  "<td>: "+ $(el_btn_detail).data('wilayah') +"</td>";
    q +="</tr>";
    q += "<tr>";
    q +=  "<td width='1%'>Perangka Daerah</td>";
    q +=  "<td>: "+ $(el_btn_detail).data('skpd') +"</td>";
    q +="</tr>";
    q += "<tr>";
    q +=  "<td>Dari</td>";
    q +=  "<td>: "+ moment(new Date($(el_btn_detail).data('dari'))).format("DD-MM-YYYY") +"</td>";
    q +="</tr>";
    q += "<tr>";
    q +=  "<td>Sampai</td>";
    q +=  "<td>: "+ moment(new Date($(el_btn_detail).data('sampai'))).format("DD-MM-YYYY") +"</td>";
    q +="</tr>";
    $("#cover-sasaran_detail_1").append(q);

    $.get("{{url('')}}/mst/sasaran/get_sasaran_by_id_kegiatan?id=" + id, function(data) {
      // console.log(data);
      $.each(data, function(idx, val){
        i++;
        var r = "<tr>";
        r += "<td width='5%' align='center'>"+ i +". </td>";
        r += "<td>"+ val.nama +"</td>";
        r += "</tr>";
        $("#cover-sasaran_detail_2").append(r);
      });
    });

  });
});
</script>
<div class="modal" id="detailModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Detail Kegiatan</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <table border="0" width="100%" id='cover-sasaran_detail_1' cellpadding='5'>
        </table>
        <br><br>
        <table width="100%" cellpadding='5' class="table">
          <th colspan="2" class="text-center">Program Kerja</th>
          <tbody id='cover-sasaran_detail_2'>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
