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
use App\Repository\ACL\Menu;
use App\Service\ACL\MenuService;
use App\Http\Requests\ACL\MenuRequest;

date_default_timezone_set('Asia/Jakarta');

class MenuController extends Controller
{
    public function index()
    {
      return view('acl.menu-list');
    }

    public function create()
    {
      $all_menu = Menu::where('is_deleted', 0)->get();
      return view('acl.menu-form', ['all_menu' => $all_menu]);
    }

    public function store(MenuRequest $request)
    {
      MenuService::create($request->input());
      $request->session()->flash('success', "Data berhasil disimpan.");
      return redirect('/acl/menu');
    }

    public function edit($id)
    {
      $all_menu = Menu::where('is_deleted', 0)->get();
      $data = Menu::findOrFail($id);

      return view('acl.menu-form', [
        'data' => $data,
        'all_menu' => $all_menu
      ]);
    }

    public function update(MenuRequest $request, $id)
    {
      MenuService::update($id, $request->input());
      $request->session()->flash('success', "Data berhasil disimpan!");
      return redirect("/acl/menu/edit/{$id}");
    }

    public function destroy(Request $request, $id)
    {
      MenuService::delete($id);

      $request->session()->flash('success', "Data berhasil dihapus!");
      return redirect('/acl/menu');
    }

    public function list_datatables_api()
    {
      $data = Menu::where('is_deleted', 0)->orderBy('nama', 'ASC')->get();
      return Datatables::of($data)->make(true);
    }
}
