<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpense extends FormRequest
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
                'amount' => 'required|numeric',
            ];
        }
    }

    public function messages()
    {
        $messagesES = [
            'name.required' => '*Este campo es obligatorio.',
            'name.max' => '*Este campo no debe exceder los :max caracteres.',
            'amount.required' => '*Este campo no debe exceder los :max caracteres.',
            'amount.numeric' => '*Ingresar un número válido.',
        ];

        return $messagesES;
    }
}
