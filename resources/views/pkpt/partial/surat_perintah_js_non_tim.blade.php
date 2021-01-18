
<script>
    var idx_tim = {{ isset($data->id) ? $data->tim->count() : 0 }};
    $(document).ready(function() {
        $(".kop").after(`
        <table style="width: 100%">
          <tr>
              <td width="100px" align="right"><img src="{{ asset('img/kop-warna.jpeg') }}"
                      width="100px" height="120px"></td>
              <td align="center">
                  <div style="margin-left: 0px;">
                      <h4 style="color:#000000; line-height: 1.2; font-family: arial, sans-serif;"><strong>PEMERINTAH DAERAH KOTA BOGOR</strong></h5>
                      <h3 style="color:#000000; line-height: 0.3;"><strong>INSPEKTORAT DAERAH</strong></h3>
                      <p style="font-family: times, sans-serif; font-size:16px; color:#000000; line-height:1.2;">Jalan Raya Pajajaran No. 5 Kota Bogor 16143<br>
                          Telp. (0251) 8313274/Faks. (0251) 8373229<br>
                          Website: inspektorat.kotabogor.go.id
                      </p>
                  </div>
              </td>
              <td width="100px"></td>
          </tr>
          <tr>
              <td colspan="3">
                  <hr style="margin-top: 0; color:#000000; border-top: 3px solid #000000; margin-bottom: 0px;">
                  <hr style="margin-top: 0; color:#000000; border-bottom: 1px solid #000000;">
              </td>
          </tr>
        </table>
        <div class="text-center" style="line-height: 0.5;">
          <h6 style="text-decoration: underline;">SURAT PERINTAH TUGAS</h6>
          <p>Nomor: {{ date('d/m/Y') }}</p>
          <p>INSPEKTUR KOTA BOGOR</p>
        </div>
        <div class="row" style="line-height: 0.5;">
          <div class="col-2" style="padding-left: 65px;">Dasar</div>
          <div class="col-1 pl-4">:</div>
          <div class="col-8" id="dasar_surat"></div>
        </div>
        <div class="text-center" style="line-height: 1;">
          <br>
          <p>MEMERINTAHKAN</p>
        </div>
        <div class="row">
          <div class="col-2" style="padding-left: 65px;">Kepada</div>
          <div class="col-1 pl-4">:</div>
          <div class="col-8">
              <div class="row">
                  <div class="col-2">Nama</div>
                  <div class="col-1">:</div>
                  <div class="col-8" id="inspektur_pembantu"></div>
              </div>
              <div class="row">
                  <div class="col-2">Jabatan</div>
                  <div class="col-1">:</div>
                  <div class="col-8"></div>
              </div>
              <div class="row">
                  <div class="col-2"></div>
                  <div class="col-1"></div>
                  <div class="col-8">Selaku Wakil Penanggung Jawab</div>
              </div>
              <br>
              <div class="row">
                  <div class="col-2">Nama</div>
                  <div class="col-1">:</div>
                  <div class="col-8" id="pengendali_teknis"></div>
              </div>
              <div class="row">
                  <div class="col-2">Jabatan</div>
                  <div class="col-1">:</div>
                  <div class="col-8"></div>
              </div>
              <div class="row">
                  <div class="col-2"></div>
                  <div class="col-1"></div>
                  <div class="col-8">Selaku Pengendali Teknis</div>
              </div>
              <br>
              <div class="row">
                  <div class="col-2">Nama</div>
                  <div class="col-1">:</div>
                  <div class="col-8" id="ketua_tim"></div>
              </div>
              <div class="row">
                  <div class="col-2">Jabatan</div>
                  <div class="col-1">:</div>
                  <div class="col-8"></div>
              </div>
              <div class="row">
                  <div class="col-2"></div>
                  <div class="col-1"></div>
                  <div class="col-8">Selaku Ketua Tim</div>
              </div>
              <br>
              <div class="row">
                  <div class="col-2">Anggota</div>
                  <div class="col-1">:</div>
                  <div class="col-8">
                    <ol style="padding-left: 10px">
                      <li id="anggota"></li>
                    </ol>
                  </div>
              </div>
          </div>
        </div>
        <div class="row">
            <div class="col-2" style="padding-left: 70px;">Untuk</div>
            <div class="col-1 pl-4">:</div>
            <div class="col-8">
                <ol style="padding-left: 15px;">
                    <li>Melaporkan hasilnya pada Inspektur daerah Kota Bogor</li>
                    <li>Melaksanakan surat perintah tugas ini dengan penuh tanggung jawab</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-6"></div>
            <div class="col-6">
                Dikeluarkan Di Bogor<br>
                Pada tanggal
                {{ date('d m Y') }}
    
                <div class="col-12 text-center">
                    <p>INSPEKTUR</p>
                    <br><br>
                    <span style="text-decoration:underline">inspektur name</span><br>
                    inspektur pangkat - pangkat golongan<br>
                    NIP. inspektur nip
                </div>
            </div>
        </div>
        <br>
        <div class="tembusan">
            Tembusan : <br>
            <span class="tembusan"></span>
        </div> `);
    
      $('.preview').on('click', function(e){
        e.preventDefault();
        var dasar_surat = $("textarea[name='dasar_surat']").val();
        var inspektur_pembantu = $(".inspektur_pembantu").find("option:selected").html();
        var pengendali_teknis = $(".pengendali_teknis").find("option:selected").html();
        var ketua_tim = $(".ketua_tim").find("option:selected").html();
        var anggota = $(".anggota").find("option:selected").html();
        var li_anggota = document.querySelectorAll('li#anggota');
        var tembusan = $("textarea[name='tembusan']").val();
    
        $("#dasar_surat").html(dasar_surat);
        $("#inspektur_pembantu").html(inspektur_pembantu);
        $("#pengendali_teknis").html(pengendali_teknis);
        $("#ketua_tim").html(ketua_tim);
        $("#anggota").html(anggota);
        $(".tembusan").html(tembusan);
    
        console.log(dasar_surat);
        console.log(tembusan);
      });
    });
    </script>
    
    <script>
      var addMoreAnggota = "<tr>";
      addMoreAnggota += "<td>";
      addMoreAnggota += "<select name='anggota[]' class='form-control select2 anggota'>";
      addMoreAnggota += "</select>";
      addMoreAnggota += "</td>";
      addMoreAnggota += "<td>";
      addMoreAnggota += "<button type='button' class='btn btn-danger btn-xs delete-anggota'><i class='fa fa-close'></i></button>";
      addMoreAnggota += "</td>";
      addMoreAnggota += "</tr>";
    
      
      var addMoreOpd = "<tr>";
      addMoreOpd += "<td>";
      addMoreOpd += "<select name='opd[]' class='form-control select2 opd'>";
      addMoreOpd += "</select>";
      addMoreOpd += "</td>";
      addMoreOpd += "<td>";
      addMoreOpd += "<button type='button' class='btn btn-danger btn-xs delete-opd'><i class='fa fa-close'></i></button>";
      addMoreOpd += "</td>";
      addMoreOpd += "</tr>";
    
    
      var optionAnggota = '';
      var optionOpd = '';
      var optionInspekturPembantu = [];
      var optionPengendaliTeknis = [];
      var optionKetuaTim = [];
    
      $(function(){
        @if(!isset($data->id))
          add_tim_section()
        @endif
        $("#program_kerja").on('change', function() {
          changeSasaranPk()
        })
        changeSasaranPk()
    
        function changeSasaranPk(){
          
          $(".sasaran-pk").html($("#program_kerja").find("option:selected").data('sasaran'))
          $(".kegiatan-pk").html($("#program_kerja").find("option:selected").data('kegiatanStr'))
        }

        
        change_wilayah($(".kegiatan"));
        $(".kegiatan").on("change", function(){
          change_wilayah($(this));
          kegiatan_filled_date();
        });
    
        function change_wilayah(el) { 
          var val = $(el).find("option:selected").data("wilayah");
    
          $("input[name='wilayah']").val(`[${val}]`);
          get_anggota(val);
          get_opd($(el).val());
    
          check_jadwal_surat_perintah();
        }

        
        function get_anggota(val){
          $.post("/mst/pegawai/get_anggota_by_wilayah", {"id_wilayah": val}, function(res){
            if(res.data != null){
              $(".anggota").html('');
    
              var option = '';
              $.when($.each(res.data, function(idx, val){
                $(".anggota").append("<option value='" + val.id +"'>" + val.nama + "</option>");
                option += "<option value='" + val.id +"'>" + val.nama + "</option>";
              })).then(function(){
                optionAnggota = option;
    
                
              $(".anggota[data-selected!=0]").map(function(idx, el) {
                $(el).val($(el).data('selected'))
              })
              });
            }
          });
        }
    
        
        function get_opd(val){
          $.post("/mst/skpd/get_skpd_by_program_kerja", {"id_program_kerja": val}, function(res){
            if(res.data != null){
              $("select.opd").html('');
    
              var option = '';
              $.when($.each(res.data, function(idx, val){
                $("select.opd").append("<option value='" + val.id +"'>" + val.name + "</option>");
                option += "<option value='" + val.id +"'>" + val.name + "</option>";
              })).then(function(){
                optionOpd = option;
    
                
              $("select.opd[data-selected!=0]").map(function(idx, el) {
                $(el).val($(el).data('selected'))
              })
              });
            }
          });
        }
    
        $("#wilayah, #dari_kalendar, #sampai_kalendar").on("change", function(){
          check_jadwal_surat_perintah();
        });
    
    
        function check_jadwal_surat_perintah(){
          $("#jadwal_warning").hide();
          if($(".wilayah").val() != "" && $("#dari_kalendar").val() != "" && $("#sampai_kalendar").val() != ""){
            $.post("/pkpt/surat_perintah/check_jadwal", {"id_wilayah": $(".kegiatan").find($("option:selected")).data('wilayah'), "dari" : $("#dari_kalendar").val(), "sampai": $("#sampai_kalendar").val(), "sp_id" : "{{ isset($data->id) ? $data->id : 0}}" }, function(res){
                if(res.show_warning == 1){
                  $("#jadwal_warning").html(res.msg).show();
                }
            });
          }
        }
    
        function kegiatan_filled_date() {
          var option_selected = $(".kegiatan").find($("option:selected"));
          $("#dari_kalendar").val(option_selected.data('dari'));
          $("#sampai_kalendar").val(option_selected.data('sampai'));
        }
        
        $(document).on('click', ".delete-anggota", function(){
          $(this).parent().closest("tr").remove();
        });
        
        $(document).on('click', ".delete-opd", function(){
          $(this).parent().closest("tr").remove();
        });

        $(document).on('click', ".add-opd", function(){
            console.log("OPD")
            $(`#cover-opd`).append(addMoreOpd);
    
            $(`#cover-opd tr:last .select2`).html(optionOpd);
            $(`#cover-opd tr:last .select2`).select2();
        });
    

    
        $('.fc-datepicker').datepicker({
          dateFormat: "dd-mm-yy"
        });
    
        $(document).on('click', ".add-anggota", function(){
            $(`#cover-anggota`).append(addMoreAnggota);
    
            $(`#cover-anggota tr:last .select2`).html(optionAnggota);
            $(`#cover-anggota tr:last .select2`).select2();
        });
    
        function add_tim_section() {
          let template_tim = `
          {{ sp_non_tim($list_inspektur) }}
          `
          idx_tim++;
          template_tim = template_tim.replace(/\[idx]/gm, idx_tim)
          template_tim = template_tim.replace('[option_inspektur_pembantu]', optionInspekturPembantu.join(''))
          template_tim = template_tim.replace('[option_pengendali_teknis]', optionPengendaliTeknis.join(''))
          template_tim = template_tim.replace('[option_ketua_tim]', optionKetuaTim.join(''))
          template_tim = template_tim.replace('[option_anggota]', optionAnggota)
          template_tim = template_tim.replace('[option_opd]', optionOpd)
    
          $(".cover-tim").append(template_tim)
        }
    
        $('#form-sp').on('submit', function(e) {
          e.preventDefault()
          const fixInput = [
              '_token',
              "dasar_surat",
              "program_kerja",
              "wilayah",
              "dari",
              "sampai",
              "tembusan",
              "jadikan_lampiran",
          ]
    
    
          let input = $(this).serializeArray()
          input = input.filter(r => fixInput.indexOf(r.name) !== -1)
          const mappingTim = []
    
          /* mapping langkah pemeriksaan rinci */
          $(".cover-tim").find($(".tim")).map((idx, el) => {
              // Tugas tab
    
              const anggota = []
              $(el).find($("select[name='anggota[]']")).map(function(idx, el_child) {
                  // console.log($(el_child).val())
                  anggota.push($(el_child).val())
              })
    
              const opd = []
              $(el).find($("select[name='opd[]']")).map(function(idx, el_child) {
                  // console.log($(el_child).val())
                  opd.push($(el_child).val())
              })
    
              mappingTim.push({
                  id_tim: $(el).data('id'),
                  no_tim: $(el).data('idx'),
                  inspektur: $(el).find($("[name='inspektur']")).val(),
                  inspektur_pembantu: $(el).find($("[name='inspektur_pembantu']")).val(),
                  pengendali_teknis: $(el).find($("[name='pengendali_teknis']")).val(),
                  ketua_tim: $(el).find($("[name='ketua_tim']")).val(),
                  anggota,
                  opd
              })
          })
    
          $('#mapping-tim').val(JSON.stringify(mappingTim))
    
          console.log(mappingTim);
          $(this).unbind('submit').submit();
        })
    
        $(document).on('click', '.delete-tim', function() {
          $(this).parent().closest($(".tim")).remove();
        })
    
      });
    </script>
    <script type="text/javascript">
          $('#more_info').change(function() {
            if(this.checked != true){
              $("#conditional_part").hide();
            }
            else{
              $("#conditional_part").show();
            }
          });
    </script>