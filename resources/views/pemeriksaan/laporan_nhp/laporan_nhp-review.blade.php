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
            <a class="breadcrumb-item Active" href="#">NHP</a>
        </nav>
    </div>


    <form class="form-layout form-layout-5" id='form-review' style="padding-top:0" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type='hidden' name='mapping_kki' value='' id='mapping-kki'>
        <input type='hidden' name='step_approve' value='' id='step-approve'>
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
        </div><!-- br-pagebody -->

        <div class='cover-kertas-kerja-ikhtisar'>
            @php
            
            $idx_kki = 1;
            @endphp
            @foreach ($data->audit_kertas_kerja as $row)
                @php
                $kki = $row->kertas_kerja_ikhtisar->where('is_compilation', 1);   
                @endphp
                @if($kki->count() > 0)
                    @foreach($kki as $ix => $rw)
                        {{ adt_kertas_kerja_ikhtisar_review($idx_kki, $rw, 'nhp') }}

                        @php
                        $idx_kki++;   
                        @endphp
                    @endforeach

                @endif
            @endforeach
        </div>

        <div class="card-body">
            <div class="form-group row d-flex justify-content-end">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 d-flex justify-content-start">
                    <a href='{{ URL::to('/pemeriksaan/laporan_nhp/')}}' class="btn btn-info">Kembali Ke Review</a>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 d-flex justify-content-end">
                    <button type="button" class="btn btn-info review-submit"><i class="fa fa-star"></i> Review</button> &nbsp;
                    <button type="button" class="btn btn-primary approve-submit"><i class="fa fa-check"></i> Approve</button>
                </div>
            </div>
        </div>
    </form>

    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <script src="{{ asset('admin_template/lib/ckeditor/plugin/autogrow.js') }}"></script>
    <script src="{{ asset('admin_template/lib/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin_template/lib/jquery.steps/jquery.steps.js') }}"></script>
    <script type="text/javascript">
        var idx_kki = {{ $idx_kki }};

        const cache = []
        const baseOptionKodeTemuan = []
        let kode_temuan_last_update = null
        $(function() {
            const localStoragePrefix = 'audit-{{ Auth::user()->id . '-' . Request::segment(4) }}'

            let countDownKeyupEditor

            function handlingKeyupEditor(idx, elId, txt) {
                clearTimeout(countDownKeyupEditor)
                countDownKeyupEditor = setTimeout(function() {
                    localStorage.setItem(`${localStoragePrefix}-${elId}`, txt);
                    //bgStepChange(idx, $(txt).text())
                }, 300)
            }

            function bgStepChange(idx, txt, wizardName) {
                const parsedTxt = txt.replace(/\s/g, '')
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

            $(".dropzone").dropzone({
                success: function(res){
                    const resJson = JSON.parse(res.xhr.response)
                    $(".file-upload-res").append(`<li><a href='${resJson.file_url}'>${resJson.file_name}</a>`)
                }
            })


            CKEDITOR.replace($('#uraian_singkat').attr('id'), {
                extraPlugins: 'autogrow',
                on: {
                    change: function(e) {
                        // handlingKeyupEditor(idx, idEl, e.editor.getData())
                    }
                }
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
                            const editor = CKEDITOR.replace($(this).attr('id'), {
                                extraPlugins: 'autogrow',
                                on: {
                                    change: function(e) {
                                        $(`#${idEl}`).val(e.editor.getData())
                                        // handlingKeyupEditor(idx, idEl, e.editor.getData())
                                    },
                                    blur: function(e) {
                                        $(`#${idEl}`).val(e.editor.getData())
                                        // handlingKeyupEditor(idx, idEl, e.editor.getData())
                                    }
                                }
                            });
    
                            const kodeTemuanCoverHeight = typeof parentDiv.find($(".kode_temuan_cover")) != 'undefined' ? parentDiv.find($(".kode_temuan_cover")).height() : 0;
                            editor.setData(localStorage.getItem(
                                `${localStoragePrefix}-${idEl}`))
                            editor.on('instanceReady', function(e) {
                                if (idx == 0) {
                                }
    
                                const html = e.editor.getData()
                                //bgStepChange(idx, $(html).text(), wizardName)
                            });
    
                            editor.on('resize', function() {
    
                            });
    
                        });
                    },
                    onStepChanged: function(event, currIdx) {
                        const content = $(`#${wizardName}-p-${currIdx}`).find($(".cke"))
    
                        $(`#${wizardName}`).find($(".content")).height(content.height() + plusHeightWizard)
                    }
                });
            }

            function trigger_kki(idx_kki) {
                generateTextWizard(`wizard${idx_kki}`)

                // code temuan
                $(".cover-kertas-kerja-ikhtisar .kertas-kerja-ikhtisar").last().find($(".kode_temuan[data-level='1']"))
                .map(function(elKt) {
                    changeKodeTemuan($(this))
                })
            }


            if(idx_kki > 1) {
                for(var i = 1; i < idx_kki; i++) {
                    trigger_kki(i)
                }
                
                // code temuan
                $(".cover-kertas-kerja-ikhtisar .kertas-kerja-ikhtisar").find($(".kode_temuan[data-level='1']"))
                .map(function(elKt) {
                    changeKodeTemuan($(this))
                })
            }
            
            function confirmReview(){
                return confirm('Apakah anda yakin untuk melanjutkan Review?')
            }

            function confirmApprove(){
                return confirm('Semua Data Review Tidak Akan Disimpan. Apakah anda yakin untuk melanjutkan Approve?')
            }

            $(".review-submit").on('click', function(){
                $("#step-approve").val('review');
                const confirm = confirmReview();
                console.log(confirm);
                if(confirm) {
                    $("#form-review").submit();
                }
            })

            $(".approve-submit").on('click', function(){
                $("#step-approve").val('approve');
                const confirm = confirmApprove();
                if(confirm) {
                    $("#form-review").submit();
                }
            })

            
            $('#form-review').on('submit', function(e) {
                e.preventDefault()
                const fixInput = [
                    '_token',
                    'uraian_singkat',
                ]

                let input = $(this).serializeArray()
                input = input.filter(r => fixInput.indexOf(r.name) !== -1)

                const mappingKki = []

                /* mapping langkah pemeriksaan rinci */
                $(".cover-kertas-kerja-ikhtisar").find($(".kertas-kerja-ikhtisar")).map((idx, el) => {
                    const tagIdx = $(el).data('idx')
                    console.log(tagIdx);
                    // judul kondisi
                    const judul_kondisi = $(el).find($(`#judul_kondisi_${tagIdx}`)).val()
                    // uraian kondisi
                    const uraian_kondisi = $(el).find($("textarea[name='uraian_kondisi']")).val()

                    // kriteria
                    const kriteria = $(el).find($("textarea[name='kriteria']")).val()

                    // sebab
                    const sebab = $(el).find($("textarea[name='sebab']")).val()

                    // akibat
                    const akibat = $(el).find($("textarea[name='akibat']")).val()

                    // rekomendasi
                    const rekomendasi = $(el).find($("textarea[name='rekomendasi']")).val()

                    mappingKki.push({
                        idKki: $(el).data('id'),
                        judul_kondisi,
                        uraian_kondisi,
                        kriteria,
                        sebab,
                        akibat,
                        rekomendasi
                    })
                    console.log(rekomendasi)
                })
                
                $('#mapping-kki').val(JSON.stringify(mappingKki))

                $(this).unbind('submit').submit();
            })
        })

    </script>

@endsection
