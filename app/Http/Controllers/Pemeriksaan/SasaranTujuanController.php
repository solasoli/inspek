<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

use App\Service\SuratPerintah\SuratPerintahService;
use App\Service\Pemeriksaan\PenentuanSasaranTujuanService;

use App\Repository\Master\SasaranTujuan;
use App\Repository\SuratPerintah\SuratPerintah;
use App\Repository\Pemeriksaan\PenentuanSasaranTujuan;

use Datatables;

class SasaranTujuanController extends Controller
{
  public function index()
  {
    return view('/pemeriksaan/sasaran-tujuan/sasaran_tujuan-list');
  }

  public function edit($id)
  {
    $sp = SuratPerintah::findOrFail($id);
    $sasaran_tujuan = SasaranTujuan::all();

    return view('/pemeriksaan/sasaran-tujuan/sasaran_tujuan-form', [
      'data' => $sp,
      'sasaran_tujuan' => $sasaran_tujuan
    ]);
  }

  public function update(Request $request, $id)
  {
    PenentuanSasaranTujuanService::createOrUpdate($id, $request->input());
    $request->session()->flash('success', "Data berhasil disimpan!");
    return redirect("/pemeriksaan/sasaran-tujuan/edit/".$id);
  }

  public function detail($id)
  {
    $sp = SuratPerintah::findOrFail($id);
    $sasaran_tujuan = SasaranTujuan::all();

    return view('/pemeriksaan/sasaran-tujuan/sasaran_tujuan-detail', [
      'id' => $id,
      'data' => $sp,
      'sasaran_tujuan' => $sasaran_tujuan
    ]);
  }

  public function list_datatables_api()
  {
    $data = SuratPerintahService::get_valid_sp(true)
    ->with((['wilayah', 'kegiatan']));
    return Datatables::eloquent($data)->toJson();
  }
}