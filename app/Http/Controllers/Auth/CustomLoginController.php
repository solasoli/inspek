<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User as User;
use Session;

class CustomLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('auth.login');
    }

    public function login_proses(Request $request)
    {
        /* find user */
        $find_user = User::where('username', $request->input('username'))->first();
        if (Auth::attempt([
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ])) {
            Auth::user()->push('username', $find_user->username);
            Auth::user()->push('role', $find_user->id_role);
            return redirect('/');
        } else {
            /* balikin ke login */
            Session::flash('status', 'Username atau Password Salah');
            return redirect('/login');
        }
    }



    function not_allowed()
    {
        return view('page_403');
    }
}
