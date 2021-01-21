@extends('layouts.app')
@section('content')
<link href="{{ asset('admin_template/lib/jquery.steps/jquery.steps.css') }}" rel="stylesheet">

<style>
.wizard>.content>.body {
  width: 100% !important;
  overflow: auto !important;
}

section {
  background: #fff;
}

</style>
<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="/">Master</a>
    <a class="breadcrumb-item Active" href="#">Penentuan Tujuan Pemeriksaan</a>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">Penentuan Tujuan Pemeriksaan</h4>
</div>


  <div class="br-pagebody">
    @if (Session::has('error'))
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
    @if (Session::has('success'))
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

          <div class="card-header alert-success">
            <h6 class="card-title">Penentuan Sasaran Tujuan</h6>
          </div>
          <div class="card-body">

            <div id="wizard3">
              @php
                $all_isian = $data->penentuan_sasaran_tujuan;
              @endphp
              @foreach($sasaran_tujuan AS $idx => $row)
              <h3>{{ $row->nama }}</h3>
              <section>
                @php
                $isi = $all_isian->where('id_sasaran_tujuan', $row->id)->first();
                $isi = $isi != null ? $isi->isi : '';
                @endphp
                <div class='text-wizard'>
                  {!! $isi !!}
                </div>
              </section>
              @endforeach
            </div>

          </div>

          <div class="card-header"></div>
          <div class="card-body">
            <div class="form-group row d-flex justify-content-end">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a href='{{ url('') }}/pemeriksaan/sasaran-tujuan' class="btn btn-primary" type="button">Back</a>
                <a href='{{ url('') }}/pemeriksaan/sasaran-tujuan/edit/{{$id}}' class="btn btn-success" type="button">Edit</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- br-pagebody -->

<script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
<script src="{{ asset('admin_template/lib/ckeditor/plugin/autogrow.js') }}"></script>
<script src="{{ asset('admin_template/lib/jquery.steps/jquery.steps.js') }}"></script>
<script type="text/javascript">
$(function() {
  const localStoragePrefix = 'sasaran_tujuan-{{ Auth::user()->id . ' - ' . Request::segment(4) }}'
  const wizardName = 'wizard3'
  console.log(localStoragePrefix)

  let countDownKeyupEditor

  function bgStepChange(idx, txt) {
    const parsedTxt = txt.replace(/\s/g, '')
    console.log(parsedTxt)
    const tab = $(`#${wizardName}-t-${idx}`)
    if (parsedTxt.length > 10) {
      tab.find($('.number')).html(`<i class='fa fa-check'></i>`)
      tab.addClass('success')
      tab.removeClass('danger')
    } else {
      const number = tab.find($('.number'))
      number.html($(number).data('number'))
      tab.addClass('danger')
      tab.removeClass('success')
    }
  }

  CKEDITOR.editorConfig = function(config) {
    config.language = 'es';
    config.uiColor = '#F7B42C';
    config.height = '100%';
    config.width = '100%';
    config.toolbarCanCollapse = true;
  };

  $('#' + wizardName).steps({
    headerTag: 'h3',
    bodyTag: 'section',
    autoFocus: true,
    enableAllSteps: true,
    enablePagination: false,
    titleTemplate: '<span class="number" data-number="#index#">#index#</span> <span class="title">#title#</span>',
    stepsOrientation: 1
  });
  })

</script>

@endsection
