<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\ClientAccount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ClientDemoSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            throw new RuntimeException('Este Seeder destina-se apenas a desenvolvimento e testes.');
        }

        $password = config('seeding.client_password');
        if (! is_string($password) || strlen($password) < 16) {
            throw new RuntimeException('Configure SEED_CLIENT_PASSWORD no .env com pelo menos 16 caracteres.');
        }

        DB::transaction(function () use ($password) {
            $user = User::firstOrCreate(['email' => 'joana@oliveproperties.test'], [
                'name' => 'Joana Oliveira',
                'tipo' => 'cliente',
                'password' => $password,
                'email_verified_at' => now(),
            ]);

            if ($user->tipo !== 'cliente') {
                throw new RuntimeException('O email pertence a outro perfil. A conta existente foi preservada.');
            }

            ClientAccount::for($user);
        });

        $this->command?->info('Cliente joana@oliveproperties.test disponível. Contas e credenciais existentes preservadas.');
    }
}
