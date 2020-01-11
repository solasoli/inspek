<?php

namespace App\Http\Controllers\ACL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use App\Menu;

date_default_timezone_set('Asia/Jakarta');

class MenuController extends Controller
{
    public function index()
    {
      return view('acl.menu-list');
    }

    public function create()
    {
      return view('acl.menu-form');
    }

    public function store(Request $request)
    {
      $logged_user = Auth::user();
      request()->validate([
        'nama' => [
          'required',
          Rule::unique('acl_menu', 'nama')->where(function ($query){
            return $query->where('is_deleted', 0);
          })
        ],
        'url' => 'required'
      ],[
        'nama.required' => 'Nama menu harus diisi!',
        'url.required' => 'url menu harus diisi!',
        'nama.unique' => 'Menu sudah ada!'
      ]);

      $t = new Menu;
      $t->nama = $request->input('nama');
      $t->slug = str_replace(" ", "-", strtolower($request->input('nama')));
      $t->url = $request->input('url');
      $t->created_at = date('Y-m-d H:i:s');
      $t->created_by = Auth::id();
      $t->updated_at = NULL;
      $t->updated_by = 0;
      $t->deleted_at = NULL;
      $t->deleted_by = 0;
      $t->is_deleted = 0;
      $t->save();

      $request->session()->flash('success', "Data berhasil disimpan.");
      return redirect('/acl/menu');
    }

    public function edit($id)
    {
      $data = Menu::findOrFail($id);

      return view('acl.menu-form', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
      $logged_user = Auth::user();
      request()->validate([
        'nama' => [
          'required',
          'unique:acl_menu,nama,'.$id
        ],
        'url' => 'required'
      ],[
        'nama.required' => 'Nama menu harus diisi!',
        'url.required' => 'url menu harus diisi!',
        'nama.unique' => 'Menu sudah ada!'
      ]);

      $t = Menu::findOrFail($id);
      $t->nama = $request->input('nama');
      $t->slug = str_replace(" ", "-", strtolower($request->input('nama')));
      $t->url = $request->input('url');
      $t->updated_at = date('Y-m-d H:i:s');
      $t->updated_by = Auth::id();
      $t->save();

      $request->session()->flash('success', "Data berhasil diubah.");
      return redirect("/acl/menu/edit/{$id}");
    }

    public function destroy(Request $request, $id)
    {
      $logged_user = Auth::user();
      $t = Menu::findOrFail($id);
      $t->deleted_at = date('Y-m-d H:i:s');
      $t->deleted_by = Auth::id();
      $t->is_deleted = 1;
      $t->save();

      $request->session()->flash('success', "Data berhasil dihapus!");
      return redirect('/acl/menu');
    }

    public function list_datatables_api()
    {
      $data = Menu::where('is_deleted', 0)->orderBy('nama', 'ASC')->get();
      return Datatables::of($data)->make(true);
    }
}
