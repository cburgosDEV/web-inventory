<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleDetail extends FormRequest
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
                'unitaryPrice' => 'required|numeric|gt:minPrice',
                'quantity' => 'required|numeric|gt:0|lte:stock',
            ];
        }
    }

    public function messages()
    {
        $messagesES = [
            'idProduct.required' => '*Este campo es obligatorio.',
            'unitaryPrice.required' => '*Este campo es obligatorio.',
            'unitaryPrice.numeric' => '**Ingresar un número válido.',
            'unitaryPrice.gt' => '*Verificar el precio.',
            'quantity.required' => '*Este campo es obligatorio.',
            'quantity.numeric' => '**Ingresar un número válido.',
            'quantity.lte' => '*Verificar el stock.',
            'quantity.gt' => '*Verificar el stock.',
        ];

        return $messagesES;
    }
}
