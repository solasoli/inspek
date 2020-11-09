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
use App\Repository\ACL\Role;
use App\Service\ACL\RoleService;
use App\Http\Requests\ACL\RoleRequest;

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

    public function store(RoleRequest $request)
    {
      RoleService::create($request->input());
      $request->session()->flash('success', "Data berhasil disimpan.");
      return redirect('/acl/role');
    }

    public function edit($id)
    {
      $data = Role::findOrFail($id);

      return view('acl.role-form', ['data' => $data]);
    }

    public function update(RoleRequest $request, $id)
    {
      RoleService::update($id, $request->input());
      $request->session()->flash('success', "Data berhasil disimpan!");
      return redirect("/acl/role/edit/{$id}");
    }

    public function destroy(Request $request, $id)
    {
      RoleService::delete($id);

      $request->session()->flash('success', "Data berhasil dihapus.");
      return redirect('/acl/role');
    }

    public function list_datatables_api()
    {
      $data = Role::where('is_deleted', 0)->orderBy('id', 'ASC')->get();
      return Datatables::of($data)->make(true);
    }
}
