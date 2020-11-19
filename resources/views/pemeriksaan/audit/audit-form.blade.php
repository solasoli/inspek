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
        <h4 class="tx-gray-800 mg-b-5">Uraian Singkat</h4>
    </div>
    
    <div class="br-pagebody">
        <div class="row">
            <div class="col-lg-12 widget-2 px-0">
                <div class="card shadow-base">

                    <div class="card-header alert-success">
                        <h6 class="card-title">Unggah File</h6>
                    </div>
                    <div class="card-body">
                        <form action="/file-upload" class="dropzone">
                            <div class="fallback">
                            <input name="file" type="file" multiple />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form class="form-layout form-layout-5" style="padding-top:0" method="post" enctype="multipart/form-data">
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
                            <h6 class="card-title">Uraian Singkat</h6>
                        </div>
                        <div class="card-body">
                            <textarea name="judul" class='text-wizard' id="judul" rows="10" cols="80"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- br-pagebody -->
        
        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-20 d-flex justify-content-end">
            <button type='button' class="btn btn-primary btn-sm add-kertas-kerja-ikhtisar">
                <i class="fa fa-plus"></i> Kertas Kerja Ikhtisar
            </button>
        </div>

        <div class='cover-kertas-kerja-ikhtisar'>
        </div>

        <div class="card-body">
            <div class="form-group row d-flex justify-content-end">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href='{{ url('') }}/pemeriksaan/sasaran-tujuan' class="btn btn-danger"
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
        var idx_kki = 1;
        $(function() {
            const localStoragePrefix = 'audit-{{ Auth::user()->id . '-' . Request::segment(4) }}'

            let countDownKeyupEditor

            function handlingKeyupEditor(idx, elId, txt) {
                clearTimeout(countDownKeyupEditor)
                countDownKeyupEditor = setTimeout(function() {
                    console.log(idx, $(txt).text())
                    localStorage.setItem(`${localStoragePrefix}-${elId}`, txt);
                    bgStepChange(idx, $(txt).text())
                }, 300)
            }

            function bgStepChange(idx, txt, wizardName) {
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

            $(".text-wizard").map(function(idx, val) {
                const parentDiv = $(this).parent().closest('section')
                const idEl = $(this).attr('id')
                console.log(parentDiv)
                const editor = CKEDITOR.replace($(this).attr('id'), {
                    extraPlugins: 'autogrow',
                    on: {
                        change: function(e) {
                            handlingKeyupEditor(idx, idEl, e.editor
                                .getData())
                        }
                    }
                });

                console.log(localStorage.getItem(`${localStoragePrefix}-${idEl}`))
                editor.setData(localStorage.getItem(
                    `${localStoragePrefix}-${idEl}`))

            });

            function generateTextWizard(wizardName) {
                const plusHeightWizard = 65
                $('#' + wizardName).steps({
                    headerTag: 'h3',
                    bodyTag: 'section',
                    autoFocus: true,
                    enableAllSteps: true,
                    enablePagination: false,
                    titleTemplate: '<span class="number" data-number="#index#">#index#</span> <span class="title">#title#</span>',
                    stepsOrientation: 1,
                    onInit: function() {
                        $('#' + wizardName).find(".text-wizard").map(function(idx, val) {
                            const parentDiv = $(this).parent().closest('section')
                            const idEl = $(this).attr('id')
                            console.log(parentDiv)
                            const editor = CKEDITOR.replace($(this).attr('id'), {
                                extraPlugins: 'autogrow',
                                on: {
                                    change: function(e) {
                                        handlingKeyupEditor(idx, idEl, e.editor
                                            .getData())
                                    }
                                }
                            });
    
                            console.log(localStorage.getItem(`${localStoragePrefix}-${idEl}`))
                            const kodeTemuanCoverHeight = typeof parentDiv.find($(".kode_temuan_cover")) != 'undefined' ? parentDiv.find($(".kode_temuan_cover")).height() : 0;
                            console.log(kodeTemuanCoverHeight ,'kode temua cover heigh') 
                            editor.setData(localStorage.getItem(
                                `${localStoragePrefix}-${idEl}`))
                            editor.on('instanceReady', function(e) {
                                if (idx == 0) {
                                }
    
                                const html = e.editor.getData()
                                bgStepChange(idx, $(html).text(), wizardName)
                            });
    
                            editor.on('resize', function() {
                                console.log(wizardName);
    
                            });
    
                        });
                    },
                    onStepChanged: function(event, currIdx) {
                        const content = $(`#${wizardName}-p-${currIdx}`).find($(".cke"))
    
                        $(`#${wizardName}`).find($(".content")).height(content.height() + plusHeightWizard)
                    }
                });
            }

            $("div#dropzone").dropzone({ url: "/file/post" });

            function add_kertas_kerja_ikhtisar() {
                console.log(idx_kki)
                let template_kki = `
                {{ adt_kertas_kerja_ikhtisar() }}
                `
                template_kki = template_kki.replace(/\[idx]/gm, idx_kki)

                $('.cover-kertas-kerja-ikhtisar').append(template_kki)
                generateTextWizard(`wizard${idx_kki}`)

                idx_kki++;
            }

            add_kertas_kerja_ikhtisar()
            $(document).on('click', '.add-kertas-kerja-ikhtisar', function() {
                add_kertas_kerja_ikhtisar()
            })

            $(document).on('change', '.kode_temuan', function(){
                const currentLevel = $(this).data('level');
            })
        })

    </script>

@endsection
