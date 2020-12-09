@extends('layouts.app')
@section('content')
    <link href="{{ asset('admin_template/lib/dropzone/min/dropzone.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_template/lib/jquery.steps/jquery.steps.css') }}" rel="stylesheet">

    <style>
        .bg-cyan {
            background-color: #e9ecef;
        }
    </style>
    <div class="br-pageheader pd-y-15 pd-l-20">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="/">Dashboard</a>
            <a class="breadcrumb-item" href="/">Tindak Lanjut</a>
            <a class="breadcrumb-item Active" href="#">Matrik</a>
        </nav>
    </div>

    <div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
        <h4 class="tx-gray-800 mg-b-5">Tindak Lanjut</h4>
    </div>

    <form class="form-layout form-layout-5" id='form-audit' style="padding-top:0" method="post"
        enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type='hidden' name='mapping_kki' value='' id='mapping-kki'>
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
                            <h6 class="card-title">Tindak Lanjut</h6>
                        </div>
                        <div class="card-body">
                            <table border="1" class="table">
                                <tbody>
                                    <tr class="bg-cyan">
                                        <td class="pd1" rowspan="2">No</td>
                                        <td class="pd1" rowspan="2">Temuan<br>(Uraian Singkat)</td>
                                        <td class="pd1" rowspan="2">Kode Temuan</td>
                                        <td class="pd1" rowspan="2">Rekomendasi<br>(Uraian Singkat)</td>
                                        <td class="pd1" rowspan="2">Kode Rekomendasi</td>
                                        <td class="pd1" rowspan="2">Tindak Lanjut<br>(Uraian Singkat)</td>
                                        <td class="pd1" colspan="3">Keterangan</td>
                                        <td class="pd1" rowspan="2">Paraf {{ $data->program_kerja->skpd->name }}</td>
                                        <td class="pd1" rowspan="2">Ket</td>
                                    </tr>
                                    <tr class="bg-cyan">
                                        <td class="agcenter">S</td>
                                        <td class="agcenter">D</td>
                                        <td class="agcenter">B</td>
                                    </tr>
                                    @php 
                                    $no = 1;
                                    @endphp
                                    @foreach($data->audit_kertas_kerja as $row)
                                        @foreach($row->kertas_kerja_ikhtisar->where('is_compilation', 1) as $rw)
                                            @php
                                            $kode_rekom_1 = $rw->kode_rekomendasi->where('level',1)->first();
                                            $kode_rekom_2 = $rw->kode_rekomendasi->where('level',2)->first();
                                            
                                            if($kode_rekom_1 != null) {
                                                $kode_rekom_1 = $kode_rekom_1->kode_rekomendasi->kode;
                                            } else {
                                                $kode_rekom_1 = '-';
                                            }
                                            
                                            if($kode_rekom_2 != null) {
                                                $kode_rekom_2 = $kode_rekom_2->kode_rekomendasi->kode;
                                            } else {
                                                $kode_rekom_2 = '-';
                                            }

                                            $kode_judul_1 = $rw->kode_temuan->where('level',1)->first();
                                            $kode_judul_2 = $rw->kode_temuan->where('level',2)->first();
                                            $kode_judul_3 = $rw->kode_temuan->where('level',3)->first();
                                            
                                            if($kode_judul_1 != null) {
                                                $kode_judul_1 = $kode_judul_1->kode_temuan->kode;
                                            } else {
                                                $kode_judul_1 = '-';
                                            }
                                            
                                            if($kode_judul_2 != null) {
                                                $kode_judul_2 = $kode_judul_2->kode_temuan->kode;
                                            } else {
                                                $kode_judul_2 = '-';
                                            }
                                            
                                            if($kode_judul_3 != null) {
                                                $kode_judul_3 = $kode_judul_3->kode_temuan->kode;
                                            } else {
                                                $kode_judul_3 = '-';
                                            }

                                            $kode_rekomendasi = $kode_rekom_1.'.'.$kode_rekom_2;
                                            $kode_judul = $kode_judul_1.'.'.$kode_judul_2.'.'.$kode_judul_3;

                                            $tindak_lanjut = !is_null($rw->tindak_lanjut) ? $rw->tindak_lanjut : null;
                                            @endphp

                                            <tr>
                                                <td class="agcenter">{{$no}}</td>
                                                <td>{!! $rw->judul_kondisi !!}</td>
                                                <td>{{ $kode_judul }}</td>
                                                <td>{!! $rw->rekomendasi !!}</td>
                                                <td>{{ $kode_rekomendasi }}</td>
                                                <td style="padding: 0"><textarea name='tindak_lanjut_{{$rw->id}}' style="height: 100%;
                                                    box-sizing: border-box;" class='form-control' placeholder="Isi Tindak Lanjut Disini">
                                                    {{ !is_null($tindak_lanjut) ? $tindak_lanjut->tindak_lanjut  : '' }}
                                                </textarea></td>
                                                <td><input type="checkbox" name="s_{{$rw->id}}" value='1' {{ !is_null($tindak_lanjut) && $tindak_lanjut->s ? 'checked' : '' }}></td>
                                                <td><input type="checkbox" name="d_{{$rw->id}}" value='1' {{ !is_null($tindak_lanjut) && $tindak_lanjut->d ? 'checked' : '' }}></td>
                                                <td><input type="checkbox" name="b_{{$rw->id}}" value='1' {{ !is_null($tindak_lanjut) && $tindak_lanjut->b ? 'checked' : '' }}></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            @php
                                            $no++;
                                            @endphp
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                            @if(!is_null($data->tindak_lanjut_review)) 
                            <hr>
                            <div>
                                <b><h6>Review</h6></b>
                                    {!! $data->tindak_lanjut_review->review !!}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- br-pagebody -->


        <div class="card-body">
            <div class="form-group row d-flex justify-content-end">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href='{{ url('') }}/tindak_lanjut/matrik' class="btn btn-danger" type="button">Cancel</a>
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
        $(function() {
            const localStoragePrefix = 'audit-{{ Auth::user()->id . ' - ' . Request::segment(4) }}'

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

            $(".dropzone").dropzone({
                success: function(res) {
                    const resJson = JSON.parse(res.xhr.response)
                    $(".file-upload-res").append(`<li>
                            <a href='${resJson.file_url}' style='margin-right: 20px'>${resJson.file_name}</a>
                            <a href='#' class="btn btn-danger btn-xs btn-remove-file" data-id='${resJson.id}'><i class="fa fa-close"></i></a> 
                        </li>`)
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
                            console.log(parentDiv)
                            const editor = CKEDITOR.replace($(this).attr('id'), {
                                extraPlugins: 'autogrow',
                                on: {
                                    change: function(e) {
                                        console.log(e.editor.getData())
                                        $(`#${idEl}`).val(e.editor.getData())
                                        console.log($(`#${idEl}`).val())
                                        // handlingKeyupEditor(idx, idEl, e.editor.getData())
                                    },
                                    blur: function(e) {
                                        $(`#${idEl}`).val(e.editor.getData())
                                        // handlingKeyupEditor(idx, idEl, e.editor.getData())
                                    }
                                }
                            });

                            const kodeTemuanCoverHeight = typeof parentDiv.find($(
                                ".kode_temuan_cover")) != 'undefined' ? parentDiv.find($(
                                ".kode_temuan_cover")).height() : 0;
                            editor.setData(localStorage.getItem(
                                `${localStoragePrefix}-${idEl}`))
                            editor.on('instanceReady', function(e) {
                                if (idx == 0) {}

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

                        $(`#${wizardName}`).find($(".content")).height(content.height() +
                            plusHeightWizard)
                    }
                });
            }
        })

    </script>

@endsection
