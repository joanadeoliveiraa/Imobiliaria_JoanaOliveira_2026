<?php

namespace App\Support;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ClientAccount
{
    public static function for(User $user): Cliente
    {
        abort_unless($user->tipo === 'cliente', 403);

        return DB::transaction(function () use ($user) {
            $cliente = $user->cliente()->first();
            if (! $cliente) {
                // A associação exige um vínculo explícito; o email não comprova a titularidade.
                $cliente = Cliente::create([
                    'user_id' => $user->id, 'nome' => $user->name, 'email' => $user->email,
                ]);
            }

            return $cliente;
        });
    }
}
