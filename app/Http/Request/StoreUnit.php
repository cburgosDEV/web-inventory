<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnit extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if($this->method() == 'POST')
        {
            return [
                'name' => 'required|max:50',
                'symbol' => 'required|max:10',
            ];
        }
    }

    public function messages()
    {
        $messagesES = [
            'name.required' => '*Este campo es obligatorio.',
            'name.max' => '*Este campo no debe exceder los :max caracteres.',
            'symbol.required' => '*Este campo es obligatorio.',
            'symbol.max' => '*Este campo no debe exceder los :max caracteres.',
        ];

        return $messagesES;
    }
}
