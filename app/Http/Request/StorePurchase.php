<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchase extends FormRequest
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
                'idSupplier' => 'required',
                'listDetail' => 'exclude_if:state,false|required',
            ];
        }
    }

    public function messages()
    {
        $messagesES = [
            'idSupplier.required' => '*Este campo es obligatorio.',
            'listDetail.required' => '*Seleccionar al menos un producto.',
        ];

        return $messagesES;
    }
}
