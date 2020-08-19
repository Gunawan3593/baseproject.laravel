<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'id' => 'required',
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable|min:8',
            'repeat_password' => 'nullable|same:password',
            'role' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'nama wajib isi!',
            'email.required' => 'email wajib isi!',
            'email.email' => 'email tidak valid',
            'password.required' => 'sandi wajib isi',
            'repeat_password.required' => 'sandi wajib isi',
            'repeat_password.same' => 'sandi tidak sama, silahkan input dengan benar',
            'role.required' => 'minimal satu group hak akses dipilih' 
        ];
    }
}
