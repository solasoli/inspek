
<form class="form-layout form-layout-5" method="POST" action="{{URL::to('/pkpt/surat_perintah/rubah_nomer')}}">
<!-- modal add -->
<div class="modal" id="nomerModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Penomeran Surat</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
          {{ csrf_field() }}
          <input type="hidden" value="" name='id' id='id_penomeran'>
          <div class="form-group row">
            <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
              nomer <span class="required">*</span> :
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name='no_surat' autocomplete="off" required="required" class="form-control no-surat" type="text" >
            </div>
          </div>
          <div class="form-group row mt-4 d-flex justify-content-center">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
</form>
