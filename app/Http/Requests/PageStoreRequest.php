<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageStoreRequest extends FormRequest
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
            'page_code' => 'required|unique:pages',
            'page_title' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'page_code.required' => 'kode wajib isi & unik!',
            'page_title.required' => 'judul wajib isi!'
        ];
    }
}
