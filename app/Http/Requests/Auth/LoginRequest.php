<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;


class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:16'],
            'g-recaptcha-response' => ['required'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $user = User::where('email', $this->email)->first();

    // Verificar si ya está bloqueado antes de intentar
    if ($user && $user->is_blocked) {
        throw ValidationException::withMessages([
            'email' => 'Cuenta bloqueada por seguridad (3 intentos fallidos). contacte al Admin.',
        ]);
    }

    if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
        // Lógica de conteo de intentos
        if ($user) {
            $user->increment('login_attempts');
            if ($user->login_attempts >= 3) {
                $user->update(['is_blocked' => true]);
            }
        }

        throw ValidationException::withMessages(['email' => trans('auth.failed')]);
    }

    // Si entra con éxito, reseteamos intentos y grabamos bitácora
    $user->update(['login_attempts' => 0]);

        \App\Models\Bitacora::create([
        'user_id' => $user->id,
        'accion' => 'Inicio de sesión exitoso',
        'ip_address' => $this->ip(),
        'user_agent' => $this->userAgent(),
    ]);

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
