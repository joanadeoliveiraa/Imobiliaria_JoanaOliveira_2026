<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\ClientAccount;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        if (! $this->configured()) {
            return $this->failure('O login com Google ainda não está disponível. Pode criar uma conta com email e palavra-passe.');
        }

        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        if (! $this->configured() || $request->has('error')) {
            $request->session()->forget('state');

            return $this->failure('O login com Google não foi concluído. Tente novamente ou entre com email e palavra-passe.');
        }

        try {
            // Socialite validates the one-time OAuth state stored in this session.
            $google = Socialite::driver('google')->user();
        } catch (\Exception) {
            return $this->failure('Não foi possível confirmar o login com Google. Tente novamente.');
        }

        $email = Str::lower((string) $google->getEmail());
        if (! $google->getId() || ! filter_var($email, FILTER_VALIDATE_EMAIL)
            || strlen($email) > 255 || ($google->user['email_verified'] ?? false) !== true) {
            return $this->failure('A conta Google precisa de um email verificado para continuar.');
        }

        try {
            $user = DB::transaction(function () use ($google, $email) {
                $user = User::where('google_id', $google->getId())->first();
                if ($user && $user->tipo !== 'cliente') {
                    throw ValidationException::withMessages(['google' => 'As contas administrativas devem entrar com email e palavra-passe.']);
                }
                if (! $user) {
                    // Never link an existing account solely by a matching email.
                    if (User::where('email', $email)->exists()) {
                        throw ValidationException::withMessages(['google' => 'Já existe uma conta com este email. Entre com a sua palavra-passe ou utilize a recuperação de palavra-passe.']);
                    }
                    $user = new User([
                        'name' => Str::limit($google->getName() ?: $email, 255, ''),
                        'email' => $email,
                        'password' => Str::random(64),
                        'tipo' => 'cliente',
                    ]);
                    $user->google_id = $google->getId();
                    $user->email_verified_at = now();
                    $user->save();
                }
                ClientAccount::for($user);

                return $user;
            });
        } catch (ValidationException $exception) {
            return redirect()->route('login')->withErrors($exception->errors());
        } catch (UniqueConstraintViolationException) {
            return $this->failure('Esta conta já foi registada. Volte a tentar iniciar sessão.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('client.home');
    }

    private function configured(): bool
    {
        return filled(config('services.google.client_id')) && filled(config('services.google.client_secret'));
    }

    private function failure(string $message): RedirectResponse
    {
        return redirect()->route('login')->withErrors(['google' => $message]);
    }
}
