<?php

namespace App\Http\Controllers;

use App\Repository\Pegawai\Pegawai;
use App\Repository\Pegawai\UserPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index()
    {
      /*Untuk admin*/
      return view('home');
    }

    public function sync_user_pegawai() {
      $pegawai = Pegawai::all();
      // insert into Users
      foreach($pegawai as $row) {
        $tahun_lahir = substr($row->nip, 0,4);
        $user = new User;
        $user->username = $row->nip;
        $user->password = Hash::make($tahun_lahir);
        $user->email = $row->nip.'@inspektorat.com';
        $user->id_role = 3;
        $user->save();

        // saving into user pegawai
        $userPegawai = new UserPegawai;
        $userPegawai->id_user = $user->id;
        $userPegawai->id_pegawai = $row->id;
        $userPegawai->save();
      }
    }
}
