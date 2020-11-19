<?php

namespace App\Http\Controllers\ACL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Repository\ACL\Role;
use App\Repository\ACL\Menu;
use App\Repository\ACL\Permission;

class PermissionController extends Controller
{
	public function index($current_role = 1) // 1 harusnya admin
	{
		$role = Role::where('is_deleted', 0)->get();
		$menu = Menu::where('is_deleted', 0)->get();
		$permission = Permission::where('id_role', $current_role)->get();

		$data_array = [];
		foreach($permission as $idx => $row){
			$data_array['view'][$row->id_menu] = $row->view;
			$data_array['add'][$row->id_menu] = $row->add;
			$data_array['edit'][$row->id_menu] = $row->edit;
			$data_array['delete'][$row->id_menu] = $row->delete;
			$data_array['additional'][$row->id_menu] = $row->additional;
		}
		return view('acl.permission', [
			'role' => $role,
			'menu' => $menu,
			'data_array' => $data_array,
			'current_role' => $current_role
		]);
	}

	public function store(Request $request)
	{
		Auth::user();
		$menu = Menu::where('is_deleted', 0)->get();
		foreach($request->input("menu") as $idx => $val){
			$view = isset($request->input("view")[$val]) ? $request->input("view")[$val] : 0;
			$add = isset($request->input('add')[$val]) ? $request->input('add')[$val] : 0;
			$edit = isset($request->input("edit")[$val]) ? $request->input("edit")[$val] : 0;
			$delete = isset($request->input("delete")[$val]) ? $request->input("delete")[$val] : 0;
			$additional = isset($request->input("additional")[$val]) ? $request->input("additional")[$val] : 0;

			$find_permission = Permission::where("id_menu", $val)->where("id_role", $request->input('role'))->first();
			if(isset($find_permission->id)){
				// update
				$t = Permission::findOrFail($find_permission->id);
				$t->id_menu = $val;
				$t->id_role = $request->input('role');
				$t->view = $view;
				$t->add = $add;
				$t->edit = $edit;
				$t->delete = $delete;
				$t->additional = $additional;
				$t->save();
			} else {
				// create
				$t = new Permission;
				$t->id_menu = $val;
				$t->id_role = $request->input('role');
				$t->view = $view;
				$t->add = $add;
				$t->edit = $edit;
				$t->delete = $delete;
				$t->additional = $additional;
				$t->save();
			}
		}

		$role_name = Role::where('id', $request->input("role"))->first()->nama;
		$request->session()->flash('success', "Permission <strong>{$role_name}</strong> berhasil diubah.");
		return redirect("/acl/permission/{$request->input('role')}");
	}
}
