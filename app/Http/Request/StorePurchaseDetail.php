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
                'unitaryPrice' => 'required',
                'quantity' => 'required',
            ];
        }
    }

    public function messages()
    {
        $messagesES = [
            'idProduct.required' => '*Este campo es obligatorio.',
            'unitaryPrice.required' => '*Este campo es obligatorio.',
            'quantity.required' => '*Este campo es obligatorio.',
        ];

        return $messagesES;
    }
}
