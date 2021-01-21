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

    <form class="form-layout form-layout-5" id='form-review' style="padding-top:0" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type='hidden' name='step_approve' value='' id='step-approve'>
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
                                        {!! $isi !!}
                                        <hr>
                                        <h6>Review</h6>
                                        <textarea name="{{$nama_field}}" class='text-wizard' id="{{ str_replace(' ', '', $row->nama) }}" rows="10" cols="80">
                                            {{ $isi_review }}
                                        </textarea>
                                    </section>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- br-pagebody -->

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
                    {{ pka_lkp_rinci_review($data->anggota, $idxLkp, $row) }}
                    @php
                        $idxLkp++;
                    @endphp
                @endforeach
            @endif
        </div>

        <div class="card-body">
            <div class="form-group row d-flex justify-content-end">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 d-flex justify-content-start">
                    <a href='{{ url('') }}/pemeriksaan/program-kerja-audit' class="btn btn-info">Kembali</a>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 d-flex justify-content-end">
                    <button type="button" class="btn btn-info review-submit"><i class="fa fa-star"></i> Review</button>&nbsp;
                    <button type="button" class="btn btn-primary approve-submit"><i class="fa fa-check"></i> Approve</button>
                </div>
            </div>
        </div>
    </form>
    <script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
    <script src="{{ asset('admin_template/lib/ckeditor/plugin/autogrow.js') }}"></script>
    <script src="{{ asset('admin_template/lib/jquery.steps/jquery.steps.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            const localStoragePrefix = 'sasaran_tujuan-review-{{ Auth::user()->id . ' - ' . Request::segment(4) }}'
            const wizardName = 'wizard3'

            let countDownKeyupEditor

            function handlingKeyupEditor(idx, elId, txt) {
                clearTimeout(countDownKeyupEditor)
                countDownKeyupEditor = setTimeout(function() {
                    console.log(idx, $(txt).text())
                    // localStorage.setItem(`${localStoragePrefix}-${elId}`, txt);
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
            /*
            End Langkah Kerja Pemeriksaan Rinci JS
            */

            $('#form-review').on('submit', function(e) {
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
