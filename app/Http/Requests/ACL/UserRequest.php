<?php

namespace App\Http\Requests\ACL;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class userRequest extends FormRequest
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
          'username'      => 'required|unique:users,username,'.$this->route('id'),
          'email'         => 'required|unique:users,email,'.$this->route('id'),
          'role'          => 'required',
        ];
    }
}
