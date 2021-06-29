<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomer extends FormRequest
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
                'dni' => 'exclude_if:idTypePerson,2|size:8',
                'ruc' => 'exclude_if:idTypePerson,1|size:11',
                'phone' => 'max:20',
                'address' => 'max:50',
            ];
        }
    }

    public function messages()
    {
        $messagesES = [
            'name.required' => '*Este campo es obligatorio.',
            'name.max' => '*Este campo no debe exceder los :max caracteres.',
            'dni.size' => '*El DNI debe tener :size caracteres.',
            'ruc.size' => '*El RUC debe tener :size caracteres.',
            'phone.max' => 'Este campo no debe exceder los :max caracteres.',
            'address.max' => 'Este campo no debe exceder los :max caracteres.',
        ];

        return $messagesES;
    }
}
