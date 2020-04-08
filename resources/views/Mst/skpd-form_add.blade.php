<!-- modal add -->
<div class="modal" id="addModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Perangkat Daerah</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form class="form-layout form-layout-5" method="post" enctype="multipart/form-data" action="{{url()->current()}}/add">
          {{ csrf_field() }}
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Nama SKPD <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name='name' autocomplete="off" value='{{ !is_null(old('name')) ? old('name') : (isset($data->name) ? $data->name : '') }}' required="required" class="form-control" type="text" >
            </div>
          </div>
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              Singkatan PD :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name='singkatan_pd' autocomplete="off" value='{{ !is_null(old('singkatan_pd')) ? old('singkatan_pd') : (isset($data->singkatan_pd) ? $data->singkatan_pd : '') }}' class="form-control" type="text" >
            </div>
          </div>
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
