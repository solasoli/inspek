@extends('layouts.app')
@section('content')
    <link href="{{ asset('admin_template/lib/dropzone/min/dropzone.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_template/lib/jquery.steps/jquery.steps.css') }}" rel="stylesheet">

    <style>
        .wizard>.content {
            height: auto !important;
        }
        .wizard>.content>.body {
            width: 100% !important;
            height: auto !important;
            overflow: initial !important;
            position: relative !important;
        }

        section {
            overflow: hidden;
        }

    </style>
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="/">Dashboard</a>
            <a class="breadcrumb-item" href="/">Master</a>
            <a class="breadcrumb-item Active" href="#">Audit</a>
        </nav>
    </div>

    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Pendidikan</h4>
    </div>
    
    <form class="form-layout form-layout-5" id='form-audit' style="padding-top:0" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
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
                            <h6 class="card-title">Pegawai</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                Pegawai <span class="required">*</span> :
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control select2" name='pegawai' id='pegawai'>
                                    @foreach($pegawai as $idx => $row) 
                                        <option value='{{ $row->id }}'>{{ $row->nip }} - {{ $row->nama }}</option>
                                    @endforeach
                                </select>
                              </div>
                            </div>
                  
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- br-pagebody -->

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
                            <h6 class="card-title">Pendidikan</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                Unsur <span class="required">*</span> :
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="unsur" disabled value='{{ $unsur->nama }}' class="form-control" type="text">
                              </div>
                            </div>
                  
                            <div class="form-group row">
                              <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                Sub Unsur <span class="required">*</span> :
                              </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <select class="form-control select2" name='sub_unsur' id='sub_unsur'>
                                </select>
                              </div>
                            </div>
                  
                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                  Butir Kegiatan <span class="required">*</span> :
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                  <select class="form-control select2" name='butir_kegiatan' id='butir_kegiatan'>
                                  </select>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                  Satuan Hasil <span class="required">*</span> :
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="satuan_hasil" disabled value='' class="form-control" id='satuan_hasil' type="text">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                  Angka Kredit <span class="required">*</span> :
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="angka_kredit" disabled value='' class="form-control" id='angka_kredit' type="text">
                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="alert alert-info">
                                        Pemisah Desimal disini menggunakan koma (,)
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                
                                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
                                  File Pendukung <span class="required">*</span> :
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" name="file" multiple class="form-control" id='file' type="text">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- br-pagebody -->
        
        <div class="card-body">
            <div class="form-group row d-flex justify-content-end">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href='{{ url('') }}/angka_kredit/hasil_angka_kredit' class="btn btn-danger"
                        type="button">Cancel</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>

    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <script src="{{ asset('admin_template/lib/ckeditor/plugin/autogrow.js') }}"></script>
    <script src="{{ asset('admin_template/lib/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin_template/lib/jquery.steps/jquery.steps.js') }}"></script>
    <script type="text/javascript">

        const cache = []
        const baseOptionKodeTemuan = []
        let kode_temuan_last_update = null
        $(function() {
            get_sub_unsur();
            async function get_sub_unsur() {
                const option = [];
                await $.get(`{{URL::to('/angka-kredit/perhitungan-angka-kredit/get-sub-unsur/pendidikan')}}/${$('#pegawai').val()}`).success(function (res) {
                    res.data.map(function(val) {
                        option.push(`<option value='${val.id}'>${val.nama}</option>`)
                    })   
                })
                console.log(option);
                $("#sub_unsur").html(option.join('')).trigger('change')
            }

            $("#sub_unsur").on('change', function () {
                get_butir_kegiatan();
            })
            
            async function get_butir_kegiatan() {
                const option = [];
                await $.get(`{{URL::to('/angka-kredit/perhitungan-angka-kredit/get-butir-kegiatan')}}/${$('#sub_unsur').val()}/${$('#pegawai').val()}`).success(function (res) {
                    res.data.map(function(val) {
                        console.log(val)
                        option.push(`<option value='${val.id}' data-angka-kredit='${val.angka_kredit}' data-satuan='${val.satuan.nama}'>${val.nama}</option>`)
                    })   
                })
                $("#butir_kegiatan").html(option.join('')).trigger('change')
            }

            $("#butir_kegiatan").on('change', function () {
                var option = $(this).find($("option:selected"))
                $("#satuan_hasil").val(option.data('satuan'))
                var angka_kredit_arr = option.data('angkaKredit').split('.')
                var decimal = parseInt(angka_kredit_arr[1]) > 0 ? angka_kredit_arr[1] : ''
                var angka_kredit = `${angka_kredit_arr[0]},${decimal}`
                $("#angka_kredit").val(angka_kredit)
            })

        })

    </script>

@endsection
