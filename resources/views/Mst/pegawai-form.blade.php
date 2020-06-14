@extends('layouts.app')

@section('content')

<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="/">Master</a>
    <a class="breadcrumb-item Active" href="#">Pegawai</a>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">{{ isset($data) ? "Edit" : "Tambah" }} Pegawai</h4>
</div>

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
        <div class="card-header">
          <h6 class="card-title float-left py-2">FORM Pegawai</h6>
        </div>
        <div class="card-body">
          <form class="form-layout form-layout-5" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group row" style="display: none">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                OPD <span class="required">*</span> :
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
              </div>
            </div>

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Peran Irban<span class="required">*</span> :
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select name='peran' class="form-control select2" id='peran_irban'>
                  
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                NIP <span class="required">*</span> :
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="nip" value='{{ !is_null(old('nip')) ? old('nip') : (isset($data->nip) ? $data->nip : '') }}' required="required" class="form-control" type="text">
              </div>
            </div>


            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Nama & Gelar<span class="required">*</span> :
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="nama" value='{{ !is_null(old('nama')) ? old('nama') : (isset($data->nama) ? $data->nama : '') }}' required="required" class="form-control" type="text">
              </div>
            </div>

            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Nama Asli <span class="required">*</span> :
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="nama_asli" value='{{ !is_null(old('nama_asli')) ? old('nama_asli') : (isset($data->nama_asli) ? $data->nama_asli : '') }}' required="required" class="form-control" type="text">
              </div>
            </div>


            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Jenjang Jabatan <span class="required">*</span> :
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" name="jenjab" value='{{ !is_null(old('jenjab')) ? old('jenjab') : (isset($data->jenjab) ? $data->jenjab : '') }}' required="required" class="form-control" type="text">
              </div>
            </div>


            <div class="form-group row">
              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                Score Angka Credit <span class="required">*</span> :
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" name="score_angka_credit" value='{{ !is_null(old('score_angka_credit')) ? old('score_angka_credit') : (isset($data->score_angka_credit) ? $data->score_angka_credit : '') }}' required="required" class="form-control" type="text">
              </div>
            </div>

            <div class="ln_solid"></div>
            <div class="form-group row mt-4 d-flex justify-content-center">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a href='{{url('')}}/mst/periode' class="btn btn-danger" type="button">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(function(){
    var id_peran_irban = '{{ isset($data) && $data->id_peran > 0 ? $data->id_peran : 0 }}';
    
    get_peran_irban($('#jabatan').val());

    $("#jabatan").on('change', function(){

      get_peran_irban($('#jabatan').val());
    })

    function get_peran_irban(idJabatan){
      $.get('{{url("")}}/mst/peran/get_peran_by_jabatan/' + idJabatan, function(res){
        console.log(res);
        if(res != null){
          // var option = '<option value="' + '">- Pilih Peran -</option>';
          var option = '';

          $.each(res.data, function(idx, val){
            var selected = id_peran_irban == val.id ? "selected" : "";
            option += "<option value='"+ val.id +"' ";
            option += selected +" ";
            option += ">" + val.nama +"</option>";
          });

          $("#peran_irban").html(option);
        }
      });
    }
  });
</script>
  @endsection
