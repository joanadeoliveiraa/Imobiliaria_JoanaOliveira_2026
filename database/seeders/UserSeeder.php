<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            throw new RuntimeException('O UserSeeder destina-se apenas aos ambientes local e de testes.');
        }

        $admin = config('seeding.admin');

        if (! filter_var($admin['email'], FILTER_VALIDATE_EMAIL) || strlen((string) $admin['password']) < 12) {
            throw new RuntimeException('Configure SEED_ADMIN_EMAIL e SEED_ADMIN_PASSWORD (mínimo 12 caracteres) no .env.');
        }

        // Never reset credentials or promote an existing account when rerunning seeds.
        $user = User::firstOrCreate(['email' => $admin['email']], [
            'name' => $admin['name'],
            'password' => Hash::make($admin['password']),
            'tipo' => 'administrador',
        ]);

        if ($user->tipo !== 'administrador') {
            throw new RuntimeException('O email configurado já pertence a uma conta sem perfil de administrador.');
        }

        $this->command?->info($user->wasRecentlyCreated
            ? 'Administrador local criado. As credenciais estão no .env.'
            : 'Administrador existente preservado, sem alterar a palavra-passe.');
    }
}
