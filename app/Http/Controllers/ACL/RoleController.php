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
use App\Role;

date_default_timezone_set('Asia/Jakarta');

class RoleController extends Controller
{
    public function index()
    {
      return view('acl.role-list');
    }

    public function create()
    {
      return view('acl.role-form');
    }

    public function store(Request $request)
    {
      $logged_user = Auth::user();
      request()->validate([
        'nama' => [
          'required',
          Rule::unique('acl_role', 'nama')->where(function ($query){
            return $query->where('is_deleted', 0);
          })
        ]
      ],[
        'nama.required' => 'Nama role harus diisi!',
        'nama.unique' => 'Role sudah ada!'
      ]);

      $t = new Role;
      $t->nama = $request->input('nama');
      $t->created_at = date('Y-m-d H:i:s');
      $t->created_by = Auth::id();
      $t->updated_at = NULL;
      $t->updated_by = 0;
      $t->deleted_at = NULL;
      $t->deleted_by = 0;
      $t->is_deleted = 0;
      $t->save();

      $request->session()->flash('success', "Data berhasil disimpan.");
      return redirect('/acl/role');
    }

    public function edit($id)
    {
      $data = Role::findOrFail($id);

      return view('acl.role-form', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
      $logged_user = Auth::user();
      request()->validate([
        'nama' => [
          'required',
          Rule::unique('acl_role', 'nama')->where(function ($query){
            return $query->where('is_deleted', 0);
          })
        ]
      ],[
        'nama.required' => 'Nama role harus diisi!',
        'nama.unique' => 'Role sudah ada!'
      ]);

      $t = Role::findOrFail($id);
      $t->nama = $request->input('nama');
      $t->updated_at = date('Y-m-d H:i:s');
      $t->updated_by = Auth::id();
      $t->save();

      $request->session()->flash('success', "Data berhasil diubah.");
      return redirect("/acl/role/edit/{$id}");
    }

    public function destroy(Request $request, $id)
    {
      $logged_user = Auth::user();
      $t = Role::findOrFail($id);
      $t->deleted_at = date('Y-m-d H:i:s');
      $t->deleted_by = Auth::id();
      $t->is_deleted = 1;
      $t->save();

      $request->session()->flash('success', "Data berhasil dihapus.");
      return redirect('/acl/role');
    }

    public function list_datatables_api()
    {
      $data = Role::where('is_deleted', 0)->orderBy('id', 'ASC')->get();
      return Datatables::of($data)->make(true);
    }
}
