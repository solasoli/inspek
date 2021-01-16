@extends('layouts.app')
@section('content')
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
            <div class="form-group row">
                <label class="form-control-label col-md-3 col-sm-3 col-xs-12">
    
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Anggota</th>
                                <th style="width:60px"></th>
                            </tr>
                            
                        </thead>
                        <tbody id='cover-anggota'>
                            @if (!is_null(old('anggota')))
                                @foreach (old('anggota') as $i => $r)
                                    <tr>
                                        <td>
                                            <select name='anggota[]' class="form-control select2 anggota">
                                                @foreach ($pegawai as $idx => $row)
                                                    @php
                                                    $selected = $row->id == $r ? "selected" : "";
                                                    @endphp
                                                    <option value='{{ $row->id }}' {{ $selected }}>{{ $row->nama }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @elseif(isset($data->id))
                                @php
                                    $idxA = 0;
                                @endphp
                                @foreach ($anggota as $idx => $row)
                                <tr>
                                    <td>
                                        <select name='anggota[]' class="form-control select2 anggota" data-selected='{{ $row->id_anggota }}'>
                                            [option_anggota]
                                        </select>
                                    </td>
                                    <td>
                                        @if($idxA > 0)
                                        <button type='button' class='btn btn-danger btn-xs delete-anggota'><i class='fa fa-close'></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @php 
                                    $idxA++;
                                @endphp
                                @endforeach
                            @else
                                <tr>
                                    <td>
                                        <select name='anggota[]' class="form-control select2 anggota">
                                            [option_anggota]
                                        </select>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tr>
                            <td colspan="2">
                                <button type="button" class="btn btn-info add-anggota"> Tambah Anggota</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
          </div>
          <hr>
          
          <div class="card-header"></div>
          <div class="card-body">
            <div class="form-group row d-flex justify-content-center">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">      
                <a href='{{url('')}}/pkpt/surat_perintah' class="btn btn-danger" type="button">Cancel</a>
                <a href="#" class="preview btn btn-info" data-toggle="modal" data-target="#exampleModal">Preview</a>
                <button type="submit" class="btn btn-primary" >Submit</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<style>

</style>

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
        <button class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>

@include('pkpt.partial.surat_perintah_js_non_tim')
@endsection
