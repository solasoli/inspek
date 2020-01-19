<?php

namespace App\Http\Controllers\RKA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Validator;
use Auth;
use Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use App\RKA;

date_default_timezone_set('Asia/Jakarta');

class RKAController extends Controller
{
    public function detail(Request $request, $id)
    {
      $rka = RKA::findOrFail($id);
      return view('rka.rka-detail',[
        'data' => $rka
      ]);
    }

}
