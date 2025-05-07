<?php

namespace App\Rules\Auth;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class CheckCredentialsRule implements ValidationRule
{
    private string $email;

    public function __construct(string|null $email)
    {
        if ($email) {
            $this->email = $email;
        }
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->email) {
            $user = User::query()->where('email', $this->email)->first();

            if (!$user) {
                $fail(__('messages.user.error.no-user'));
            }

            if ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail(__('messages.user.error.wrong-password'));
                }
            }
        }
    }
}
