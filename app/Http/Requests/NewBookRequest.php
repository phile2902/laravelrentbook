<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NewBookRequest extends Request
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
            'name' => 'required|unique:books',
            'info' => 'required|min:10',
            'uploadImage' => 'required|image|max:150000'
        ];
    }
}
