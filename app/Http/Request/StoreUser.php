<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
                'name' => 'required|max:255',
                'email' => 'email|required|exclude_unless:id,0|unique:users',
                'password' =>'exclude_unless:id,0|required',
                'role' =>'required',
            ];
        }
    }

    public function messages()
    {
        $messagesES = [
            'name.required' => '*Este campo es obligatorio.',
            'name.max' => '*Este campo no debe exceder los :max caracteres.',
            'email.required' => '*Este campo es obligatorio.',
            'email.email' => '*Ingresar un email válido.',
            'email.unique' => '*Email ya registrado.',
            'password.required' => '*Este campo es obligatorio.',
            'role.required' => '*Este campo es obligatorio.',
        ];

        return $messagesES;
    }
}
