<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PegawaiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'nip' => 'required|unique:pgw_pegawai,nip,'.$this->route('id'),
          'opd' => 'required',
          'eselon' => 'required',
          'pangkat' => 'required',
          'pangkat_golongan' => 'required',
          'jabatan' => 'required',
          'nama' => 'required',
          'nama_asli' => 'required',
          'jenjab' => 'required',
          'score_angka_credit' => 'required'
        ];
    }
}
