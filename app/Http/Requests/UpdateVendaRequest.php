<?php

namespace App\Http\Requests;

class UpdateVendaRequest extends StoreVendaRequest
{
    public function rules(): array
    {
        return [
            'cliente' => ['required', 'string', 'max:255', 'exists:clientes,nome'],
            'data_entrada' => ['required', 'date'],
            'data_saida' => ['required', 'date', 'after:data_entrada'],
            'valor_total' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        ];
    }
}
