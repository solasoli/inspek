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
use App\User;
// use App\SKPD;
use App\Role;
use Hash;

date_default_timezone_set('Asia/Jakarta');

class UserController extends Controller
{
    public function index()
    {
      return view('acl.user-list');
    }

    public function create()
    {
      // $skpd = SKPD::where("is_deleted", 0)->get();
      $role = Role::where('is_deleted', 0)->where("id", "!=", 1)->get();
      return view('acl.user-form', [
        // 'skpd' => $skpd,
        'role' => $role
      ]);
    }

    public function store(Request $request)
    {
      $logged_user = Auth::user();
      request()->validate([
        'username' => [
          'required',
          Rule::unique('users', 'username')->where(function ($query){
            return $query->where('is_deleted', 0);
          })
        ],
        // 'nama' => 'required',
        // 'skpd' => 'required',
        'role' => 'required',
        'email' => [
          'required',
          Rule::unique('users', 'email')->where(function ($query){
            return $query->where('is_deleted', 0);
          }),
          'email'
        ],
        'password' => 'required',
        'conf_password' => 'required|same:password'
      ]);

      $t = new User;
      // $t->name = $request->input('nama');
      // $t->id_skpd = $request->input('skpd');
      $t->id_role = $request->input('role');
      $t->email = $request->input('email');
      $t->username = $request->input('username');
      $t->password = Hash::make($request->input('password'));
      $t->is_deleted = 0;
      $t->save();

      $request->session()->flash('success', "Data berhasil disimpan.");
      return redirect('/acl/user');
    }

    public function edit($id)
    {
      $data = User::findOrFail($id);

      // $skpd = SKPD::where("is_deleted", 0)->get();
      $role = Role::where('is_deleted', 0)->where("id", "!=", 1)->get();
      return view('acl.user-form', [
        'data' => $data,
        // 'skpd' => $skpd,
        'role' => $role
      ]);
    }

    public function update(Request $request, $id)
    {
      $logged_user = Auth::user();
      request()->validate([
        'username' => [
          'required',
          Rule::unique('users', 'username')->where(function ($query) use ($id){
            return $query->where('is_deleted', 0)->where("id", "!=", $id);
          })
        ],
        // 'nama' => 'required',
        // 'skpd' => 'required',
        'role' => 'required',
        'email' => [
          'required',
          Rule::unique('users', 'email')->where(function ($query)use ($id){
            return $query->where('is_deleted', 0)->where("id", "!=", $id);
          }),
          'email'
        ]
      ]);

      if($request->input('password') != ''){
        request()->validate([
          'password' => 'required',
          'conf_password' => 'required|same:password'
        ]);
      }

      $t = User::findOrFail($id);
      // $t->name = $request->input('nama');
      // $t->id_skpd = $request->input('skpd');
      $t->id_role = $request->input('role');
      $t->email = $request->input('email');
      $t->username = $request->input('username');
      if($request->input('password') != ''){
        $t->password = Hash::make($request->input('password'));
      }
      $t->is_deleted = 0;
      $t->save();

      $request->session()->flash('success', "Data berhasil diubah.");
      return redirect("/acl/user/edit/{$id}");
    }

    public function destroy(Request $request, $id)
    {
      $logged_user = Auth::user();
      $t = User::findOrFail($id);
      $t->deleted_at = date('Y-m-d H:i:s');
      $t->deleted_by = Auth::id();
      $t->is_deleted = 1;
      $t->save();

      $request->session()->flash('success', "Data berhasil Dihapus.");
      return redirect('/acl/user');
    }

    public function list_datatables_api()
    {
      $data = DB::table("users AS u")
      ->select(DB::raw("u.*, r.nama AS role"))
      ->join("acl_role AS r", "u.id_role" , "=" , "r.id")
      ->where("id_role", "!=", 1);
      return Datatables::of($data)->make(true);
    }
}
