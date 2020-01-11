<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use App\Config;
use App\ConfigDetail;

date_default_timezone_set('Asia/Jakarta');

class ConfigController extends Controller
{
    public function index()
    {
      return view('dev.config-list');
    }

    public function create()
    {
      return view('dev.config-form');
    }

    public function store(Request $request)
    {
      $logged_user = Auth::user();
      $validator = Validator::make($request->all(), [
        'nama' => 'required',
        'kode' => 'required',
        'label.*' => 'required',
        'column_in_db.*' => 'required',
      ],[
        'nama.required' => 'Nama harus diisi!',
        'kode.required' => 'Kode harus diisi!',
      ]);
      if($validator->fails()){

        return back()
              ->withErrors($validator)
              ->withInput();
      }

      DB::transaction(function () use ($request) {
        $t = new Config;
        $t->nama = $request->input('nama');
        $t->kode = $request->input('kode');
        $t->save();

        foreach ($request->input('label') AS $idx => $val) {
          $t2 = new ConfigDetail;
          $t2->label = $val;
          $t2->column_in_db = $request->input('column_in_db')[$idx];
          $t2->id_config = $t->id;
          $t2->save();
        }
      });

      $request->session()->flash('success', "Data berhasil disimpan.");
      return redirect('/dev/config');
    }

    public function edit($id)
    {
      $data = Config::findOrFail($id);
      $data_detail = ConfigDetail::where('is_deleted', 0)
      ->where('id_config', $id)
      ->orderBy('id', 'ASC')
      ->get();

      return view('dev.config-form', [
        'data' => $data,
        'data_detail' => $data_detail
      ]);
    }

    public function update(Request $request, $id)
    {
      $logged_user = Auth::user();
      $validator = Validator::make($request->all(), [
        'nama' => 'required',
        'kode' => 'required',
        'label.*' => 'required',
        'column_in_db.*' => 'required',
      ],[
        'nama.required' => 'Nama harus diisi!',
        'kode.required' => 'Kode harus diisi!',
      ]);
      if($validator->fails()){

        return back()
              ->withErrors($validator)
              ->withInput();
      }

      DB::transaction(function () use ($request, $id) {
        $t = Config::findOrFail($id);
        $t->nama = $request->input('nama');
        $t->kode = $request->input('kode');
        $t->save();

        ConfigDetail::where('id_config', $id)
            ->update(['is_deleted' => 1]);

        foreach ($request->input('label') AS $idx => $val) {
          $t2 = new ConfigDetail;
          $t2->label = $val;
          $t2->column_in_db = $request->input('column_in_db')[$idx];
          $t2->id_config = $t->id;
          $t2->save();
        }
      });

      $request->session()->flash('success', "Data berhasil diubah.");
      return redirect("/dev/config/edit/{$id}");
    }

    public function destroy(Request $request, $id)
    {
      $logged_user = Auth::user();

      DB::transaction(function () use ($request, $id) {
        $t = Config::findOrFail($id);
        $t->is_deleted = 1;
        $t->save();

        ConfigDetail::where('id_config', $id)
            ->update(['is_deleted' => 1]);
      });

      $request->session()->flash('success', "Data berhasil dihapus.");
      return redirect('/dev/config');
    }

    public function list_datatables_api()
    {
      $data = Config::where('is_deleted', 0)->orderBy('id', 'ASC')->get();
      return Datatables::of($data)->make(true);
    }
}
