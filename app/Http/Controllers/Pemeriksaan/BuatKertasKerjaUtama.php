<?php

namespace App\Http\Controllers\Pemeriksaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;

class BuatKertasKerjaUtama extends Controller{
    public function index()
    {
        return view('/pemeriksaan/audit/buat-kertaskerja-utama');
    }
}