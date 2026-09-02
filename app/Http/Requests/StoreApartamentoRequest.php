<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApartamentoRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $estados = [
            'Disponível' => 'Disponivel',
            'Não Disponível' => 'Nao Disponivel',
            'Não disponível' => 'Nao Disponivel',
        ];

        if (isset($estados[$this->estado])) {
            $this->merge(['estado' => $estados[$this->estado]]);
        }
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipologia' => ['required', 'string', 'max:20'],
            'morada' => ['required', 'string', 'max:255'],
            'area' => ['required', 'numeric', 'min:1', 'max:999999.99'],
            'preco' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'estado' => ['required', Rule::in(['Disponivel', 'Nao Disponivel'])],
            'fotografia' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }
}
