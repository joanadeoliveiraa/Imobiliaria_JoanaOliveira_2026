<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente' => ['required', 'string', 'max:255', 'exists:clientes,nome'],
            'apartamento' => ['required', 'string', 'max:255', 'exists:apartamentos,referencia'],
            'data_entrada' => ['required', 'date'],
            'data_saida' => ['required', 'date', 'after:data_entrada'],
            'valor_total' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        ];
    }
}
