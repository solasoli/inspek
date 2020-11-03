@extends('layouts.app')
@section('content')
    <link href="{{ asset('admin_template/lib/jquery.steps/jquery.steps.css') }}" rel="stylesheet">

    <style>
        .wizard>.content>.body {
            width: 100% !important;
            overflow: initial !important;
        }

        section {
            overflow: hidden;
        }

    </style>
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="/">Dashboard</a>
            <a class="breadcrumb-item" href="/">Master</a>
            <a class="breadcrumb-item Active" href="#">Penentuan Sasaran Tujuan</a>
        </nav>
    </div>

    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Penentuan Sasaran Tujuan</h4>
    </div>

    <form class="form-layout form-layout-5" id='form-rka' style="padding-top:0" method="post" enctype="multipart/form-data">
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
                            <h6 class="card-title">Penentuan Sasaran Tujuan</h6>
                        </div>
                        <div class="card-body">
                            <div id="wizard3">
                                <h3>Judul</h3>
                                <section>
                                    <textarea name="judul" class='text-wizard' id="judul" rows="10"
                                        cols="80"></textarea>
                                </section>
                                <h3>Pendahuluan</h3>
                                <section>
                                    <textarea name="pendahuluan" class='text-wizard' id="pendahuluan" rows="10"
                                        cols="80"></textarea>
                                </section>
                                <h3>Tujuan Pemeriksaan</h3>
                                <section>
                                    <textarea name="tujuan_pemeriksaan" class='text-wizard' id="tujuan_pemeriksaan" rows="10"
                                        cols="80"></textarea>
                                </section>
                                <h3>Ruang Lingkup Pemeriksaan</h3>
                                <section>
                                    <textarea name="ruang_lingkup_pemeriksaan" class='text-wizard' id="ruang_lingkup_pemeriksaan" rows="10"
                                        cols="80"></textarea>
                                </section>
                                <h3>Waktu Pelaksanaan</h3>
                                <section>
                                    <textarea name="waktu_pelaksanaan" class='text-wizard' id="waktu_pelaksanaan" rows="10"
                                        cols="80"></textarea>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- br-pagebody -->

        <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-20 d-flex justify-content-end">
            <button type='button' class="btn btn-primary btn-sm add-langkah-kerja-pemeriksaan-rinci">
                <i class="fa fa-plus"></i> Langkah Kerja Pemeriksaan Rinci
            </button>
        </div>
                              
        <div class='cover-langkah-kerja-pemeriksaan-rinci'>
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
    <script src="{{ asset('admin_template/lib/jquery.steps/jquery.steps.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            const localStoragePrefix = 'sasaran_tujuan-{{ Auth::user()->id . ' - ' . Request::segment(4) }}'
            const wizardName = 'wizard3'
            console.log(localStoragePrefix)

            let countDownKeyupEditor

            function handlingKeyupEditor(idx, elId, txt) {
                clearTimeout(countDownKeyupEditor)
                countDownKeyupEditor = setTimeout(function() {
                    console.log(idx, $(txt).text())
                    localStorage.setItem(`${localStoragePrefix}-${elId}`, txt);
                    bgStepChange(idx, $(txt).text())
                }, 300)
            }

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
                stepsOrientation: 1,
                onInit: function() {

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
                        editor.on('instanceReady', function(e) {
                            console.log($(this))
                            if (idx == 0) {
                                $('#' + wizardName).find($(".content")).height(
                                    parentDiv
                                    .find($(".cke")).height() + 35);
                            }

                            const html = e.editor.getData()
                            bgStepChange(idx, $(html).text())
                        });

                        editor.on('resize', function() {
                            console.log($(this))
                            console.log('resized...');

                            $('#' + wizardName).find($(".content")).height(parentDiv
                                .find($(".cke")).height() + 35);

                        });

                    });
                },
                onStepChanged: function(event, currIdx) {
                    const content = $(`#${wizardName}-p-${currIdx}`).find($(".cke"))

                    $(`#${wizardName}`).find($(".content")).height(content.height() + 35)
                }
            });

            /*
            Langkah Kerja Pemeriksaan Rinci JS
            */
            let idx_pemeriksaan_rinci = 1
            const alpha_uraian = []
            const num_uraian = []
            add_langkah_kerja_pemeriksaan_rinci()
            
            function add_sub_judul_tugas(subJudulTugasEl, value) {
                if (typeof subJudulTugasEl != 'undefined') {
                    value = typeof value != 'undefined' ? value.trim() : '' 
                    let template_sub_judul_tugas = `
                    @include('pemeriksaan.program-kerja-audit.partial-view.sub_judul_tugas')
                    `
                    template_sub_judul_tugas = template_sub_judul_tugas.replace('[value]', value)

                    $(subJudulTugasEl).append(template_sub_judul_tugas)
                } else {
                    console.log("CANNOT FIND SUB JUDUL TUGAS ELEMENT")
                }
            }

            function add_langkah_kerja_pemeriksaan_rinci() {
                let template_lkpr = `
                @include('pemeriksaan.program-kerja-audit.partial-view.lkp_rinci', ['data' => $data])
                `
                template_lkpr = template_lkpr.replace(/\[idx]/gm, idx_pemeriksaan_rinci)

                $('.cover-langkah-kerja-pemeriksaan-rinci').append(template_lkpr)

                idx_pemeriksaan_rinci++
            }

            $(document).on('click', '.add-sub-judul-tugas', function() {
                const tugas_tab = $(this).parent().closest($(".tugas-tab"))
                const sub_judul_tugas_cover = tugas_tab.find($(".sub-judul-tugas-cover"))

                add_sub_judul_tugas(sub_judul_tugas_cover)
            })
            
            $(document).on('click', '.add-langkah-kerja-pemeriksaan-rinci', function() {
                add_langkah_kerja_pemeriksaan_rinci()
            })

            $(document).on('click', '.remove-sub-judul-tugas', function() {
                $(this).parent().closest($(".row")).remove();
            })

            function add_uraian(idx_uraian) {
                if (idx_uraian) {
                    alpha_uraian[idx_uraian] = alpha_uraian[idx_uraian] != null ? alpha_uraian[idx_uraian] + 1 : 1
                    const uraian_cover = $(`.cover-uraian[data-idx='${idx_uraian}']`)
                    uraian_cover.find($(".no-available-uraian")).remove()
                    let template_uraian = `
                    @include('pemeriksaan.program-kerja-audit.partial-view.lkp_rinci-uraian')
                    `

                    const alphabet = numToSSColumn(alpha_uraian[idx_uraian])
                    template_uraian = template_uraian.replace(/\[idx_uraian]/gm, idx_pemeriksaan_rinci)
                    template_uraian = template_uraian.replace(/\[alpha_uraian]/gm, alphabet)
                    uraian_cover.append(template_uraian)
                } else {
                    console.log('FAILED TO GENERATE IDX URAIAN')
                }
            }

            function add_uraian_detail(idx_uraian) {
                console.log(idx_uraian)
                if (idx_uraian != '') {
                    num_uraian[idx_uraian] = num_uraian[idx_uraian] != null ? num_uraian[idx_uraian] + 1 : 1
                    const uraian_cover = $(`.cover-uraian-detail[data-idx='${idx_uraian}']`)
                    uraian_cover.find($(".no-available-uraian")).remove()
                    let template_uraian_detail = `
                    @include('pemeriksaan.program-kerja-audit.partial-view.lkp_rinci-uraian-detail')
                    `

                    const alphabet = numToSSColumn(num_uraian[idx_uraian])
                    template_uraian_detail = template_uraian_detail.replace(/\[num_uraian]/gm, num_uraian[idx_uraian])
                    uraian_cover.append(template_uraian_detail)
                } else {
                    console.log('FAILED TO GENERATE IDX URAIAN')
                }
            }

            function numToSSColumn(num){
                var s = '', t;

                while (num > 0) {
                    t = (num - 1) % 26;
                    s = String.fromCharCode(65 + t) + s;
                    num = (num - t)/26 | 0;
                }
                return s || undefined;
            }

            $(document).on('click', '.btn-uraian', function() {
                add_uraian($(this).data('idx'))
            })

            $(document).on('click', '.btn-detail-uraian', function() {
                add_uraian_detail($(this).data('idx'))
            })

            $(document).on('keyup', '.judul-tugas', function() {
                const curr_idx = $(this).data('idx')
                $(`.tugas-label-${curr_idx}`).html($(this).val())
            })

            /*
            End Langkah Kerja Pemeriksaan Rinci JS
            */

            $('#form-rka').on('submit', function(e) {
                e.preventDefault()
                const fixInput = [
                    '_token',
                    'judul',
                    'pendahuluan',
                    'tujuan_pemeriksaan',
                    'ruang_lingkup_pemeriksaan',
                    'waktu_pelaksanaan',
                ]

                let input = $(this).serializeArray()
                input = input.filter(r => fixInput.indexOf(r.name) !== -1)

                const mappingLkp = []

                /* mapping langkah pemeriksaan rinci */
                $(".cover-langkah-kerja-pemeriksaan-rinci").find($(".br-pagebody")).map((idx, el) => {
                    // Tugas tab
                    const judulTugas = $(el).find($('.judul-tugas')).val()
                    const subJudulTugasElement = $(el).find($(".sub-judul-tugas-cover")).find($(".sub-judul-tugas"))
                    const subJudulTugas = []
                    subJudulTugasElement.map((idSjt, elSubJudulTugas) => {
                        subJudulTugas.push($(elSubJudulTugas).val())
                    })

                    // Prosedur Pemeriksaan
                    const tujuanPemeriksaan = $(el).find($('.tujuan-pemeriksaan')).val()
                    const prosedurPemeriksaan = $(el).find($('.prosedur-pemeriksaan')).val()
                    const findUraian = $(el).find($(".cover-uraian")).find($('.uraian'))
                    const uraian = []
                    findUraian.map((idU, elUr) => {
                        const idxUraian = $(elUr).data('idx')
                        const findUraianDetail = $(`.cover-uraian-detail[data-idx='${idxUraian}']`).find($('.uraian-detail'))
                        console.log(findUraianDetail)
                        const uraianDetail = []
                        findUraianDetail.map((idUd, elUd) => {
                            console.log($(elUd).val(), $(elUd).html(),'asd')
                            uraianDetail.push($(elUd).html())
                        }) 

                        uraian.push({
                            uraian: $(elUr).val(),
                            uraianDetail
                        })
                    })

                    // Pelaksana tab

                    mappingLkp.push({
                        judulTugas,
                        subJudulTugas,
                        prosedurPemeriksaan,
                        tujuanPemeriksaan,
                        uraian
                    })
                })

                console.log(mappingLkp)
            })
        })

    </script>

@endsection
