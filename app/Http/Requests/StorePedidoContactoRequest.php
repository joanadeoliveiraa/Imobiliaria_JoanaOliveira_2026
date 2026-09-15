<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePedidoContactoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $trimmed = fn (string $key) => is_string($this->input($key)) ? trim($this->input($key)) : $this->input($key);
        $phone = $trimmed('telefone');
        $this->merge([
            'nome' => $trimmed('nome'),
            'email' => $trimmed('email'),
            'telefone' => $phone === '' ? null : $phone,
            'assunto' => $trimmed('assunto'),
            'mensagem' => $trimmed('mensagem'),
        ]);
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'min:2', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'telefone' => ['nullable', 'string', 'min:7', 'max:30', 'regex:/^[+0-9() .-]+$/'],
            'assunto' => ['required', 'string', 'min:3', 'max:160'],
            'mensagem' => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'Indique o seu nome.', 'nome.min' => 'O nome deve ter pelo menos 2 caracteres.', 'nome.max' => 'O nome é demasiado longo.',
            'email.required' => 'Indique o seu email.', 'email.email' => 'Indique um email válido.', 'email.max' => 'O email é demasiado longo.',
            'telefone.min' => 'Indique um telefone válido ou deixe o campo vazio.', 'telefone.max' => 'O telefone é demasiado longo.', 'telefone.regex' => 'O telefone só pode conter números e os sinais habituais.',
            'assunto.required' => 'Indique o assunto.', 'assunto.min' => 'O assunto deve ter pelo menos 3 caracteres.', 'assunto.max' => 'O assunto é demasiado longo.',
            'mensagem.required' => 'Escreva a mensagem.', 'mensagem.min' => 'A mensagem deve ter pelo menos 10 caracteres.', 'mensagem.max' => 'A mensagem é demasiado longa.',
        ];
    }
}
