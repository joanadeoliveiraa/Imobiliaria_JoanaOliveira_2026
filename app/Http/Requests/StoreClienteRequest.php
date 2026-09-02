<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc', 'max:255', 'unique:clientes,email'],
            'telefone' => ['required', 'string', 'max:30'],
            'morada' => ['required', 'string', 'max:255'],
            'nif' => ['required', 'digits:9', 'unique:clientes,nif'],
            'origem' => ['nullable', 'in:reserva'],
        ];
    }
}
