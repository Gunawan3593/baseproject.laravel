<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageUpdateRequest extends FormRequest
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
            'page_code' => 'required',
            'page_title' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'id wajib isi!',
            'page_code.required' => 'kode wajib isi & unik!',
            'page_title.required' => 'judul wajib isi!'
        ];
    }
}
