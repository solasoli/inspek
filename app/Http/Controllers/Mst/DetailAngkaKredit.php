<?php

namespace App\Http\Controllers\Mst;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;

class DetailAngkaKredit extends Controller{
    public function index()
    {
        return view('/Mst/pegawai/detail-angka-kredit');
    }
}