<?php

namespace App\Http\Controllers\ACL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Repository\ACL\Role;
use App\Http\Requests\ACL\UserRequest;
use App\Service\ACL\UserService;
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
      $role = Role::where('is_deleted', 0)->where("id", "!=", 1)->get();
      return view('acl.user-form', ['role' => $role]);
    }

    public function store(UserRequest $request)
    {
      UserService::create($request->input());
      $request->session()->flash('success', "Data berhasil disimpan.");
      return redirect('/acl/user');
    }

    public function edit($id)
    {
      $data = User::findOrFail($id);

      $role = Role::where('is_deleted', 0)->where("id", "!=", 1)->get();
      return view('acl.user-form', [
        'data' => $data,
        'role' => $role
      ]);
    }

    public function update(UserRequest $request, $id)
    {
      UserService::update($id, $request->input());
      $request->session()->flash('success', "Data berhasil diubah.");
      return redirect("/acl/user/edit/{$id}");
    }

    public function destroy(Request $request, $id)
    {
      UserService::delete($id);

      $request->session()->flash('success', "Data berhasil Dihapus.");
      return redirect('/acl/user');
    }

    public function list_datatables_api()
    {
      $data = User::with(['role'])->where('is_deleted', 0);

      return Datatables::eloquent($data)->toJson();
    }
}
