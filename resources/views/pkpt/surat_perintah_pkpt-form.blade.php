@extends('layouts.app')
@section('content')
<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="/">Master</a>
    <a class="breadcrumb-item Active" href="#">Surat Perintah PKPT</a>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">{{ isset($data) ? "Edit" : "Tambah" }} Surat Perintah PKPT</h4>
</div>

<form class="form-layout form-layout-5" style="padding-top:0" method="post" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="br-pagebody">
    @if(Session::has('error'))
    <div class="row">
      <div class="alert alert-danger col-lg-12">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex align-items-center justify-content-start">
          <span>{!! Session::get('error') !!}</span>
        </div>
      </div>
    </div>
    @endif
    @if(Session::has('success'))
    <div class="row">
      <div class="alert alert-success col-lg-12">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex align-items-center justify-content-start">
          <span>{!! Session::get('success') !!}</span>
        </div>
      </div>
    </div>
    @endif
    <div class="row">
      <div class="col-lg-12 widget-2 px-0">
        <div class="card shadow-base">

            <div class="card-body">
              <div class="form-group row">
                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                  Dasar Surat
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea name='dasar_surat' class="form-control">{{ !is_null(old('dasar_surat')) ? old('dasar_surat') : (isset($data->dasar_surat) ? $data->dasar_surat : (isset($dasar_surat->dasar_surat) ? $dasar_surat->dasar_surat : '')) }}</textarea>
                </div>
              </div>
            </div>

            <div class="card-header">
              <h6 class="card-title float-left py-2">Program Kerja</h6>
            </div>
            <div class="card-body">
              <div class="form-group row" style="margin-bottom: 10px">
                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                  Pilih Kegiatan
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name='program_kerja' class="form-control select2 kegiatan">
                    @foreach($program_kerja as $idx => $row)
                      @php
                      $selected = !is_null(old('kegiatan')) && old('kegiatan') == $row->id ? 'selected' : isset($data->id) && $data->id_program_kerja == $row->id ? 'selected' : '';
                      @endphp
                      <option value='{{$row->id}}'
                        data-kegiatan='{{$row->kegiatan->id}}'
                        data-program_kerja='{{$row->id}}'
                        {{-- data-wilayah='{{$row->id_wilayah}}' --}}
                        data-dari='{{ date("d-m-yy",strtotime($row->dari)) }}'
                        data-sampai='{{ date("d-m-yy",strtotime($row->sampai)) }}' {{$selected}}>{{$row->kegiatan->nama}}</option>
                    @endforeach
                  </select>

                </div>

              </div>

              <input type="hidden" name="wilayah">
              <div class="form-group row">
                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                  Pilih Sasaran
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <!-- Jika Form Edit -->
                  @if(isset($data))
                    <select name='sasaran[]' class="form-control select2 sasaran" multiple>
                    </select>
                  <!-- Jika Form Add -->
                  @else
                    <select name='sasaran[]' class="form-control select2 sasaran" multiple></select>
                  @endif

                </div>
              </div>

              <div class="form-group row">
                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                  Dari
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                    <input type="text" name='dari' id="dari_kalendar" value="{{ !is_null(old('dari')) ? old('dari') : (isset($data->dari) ? date("d-m-Y", strtotime($data->dari)) : '') }}" class="form-control fc-datepicker" placeholder="DD-MM-YYYY" autocomplete="off">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                  Sampai
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="icon ion-calendar tx-16 lh-0 op-6"></i></span>
                    <input type="text" name='sampai' id="sampai_kalendar" value="{{ !is_null(old('sampai')) ? old('sampai') : (isset($data->sampai) ? date("d-m-Y", strtotime($data->sampai)) : '') }}" class="form-control fc-datepicker" placeholder="DD-MM-YYYY" autocomplete="off">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                  <div id="jadwal_warning" class="alert alert-warning" style="margin-bottom:10px; display: none;">
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-3">
                    <div class="card-header float-right" style="border-bottom: none;">
                    <p><input id="more_info" name="more-info" type="checkbox" />
                    <label id="data1">Jenis Kualifikasi</label></p>
                  </div>
                </div>
                <div class="col-md-6">
                <div id="conditional_part">
                  <div class="form-group">
                    <label for="pwd">Unsur</label>
                    <select name="" id="unsur" class="form-control">
                      @foreach($unsur as $idx => $row)
                        <option value="{{ $row->id }}">{{ $row->nama }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="pwd"> Sub Unsur</label>
                    <select name="" id="sub_unsur" class="form-control"></select>
                  </div>
                  <div class="form-group">
                    <label for="pwd">Butir Kegiatan</label>
                    <select name="" id="butir_kegiatan" class="form-control"></select>
                  </div>
              </div>
                </div>
              </div>

              <div class="form-group row">
                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                  Tembusan
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea name='tembusan' class="form-control">{{ !is_null(old('tembusan')) ? old('tembusan') : (isset($data->tembusan) ? $data->tembusan : '') }}</textarea>
                </div>
              </div>
            </div>

          <div class="card-header">
            <h6 class="card-title float-left py-2">Susunan Tim</h6>
          </div>
          <div class="card-body">

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Penanggung Jawab
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='inspektur' class="form-control select2">
                  @foreach($list_inspektur as $idx => $row)
                  @php
                  $selected = !is_null(old('inspektur')) && old('inspektur') == $row->id ? "selected" : (isset($data->id_inspektur) && $row->id == $data->id_inspektur ? 'selected' : '');
                  @endphp
                  <option value='{{$row->id}}' {{$selected}} data-nama="{{$row->nama}}">{{$row->nama}}</option>
                  @endforeach
                </select>
              </div>
            </div>


            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Wakil Penanggung Jawab
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='inspektur_pembantu' class="form-control select2 inspektur_pembantu">
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Pengendali Teknis
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='pengendali_teknis' class="form-control select2 pengendali_teknis">
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Ketua Tim
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='ketua_tim' class="form-control select2 ketua_tim">
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">

              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Anggota</th>
                      <th style="width:60px"></th>
                    </tr>
                  </thead>
                  <tbody id='cover-anggota'>
                    @if(!is_null(old('anggota')))
                      @foreach(old('anggota') as $i => $r)
                        <tr>
                          <td>
                            <select name='anggota[]' class="form-control select2 anggota">
                              @foreach($pegawai as $idx => $row)
                                @php
                                $selected = $row->id == $r ? "selected" : "";
                                @endphp
                                <option value='{{$row->id}}' {{$selected}}>{{$row->nama}}</option>
                              @endforeach
                            </select>
                          </td>
                          <td></td>
                        </tr>
                      @endforeach
                    @elseif(isset($data->id))
                      @foreach($data->anggota AS $idx => $row)
                        <tr>
                          <td>
                            <select name='anggota[]' class="form-control select2">
                              @foreach($anggota AS $i => $r)
                                @php
                                $selected = $row->id == $r->id ? 'selected' : '';
                                @endphp
                                <option value="{{$r->id}}" {{$selected}}>{{$r->nama}}</option>
                              @endforeach
                            </select>
                          </td>
                          <td>
                            @if($idx > 0)
                            <button type='button' class='btn btn-danger btn-xs remove-sasaran'><i class='fa fa-close'></i></button>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    @else
                      <tr>
                        <td>
                          <select name='anggota[]' class="form-control select2 anggota">
                          </select>
                        </td>
                        <td>
                        </td>
                      </tr>
                    @endif
                  </tbody>
                  <tr>
                    <td colspan="2">
                      <button type="button" class="btn btn-info add-anggota"> Tambah Anggota</button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

          </div>

          <div class="card-header"></div>
          <div class="card-body">
            <div class="form-group row d-flex justify-content-center">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a href='{{url('')}}/pkpt/surat_perintah' class="btn btn-danger" type="button">Cancel</a>
                <a href="#" class="preview btn btn-info" data-toggle="modal" data-target="#exampleModal">Preview</a>
                <button type="submit" class="btn btn-primary" >Submit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</form>

<style>

</style>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" id="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Preview Surat Perintah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid px-5">
          <div class="kop"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>

<script>
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

  var optionAnggota = '';

  $(function(){
    $('.fc-datepicker').datepicker({
      dateFormat: "dd-mm-yy"
    });

    $(".add-anggota").on('click', function(){
        $("#cover-anggota").append(addMoreAnggota);

        $("#cover-anggota tr:last .select2").html(optionAnggota);
        $("#cover-anggota tr:last .select2").select2();
    });

    change_wilayah($(".kegiatan"));
    kegiatan_filled_date();
    check_jadwal_surat_perintah();

    $(".kegiatan").on("change", function(){
      change_wilayah($(this));
      kegiatan_filled_date();
    });

    function change_wilayah(el){
      var val = $(el).find("option:selected").data("wilayah");

      $("input[name='wilayah']").val(val);
      get_inspektur_pembantu(val);
      get_pengendali_teknis(val);
      get_ketua_tim(val);
      get_anggota(val);
      get_sasaran();

      check_jadwal_surat_perintah();
    }

    function get_inspektur_pembantu(val){
      $.post("/mst/pegawai/get_inspektur_pembantu_by_wilayah", {"id_wilayah": val}, function(res){
        if(res.data != null){
          $(".inspektur_pembantu").html('');

          var data_edit = {{isset($data->id_inspektur_pembantu) ? $data->id_inspektur_pembantu : 0 }};

          $.each(res.data, function(idx, val){
            var selected = data_edit == val.id ? "selected" : "";
            $(".inspektur_pembantu").append("<option value='" + val.id +"' " +selected+ ">" + val.nama + "</option>");
          });
        }
      });
    }

    function get_pengendali_teknis(val){
      $.post("/mst/pegawai/get_pengendali_teknis_by_wilayah", {"id_wilayah": val}, function(res){
        if(res.data != null){
          $(".pengendali_teknis").html('');

          var data_edit = {{isset($data->id_pengendali_teknis) ? $data->id_pengendali_teknis : 0 }};

          $.each(res.data, function(idx, val){
            var selected = data_edit == val.id ? "selected" : "";
            $(".pengendali_teknis").append("<option value='" + val.id +"' " +selected+ ">" + val.nama + "</option>");
          });
        }
      });
    }

    function get_ketua_tim(val){
      $.post("/mst/pegawai/get_ketua_tim_by_wilayah", {"id_wilayah": val}, function(res){
        if(res.data != null){
          $(".ketua_tim").html('');

          var data_edit = {{isset($data->id_ketua_tim) ? $data->id_ketua_tim : 0 }};

          $.each(res.data, function(idx, val){
            var selected = data_edit == val.id ? "selected" : "";
            $(".ketua_tim").append("<option value='" + val.id +"' " +selected+ ">" + val.nama + "</option>");
          });
        }
      });
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

    function get_sasaran(){
      var id = $("select[name='program_kerja']").find($('option:selected')).data('program_kerja');
      $(".sasaran").html('');

      @php
      $arr = [];
      if(isset($data->id)){

        $arr = $data->sasaran->map(function($val) use($arr) {
          return $val->id;
        });
        $arr = $arr->toArray();
      }

      @endphp
      var data_edit = [{{ implode(',',$arr) }}];
      $.get("{{url('')}}/mst/sasaran/get_sasaran_by_id_program_kerja?id=" + id, function(data) {
        $(".sasaran").html('');
        // console.log(data);
        $.each(data, function(idx, val){
          var selected = data_edit.indexOf(val.id) != -1 ? 'selected' : '';
          var option = "<option value='"+val.id+"' "+ selected+">"+val.nama+"</option>";
          $(".sasaran").append(option);
        });
      });
    }

    $("#unsur").on("change", async function() {
      await get_sub_unsur();
    })

    get_sub_unsur();
    async function get_sub_unsur() {
        const option = [];
        await $.get(`{{URL::to('/pkpt/surat_perintah/get-sub-unsur')}}/${$('#unsur').val()}`).success(function (res) {
            res.data.map(function(val) {
                option.push(`<option value='${val.id}'>${val.nama}</option>`)
            })   
        })
        $("#sub_unsur").html(option.join('')).trigger('change')
    }

    $("#sub_unsur").on('change', function () {
        get_butir_kegiatan();
    })
    
    async function get_butir_kegiatan() {
        const option = [];
        await $.get(`{{URL::to('/pkpt/surat_perintah/get-butir-kegiatan')}}/${$('#sub_unsur').val()}`).success(function (res) {
            res.data.map(function(val) {
                option.push(`<option value='${val.id}' data-angka-kredit='${val.angka_kredit}' data-satuan='${val.satuan.nama}'>${val.nama}</option>`)
            })   
        })
        $("#butir_kegiatan").html(option.join('')).trigger('change')
    }


    // Jika Form Add, maka panggil function get_sasaran()
    @if (!isset($data))
      get_sasaran();
    @endif

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
@endsection
