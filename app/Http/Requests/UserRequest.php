<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'email' => ['required', 'max:255', 'email', Rule::unique('users')->ignore($user)],
            'name' => ['required', 'max:255'],
            'role_id' => ['nullable'],
            'password' => ['nullable', 'max:255', 'confirmed'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'role_id' => $this->input('role_id') == 'admin' ? 1 : 2,
        ]);
    }
}
