<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $cliente = $this->route('cliente');
        $clienteId = is_object($cliente) ? $cliente->getKey() : $cliente;

        return [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc', 'max:255', Rule::unique('clientes', 'email')->ignore($clienteId)],
            'telefone' => ['required', 'string', 'max:30'],
            'morada' => ['required', 'string', 'max:255'],
            'nif' => ['required', 'digits:9', Rule::unique('clientes', 'nif')->ignore($clienteId)],
        ];
    }
}
