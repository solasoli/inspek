@extends('layouts.app')
@section('content')
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
            <a class="breadcrumb-item Active" href="#">Program Kerja Pemeriksaan</a>
        </nav>
    </div>

    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Program Kerja Pemeriksaan</h4>
    </div>

    <form class="form-layout form-layout-5" id='form-rka' style="padding-top:0" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type='hidden' name='mapping_lkp' value='' id='mapping-lkp'>
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
                            <h6 class="card-title">Program Kerja Pemeriksaan</h6>
                        </div>
                        <div class="card-body">
                            <div id="wizard3">
                                
                                @php
                                $all_input = [];
                                $all_isian = $data->program_kerja_audit;
                                $review = $data->program_kerja_audit_review;
                                @endphp
                                @foreach($program_kerja_audit AS $idx => $row)
                                    <h3>{{ $row->nama }}</h3>
                                    <section>
                                        <h5>{{ $row->nama }}</h5>
                                        @php
                                            $isi = $all_isian->where('id_program_kerja_audit', $row->id)->first();
                                            $isi = $isi != null ? $isi->isi : '';

                                            
                                            $isi_review = $review->where('id_program_kerja_audit', $row->id)->first();
                                            $isi_review = $isi_review != null ? $isi_review->isi : '';
                                            
                                            
                                            $nama_field = str_replace(' ','_', strtolower(trim($row->nama))).'_rka';
                                            $all_input[] = $nama_field;
                                        @endphp

                                        @if($isi_review != '')
                                        <br>
                                        <h6 class="card-title">Review : </h6>
                                        <b>{!! $isi_review !!}</b>
                                        @endif

                                        <textarea name="{{$nama_field}}" class='text-wizard' id="{{ str_replace(' ', '', $row->nama) }}" rows="10" cols="80">
                                            {{ $isi }}
                                        </textarea>
                                    </section>
                                @endforeach
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
            @php
            $idxLkp = 1;
            $alphaProsedur = [];
            $numProsedur = [];
            @endphp
            @if($data->langkah_kerja_pemeriksaan->count() > 0) 
                @foreach($data->langkah_kerja_pemeriksaan as $idx => $row)
                    @php
                        // preparing alpha prosedur
                        $alphaProsedur[$idx + 1] = $row->prosedur != null ? $row->prosedur->count() : 0;
                        // preparing num prosedur detail
                        if($row->prosedur != null) {
                            foreach($row->prosedur as $iNpp => $rNpp) {
                                $numProsedur[($idx + 1).'-'.num2alpha($iNpp)] = $rNpp->prosedur_detail != null ? $rNpp->prosedur_detail->count() : 0; 
                            }
                        }
                    @endphp
                    {{ pka_lkp_rinci($data->anggota, $idxLkp, $row) }}
                    @php
                        $idxLkp++;
                    @endphp
                @endforeach
            @endif
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
                            if (idx == 0) {
                            }

                            const html = e.editor.getData()
                            bgStepChange(idx, $(html).text())
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

            /*
            Langkah Kerja Pemeriksaan Rinci JS
            */
            let idx_pemeriksaan_rinci = {{ $idxLkp }}
            const alpha_prosedur = []
            @foreach($alphaProsedur as $iAp => $rAp)
                alpha_prosedur[{{$iAp}}] = {{$rAp}};
            @endforeach
            const num_prosedur = []
            @foreach($numProsedur as $iNpr => $rNpr)
                num_prosedur['{{$iNpr}}'] = {{$rNpr}};
            @endforeach

            add_langkah_kerja_pemeriksaan_rinci()
            
            function add_sub_judul_tugas(subJudulTugasEl, value) {
                if (typeof subJudulTugasEl != 'undefined') {
                    value = typeof value != 'undefined' ? value.trim() : '' 
                    let template_sub_judul_tugas = `
                    {{ pka_sub_judul_tugas() }}
                    `
                    template_sub_judul_tugas = template_sub_judul_tugas.replace('[value]', value)

                    $(subJudulTugasEl).append(template_sub_judul_tugas)
                } else {
                    console.log("CANNOT FIND SUB JUDUL TUGAS ELEMENT")
                }
            }

            function add_langkah_kerja_pemeriksaan_rinci() {
                let template_lkpr = `
                {{ pka_lkp_rinci($data->anggota) }}
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

            function confirmProsedur(){
                return confirm('Detail Prosedur akan ikut terhapus. Lanjutkan?')
            }
            
            function confirmLki(){
                return confirm('Data Langkah Kerja Pemeriksaan akan terhapus. Lanjutkan?')
            }

            $(document).on('click', '.btn-delete-lki', function() {

                const confirm = confirmLki()
                if(confirm) {
                    $(this).parent().closest($(".lkp-rinci")).remove()
                }
            })

            $(document).on('click', '.remove-prosedur', function() {
                const idx = $(this).data('idx');
                const coverDetailElement = $(`.cover-prosedur-detail[data-idx='${idx}']`)
                const countElement = coverDetailElement.find($('.row')).length
                if(countElement > 0) {
                    const confirm = confirmProsedur()
                    console.log(confirm)
                    if(confirm) {
                        coverDetailElement.parent().closest($(".row")).remove();
                        $(this).parent().closest($(".row")).remove();
                    }
                } else {
                    $(this).parent().closest($(".row")).remove();
                    coverDetailElement.parent().closest($(".row")).remove();
                }

                // remove pelaksana 
                $(`.pelaksana-row[data-idx=${idx}]`).remove();
            })

            $(document).on('blur', '.prosedur', function() {
                var data = $(this).data('idx')
                $(`.prosedur-label-${data}`).html($(this).val())
            })
            
            $(document).on('blur', '.prosedur-detail', function() {
                var data = $(this).data('idx')
                console.log(data)
                $(`.prosedur-detail-list[data-idx='${data}']`).html($(this).val())
            })

            function add_prosedur(idx_pemeriksaan_rinci, idx_prosedur) {
                console.log(idx_prosedur, 'prosedur');
                if (idx_prosedur) {
                    alpha_prosedur[idx_prosedur] = alpha_prosedur[idx_prosedur] != null ? alpha_prosedur[idx_prosedur] + 1 : 1
                    const prosedur_cover = $(`.cover-prosedur[data-idx='${idx_prosedur}']`)
                    prosedur_cover.find($(".no-available-prosedur")).remove()

                    // remove notice
                    $(`#pelaksana-tab-${idx_prosedur}`).find($(".no-available-prosedur")).remove()

                    console.log(prosedur_cover);
                    let template_prosedur = `
                    {{ pka_lkp_rinci_prosedur() }}
                    `
                    console.log(alpha_prosedur[idx_prosedur]);
                    const alphabet = numToSSColumn(alpha_prosedur[idx_prosedur])
                    template_prosedur = template_prosedur.replace(/\[idx_prosedur]/gm, idx_pemeriksaan_rinci)
                    template_prosedur = template_prosedur.replace(/\[alpha_prosedur]/gm, alphabet)
                    prosedur_cover.append(template_prosedur)

                    // adding pelaksana
                    let template_pelaksana = `
                    {{ pka_lkp_pelaksana($data->anggota) }}
                    `
                    template_pelaksana = template_pelaksana.replace(/\[idx_prosedur]/gm, idx_pemeriksaan_rinci)
                    template_pelaksana = template_pelaksana.replace(/\[alpha_prosedur]/gm, alphabet)
                    $(`#pelaksana-tab-${idx_prosedur}`).append(template_pelaksana)

                } else {
                    console.log('FAILED TO GENERATE IDX prosedur')
                }
            }

            function add_prosedur_detail(idx_prosedur) {
                console.log(idx_prosedur)
                if (idx_prosedur != '') {
                    num_prosedur[idx_prosedur] = num_prosedur[idx_prosedur] != null ? num_prosedur[idx_prosedur] + 1 : 1
                    const prosedur_cover = $(`.cover-prosedur-detail[data-idx='${idx_prosedur}']`)
                    prosedur_cover.find($(".no-available-prosedur")).remove()
                    let template_prosedur_detail = `
                    {{ pka_lkp_rinci_prosedur_detail() }}
                    `

                    const alphabet = numToSSColumn(num_prosedur[idx_prosedur])
                    template_prosedur_detail = template_prosedur_detail.replace(/\[num_prosedur]/gm, num_prosedur[idx_prosedur])
                    template_prosedur_detail = template_prosedur_detail.replace(/\[idx_prosedur]/gm, idx_prosedur)
                    prosedur_cover.append(template_prosedur_detail)
                    
                    // adding list
                    $(`.list-prosedur-detail[data-idx='${idx_prosedur}']`).append(`<li class='prosedur-detail-list' data-idx='${idx_prosedur}-${num_prosedur[idx_prosedur]}'></li>`)
                } else {
                    console.log('FAILED TO GENERATE IDX prosedur')
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

            $(document).on('click', '.btn-prosedur', function() {
                const lkpElement = $(this).parent().closest($(".lkp-rinci"))
                add_prosedur(lkpElement.data('idx'), $(this).data('idx'))
            })

            $(document).on('click', '.btn-detail-prosedur', function() {
                add_prosedur_detail($(this).data('idx'))
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
                    '{!! implode("','",$all_input) !!}'
                ]

                console.log(fixInput)

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
                    const findprosedur = $(el).find($(".cover-prosedur")).find($('.prosedur'))
                    const prosedur = []
                    findprosedur.map((idU, elUr) => {
                        const idxprosedur = $(elUr).data('idx')
                        const findprosedurDetail = $(`.cover-prosedur-detail[data-idx='${idxprosedur}']`).find($('.prosedur-detail'))
                        const prosedurDetail = []
                        findprosedurDetail.map((idUd, elUd) => {
                            prosedurDetail.push({ idProsedurDetail: $(elUd).data('id'), prosedurDetail: $(elUd).val()})
                        }) 

                        const pelaksanaRow = $(`.pelaksana-row[data-idx='${idxprosedur}']`)
                        console.log(idxprosedur)
                        console.log(pelaksanaRow.html())
                        // Pelaksana tab
                        const rencana = {
                            pelaksana: $(pelaksanaRow).find($('.pelaksana-rencana')).val(),
                            durasi: $(pelaksanaRow).find($(".durasi-rencana")).val()
                        }

                        const realisasi = {
                            pelaksana: $(pelaksanaRow).find($('.pelaksana-realisasi')).val(),
                            durasi: $(pelaksanaRow).find($(".durasi-realisasi")).val()
                        }

                        prosedur.push({
                            idProsedur: $(elUr).data('id'),
                            prosedur: $(elUr).val(),
                            prosedurDetail,
                            pelaksana: {
                                rencana,
                                realisasi
                            }
                        })
                    })


                    mappingLkp.push({
                        idLkp: $(el).data('id'),
                        judulTugas,
                        subJudulTugas,
                        tujuanPemeriksaan,
                        prosedur,
                    })
                })

                $('#mapping-lkp').val(JSON.stringify(mappingLkp))

                console.log(mappingLkp);
                $(this).unbind('submit').submit();
            })
        })

    </script>

@endsection
