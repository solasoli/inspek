@extends('layouts.app')
@section('content')


<style type="text/css">
        @media print {
            body * {
                visibility: hidden;
            }

            #print_here,
            #print_here * {
                visibility: visible;
            }

            #print_here {
                position: absolute;
                top: 0;
            }

            .no-print {
                padding: 0 !important;
                margin: 0 !important;
                height: 0 !important;
            }

            .br-mainpanel {
                margin-top: 0 !important;
            }
        }
        table, td, th {
		padding: 5px;
		font-family: calibri;
	    }
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
        }
        th {
            height: 50px;
        }
        
        .pd1{
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }
        .agcenter{
            text-align: center;
        }
       
    </style>

<div class="br-pageheader pd-y-15 pd-l-20">
  <nav class="breadcrumb pd-0 mg-0 tx-12">
    <a class="breadcrumb-item" href="/">Dashboard</a>
    <a class="breadcrumb-item" href="/">Master</a>
    <a class="breadcrumb-item Active" href="#">Surat Perintah PKPT</a>
  </nav>
</div>

<div class="pd-x-20 pd-sm-x-30 pd-t-20 pd-sm-t-30">
  <h4 class="tx-gray-800 mg-b-5">{{ isset($data) ? "Edit" : "Tambah" }} Surat Perintah PKPT</h4>
</div>

<form class="form-layout form-layout-5" id="form-sp" style="padding-top:0" method="post" enctype="multipart/form-data">
  {{ csrf_field() }}
  <input type='hidden' name='mapping_tim' value='' id='mapping-tim'>
  <div class="br-pagebody">
    @if(Session::has('error'))
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
    @if(Session::has('success'))
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

          @include('pkpt.partial.surat_perintah_base')
          
          <div class='cover-tim'>
            @if(isset($data->id)) 
            
              @foreach($data->tim as $idTm => $tm)
                {{ sp_tim($list_inspektur, false, $idTm + 1, $tm, $data->anggota_tim->where('id_surat_perintah_tim', $tm->id)) }}
              @endforeach
            @endif
          </div>
          <hr>
          
          <div class="card-header"></div>
          <div class="card-body">
            <div class="form-group row d-flex justify-content-center">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">      
                <a href='{{url('')}}/pkpt/surat_perintah' class="btn btn-danger" type="button">Cancel</a>
                <a class="preview btn btn-info text-white" data-toggle="modal" data-target="#exampleModal">Preview</a>
                <button type="submit" class="btn btn-primary" >Submit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" id="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Preview Surat Perintah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid px-5">
          <div class="kop"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal lampiran-->
<div class="modal fade" id="modalLampiran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> 
    <div class="modal-content" style="width:120%">
      <!-- Modal Header -->
      <div class="modal-header" style="background:#e9ecef">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> 
      <!-- Modal body --> 
        <div class="kop_lampiran"></div>
      <div class="modal-footer" style="background:#e9ecef">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@include('pkpt.partial.surat_perintah_js')
@endsection
