<?php

namespace App\Rules\Auth;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserBlockRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value) {
            $user = User::query()->where('login', $value)->first();

            if (!$user) {
                $fail(__('messages.user.error.no-user'));
            }

            if ($user && $user->is_blocked) {
                $fail(__('messages.user.success.blocked'));
            }
        }
    }
}
