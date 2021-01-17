<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProgramKerjaRequest extends FormRequest
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
          // 'wilayah'       => 'required',
        //   'opd'           => 'required',
          'dari'          => 'required',
          'sampai'        => 'required',
          'kegiatan'      => 'required',
          // 'sub_kegiatan'  => 'required',
          // 'sasaran.*'     => 'required'
        ];
    }
}
