<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
                'description' => 'max:500',
                'idUnit' => 'gt:0',
            ];
        }
    }

    public function messages()
    {
        $messagesES = [
            'name.required' => '*Este campo es obligatorio.',
            'name.max' => '*Este campo no debe exceder los :max caracteres.',
            'description.max' => '*Este campo no debe exceder los :max caracteres.',
            'idUnit.gt' => '*Este campo es obligatorio.',
        ];

        return $messagesES;
    }
}
