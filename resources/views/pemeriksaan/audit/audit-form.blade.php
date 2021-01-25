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
            <a class="breadcrumb-item Active" href="#">Pemeriksaan</a>
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
                        <form action="/pemeriksaan/audit/upload_bukti_kertas_kerja/{{Request::segment(4)}}" class="dropzone" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="fallback">
                            <input name="file" type="file" multiple />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="br-pagebody">
        <div class="row">
            <div class="col-lg-12 widget-2 px-0">
                <div class="card shadow-base">

                    <div class="card-header alert-success">
                        <h6 class="card-title">Berkas Pemeriksaan</h6>
                    </div>
                    <div class="card-body">
                        <ol class='file-upload-res'>
                        @if(isset($data))
                            @foreach($data->audit_berkas as $idx => $row)
                                <li>
                                    <a href='{{ URL::to('upload_file/'.$row->file_url) }}' style='margin-right: 20px'>{{ $row->file_url }}</a>
                                    <a href='#' class="btn btn-danger btn-xs btn-remove-file" data-id='{{ $row->id }}'><i class="fa fa-close"></i></a> 
                                </li>
                            @endforeach
                        @endif
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form class="form-layout form-layout-5" id='form-audit' style="padding-top:0" method="post" enctype="multipart/form-data">
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
                            <h6 class="card-title">Uraian Singkat</h6>
                        </div>
                        <div class="card-body">
                            <textarea name="uraian_singkat" class='text-wizard' id="uraian_singkat" rows="10" cols="80">
                                {{ $data->uraian_singkat }}
                            </textarea>
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
            @php
            $idx_kki = 1;
            $kki = $data->kertas_kerja_ikhtisar;   
            @endphp
            @if($kki->count() > 0)
                @foreach($kki as $idx => $row)
                    {{ adt_kertas_kerja_ikhtisar($idx +1, $row) }}

                    @php
                     $idx_kki++;   
                    @endphp
                @endforeach

            @endif
        </div>

        <div class="card-body">
            <div class="form-group row d-flex justify-content-end">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    @if($data->surat_perintah != null)
                        <a href='{{ url('') }}/pemeriksaan/audit/review_list/{{$data->surat_perintah->id}}' class="btn btn-danger"
                            type="button">Cancel</a>
                    @else
                        <a href='{{ url('') }}/pemeriksaan/audit' class="btn btn-danger"
                            type="button">Cancel</a>

                    @endif 
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
                success: function(res){
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
                                        console.log( $(`#${idEl}`).val())
                                        // handlingKeyupEditor(idx, idEl, e.editor.getData())
                                    },
                                    blur: function(e) {
                                        $(`#${idEl}`).val(e.editor.getData())
                                        // handlingKeyupEditor(idx, idEl, e.editor.getData())
                                    }
                                }
                            });
    
                            const kodeTemuanCoverHeight = typeof parentDiv.find($(".kode_temuan_cover")) != 'undefined' ? parentDiv.find($(".kode_temuan_cover")).height() : 0;
                            /* editor.setData(localStorage.getItem(
                                `${localStoragePrefix}-${idEl}`))*/
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

            function trigger_kki(idx_kki) {
                console.log(idx_kki,'idx_kki');
                generateTextWizard(`wizard${idx_kki}`)

                // code temuan
                $(".cover-kertas-kerja-ikhtisar .kertas-kerja-ikhtisar").last().find($(".kode_temuan[data-level='1']"))
                .map(function(elKt) {
                    changeKodeTemuan($(this))
                })
            }

            function add_kertas_kerja_ikhtisar() {
                console.log(idx_kki)
                let template_kki = `
                {{ adt_kertas_kerja_ikhtisar() }}
                `
                template_kki = template_kki.replace(/\[idx]/gm, idx_kki)

                $('.cover-kertas-kerja-ikhtisar').append(template_kki)
                trigger_kki(idx_kki);
                
                idx_kki++;
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
            
            function confirmKki(){
                return confirm('Data KertasKKerja Ikhtisar akan terhapus. Lanjutkan?')
            }

            $(document).on('click', '.btn-delete-kki', function() {

                const confirm = confirmKki()
                if(confirm) {
                    $(this).parent().closest($(".kertas-kerja-ikhtisar")).remove()
                }
            })

            add_kertas_kerja_ikhtisar()
            $(document).on('click', '.add-kertas-kerja-ikhtisar', function() {
                add_kertas_kerja_ikhtisar()
            })

            $(document).on('change', '.kode_temuan', function(){
                changeKodeTemuan($(this))
            })

            // first element render kode temuan
            $(".kode_temuan[data-level=1]").map(function(el) {
                changeKodeTemuan($(el))
            })

            async function changeKodeTemuan(el) {
                const currentLevel = $(el).data('level');
                console.log(currentLevel,'current level');
                const nextLevel = currentLevel + 1;

                if(nextLevel <= 3) {
                    const nextElement = $(el).parent().closest($(".kode_temuan_cover")).find($(`.kode_temuan[data-level=${nextLevel}]`))
                    nextElement.html(`<option value=''>- Pilih Kode Temuan -</option>`)
                    const option = [];

                    /* check last update 
                    let getKodeTemuanFlag = false;
                    await $.post('/mst/kode_temuan/check_last_update', function(res) {
                        if(kode_temuan_last_update != res.last_update) {
                            getKodeTemuanFlag = true;
                            kode_temuan_last_update = res.last_update;
                        }
                    }) */

                    // find option 
                    let baseOption = baseOptionKodeTemuan.find(r=> r.id_parent == $(el).val())
                    if(typeof baseOption == 'undefined') {
                        await $.post('/mst/kode_temuan/get_kode_temuan_by_level', { level: nextLevel, parent: $(el).val() }, function(res) {
                            
                            const temuan = {
                                id_parent: $(el).val(),
                                options: []
                            }
                            res.data.map(function (dt) {
                                temuan.options.push(`<option value='${dt.id}'>${dt.kode}. ${dt.temuan}</option>`);
                            })
                            baseOptionKodeTemuan.push(temuan)
                            baseOption = temuan
                            console.log(baseOption, temuan,'koplik')
                        })
                    }

                    option.push(baseOption.options)
                    nextElement.append(option.join(''))

                    const value = $(nextElement).data('value');
                    if(value > 0) {
                        nextElement.val(value).trigger('change');
                    }

                }
            }

            function confirmRemoveBerkas() {
                return confirm("Apakah anda yakin untuk menghapus berkas ini ?")
            }

            $(document).on('click', ".btn-remove-file" , function() {
                const confirm = confirmRemoveBerkas()
                if(confirm) {
                    $.get(`{{ URL::to("/pemeriksaan/audit/remove_audit_berkas/") }}/${$(this).data('id')}`)
                    $(this).parent().remove()
                }
            })

            
            $('#form-audit').on('submit', function(e) {
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
                    const judul_kondisi_el = $(el).find($(`#judul_kondisi_${tagIdx}`))
                    console.log(judul_kondisi_el.val())
                    const judul_kondisi = {
                        judul_kondisi: judul_kondisi_el.val(),
                        kode_temuan: [
                            {
                                level: 1,
                                id_kode_temuan: judul_kondisi_el.parent().find($(".kode_temuan[data-level=1]")).val()
                            },
                            {
                                level: 2,
                                id_kode_temuan: judul_kondisi_el.parent().find($(".kode_temuan[data-level=2]")).val() 
                            },
                            {
                                level: 3,
                                id_kode_temuan: judul_kondisi_el.parent().find($(".kode_temuan[data-level=3]")).val()
                            }
                        ]
                    }

                    // uraian kondisi
                    const uraian_kondisi_el = $(el).find($("textarea[name='uraian_kondisi']"))
                    const uraian_kondisi = {
                        uraian_kondisi: uraian_kondisi_el.val(),
                        kode_temuan: [
                            {
                                level: 1,
                                id_kode_temuan: uraian_kondisi_el.parent().find($(".kode_temuan[data-level=1]")).val()
                            },
                            {
                                level: 2,
                                id_kode_temuan: uraian_kondisi_el.parent().find($(".kode_temuan[data-level=2]")).val() 
                            },
                            {
                                level: 3,
                                id_kode_temuan: uraian_kondisi_el.parent().find($(".kode_temuan[data-level=3]")).val()
                            }
                        ]
                    }

                    // kriteria
                    const kriteria = $(el).find($("textarea[name='kriteria']")).val()

                    // sebab
                    const sebab = $(el).find($("textarea[name='sebab']")).val()

                    // akibat
                    const akibat = $(el).find($("textarea[name='akibat']")).val()

                    // rekomendasi
                    const rekomendasi_el = $(el).find($("textarea[name='rekomendasi']"))
                    const rekomendasi = {
                        rekomendasi: rekomendasi_el.val(),
                        kode_rekomendasi: [
                            {
                                level: 1,
                                id_kode_rekomendasi: rekomendasi_el.parent().find($(".kode_rekomendasi[data-level=1]")).val()
                            },
                            {
                                level: 2,
                                id_kode_rekomendasi: rekomendasi_el.parent().find($(".kode_rekomendasi[data-level=2]")).val() 
                            }
                        ]
                    }

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

                console.log(mappingKki)
                $('#mapping-kki').val(JSON.stringify(mappingKki))

                $(this).unbind('submit').submit();
            })
        })

    </script>

@endsection
