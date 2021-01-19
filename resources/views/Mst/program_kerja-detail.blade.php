<script>
$(function() {
  $('#detailModal').on('show.bs.modal', async function(e) {
    var id = $(e.relatedTarget).data('id');
    var el_btn_detail = $(".btn-detail[data-id='" + id + "']");
    var i = 0;
    var q = "";

    await $.get("{{url('')}}/mst/program_kerja/get_program_kerja_by_id?id=" + id, function(data) {
      console.log(data);

      let wilayah = `<ol style='padding-left: 20px'>`;
      data.wilayah.map(function(res) {
        wilayah += `<li>${res.nama}</li>`
      })
      wilayah += '</ol>'

      let jenis_pengawasan = `<ol style='padding-left: 20px'>`;
      data.jenis_pengawasan.map(function(res) {
        jenis_pengawasan += `<li>${res.nama}</li>`
      })
      jenis_pengawasan += '</ol>'

      let skpd = `<ol style='padding-left: 20px'>`;
      data.skpd.map(function(res) {
        skpd += `<li>${res.name}</li>`
      })
      skpd += '</ol>'
      q += `<tr>
        <td width='20%' style='vertical-align: top'>Pelaksana</td>
        <td>${wilayah}</td>
      </tr>
      
      <tr>
        <td>Dari</td>
        <td>: ${moment(new Date(data.dari)).format("DD-MM-YYYY")}</td>
      </tr>
      <tr>
        <td>Sampai</td>
        <td>: ${moment(new Date(data.sampai)).format("DD-MM-YYYY")}</td>
      </tr>
      <tr>
        <td>Jenis Kegiatan</td>
        <td>: ${data.kegiatan.nama}</td>
      </tr>
      <tr>
        <td style='vertical-align: top'>Jenis Pengawasan</td>
        <td>${jenis_pengawasan}</td>
      </tr>
      <tr>
        <td>Sasaran</td>
        <td>: ${data.sasaran}</td>
      </tr>
      <tr>
        <td style='vertical-align: top'>Perangkat Daerah</td>
        <td>${skpd}</td>
      </tr>"`;
    });

    $("#cover-sasaran_detail_1").html('');
    $("#cover-sasaran_detail_2").html('');

    console.log(q)
  
    $("#cover-sasaran_detail_1").append(q);


  });
});
</script>
<div class="modal" id="detailModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Detail Program Kerja</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <table border="0" width="100%" id='cover-sasaran_detail_1' cellpadding='5'>
        </table>
        <br><br>
      </div>
    </div>
  </div>
</div>
