<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseDetail extends FormRequest
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
                'idProduct' => 'required',
                'unitaryPrice' => 'required|numeric|gt:0',
                'quantity' => 'required|numeric|gt:0',
            ];
        }
    }

    public function messages()
    {
        $messagesES = [
            'idProduct.required' => '*Este campo es obligatorio.',
            'unitaryPrice.required' => '*Este campo es obligatorio.',
            'unitaryPrice.numeric' => '**Ingresar un número válido.',
            'unitaryPrice.gt' => '*El precio no puede ser menor o igual a 0.',
            'quantity.required' => '*Este campo es obligatorio.',
            'quantity.numeric' => '**Ingresar un número válido.',
            'quantity.gt' => '*La cantidad no puede ser menor o igual a 0.',
        ];

        return $messagesES;
    }
}
