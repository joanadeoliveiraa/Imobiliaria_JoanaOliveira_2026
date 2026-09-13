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
            'cliente_id' => ['required', 'integer', 'exists:clientes,id'],
            'apartamento_id' => ['required', 'integer', 'exists:apartamentos,id'],
            'data_entrada' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'data_saida' => ['required', 'date_format:Y-m-d', 'after:data_entrada'],
        ];
    }

    public function messages(): array
    {
        return [
            'cliente_id.required' => 'Selecione um cliente.',
            'cliente_id.exists' => 'O cliente selecionado já não existe.',
            'apartamento_id.required' => 'Selecione uma propriedade.',
            'apartamento_id.exists' => 'A propriedade selecionada já não existe.',
            'data_entrada.required' => 'Indique a data de entrada.',
            'data_entrada.after_or_equal' => 'A entrada não pode ser anterior a hoje.',
            'data_saida.required' => 'Indique a data de saída.',
            'data_saida.after' => 'A saída deve ser posterior à entrada.',
        ];
    }
}
