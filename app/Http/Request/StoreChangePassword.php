<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreChangePassword extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if($this->method() == 'POST'){
            return [
                'password' =>'required|string|min:8|same:rePassword',
                'rePassword' =>'required|string|min:8',
            ];
        }
    }

    public function messages()
    {
        $messagesES = [
            'password.required' => '*Este campo es obligatorio.',
            'password.min' => '*La contraseña debe ser mayor a 8 dígitos.',
            'password.same' => '*Las contraseñas deben ser iguales.',
            'rePassword.required' => '*Este campo es obligatorio.',
        ];

        return $messagesES;
    }
}
