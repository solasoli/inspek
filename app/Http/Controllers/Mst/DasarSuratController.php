<?php

namespace App\Http\Controllers\Mst;

use App\Http\Controllers\Controller;
use App\Repository\Master\DasarSurat;
use Illuminate\Http\Request;
use Datatables;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;

date_default_timezone_set('Asia/Jakarta');

class DasarSuratController extends Controller
{
    public function create()
    {
      $data = DasarSurat::first();
      return view('Mst.dasar_surat-form',[
        'data' => $data
      ]);
    }

    public function store(Request $request)
    {
      $logged_user = Auth::user();
      request()->validate([
        'dasar_surat' => [
        	'required'
	      ]
      ],[
        'dasar_surat.required' => 'Dasar Surat harus diisi!'
      ]);

      $t = DasarSurat::first();
      if($t == null){
        $t = new DasarSurat;
      }
      $t->dasar_surat = $request->input("dasar_surat");
      $t->save();

      $request->session()->flash('message', "<strong>".$request->input('nama')."</strong> Berhasil disimpan!");
      return redirect('/mst/dasar_surat/');
    }
}
