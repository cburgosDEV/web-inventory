<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreSale extends FormRequest
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
                'idCustomer' => 'required',
                'listDetail' => 'exclude_if:state,false|required',
            ];
        }
    }

    public function messages()
    {
        $messagesES = [
            'idCustomer.required' => '*Este campo es obligatorio.',
            'listDetail.required' => '*Agregar al menos un producto.',
        ];

        return $messagesES;
    }
}
