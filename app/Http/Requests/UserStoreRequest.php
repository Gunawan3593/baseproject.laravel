<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'repeat_password' => 'required|same:password',
            'role' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'nama wajib isi!',
            'email.required' => 'email wajib isi!',
            'email.email' => 'email tidak valid',
            'email.unique' => 'email sudah terpakai, silahkan pakai yang lain',
            'password.required' => 'sandi wajib isi',
            'repeat_password.required' => 'sandi wajib isi',
            'repeat_password.same' => 'sandi tidak sama, silahkan input dengan benar',
            'role.required' => 'minimal satu group hak akses dipilih' 
        ];
    }
}
