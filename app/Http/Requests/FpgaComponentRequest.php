<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FpgaComponentRequest extends FormRequest
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
        return [
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'model' => 'required|string|max:255',
            'frequency' => 'required|numeric|min:0',
            'lut_count' => 'required|integer|min:0',
            'power' => 'required|numeric|min:0',
            'io_count' => 'required|integer|min:0',
            'cost' => 'required|numeric|min:0',
            'availability' => 'required|string|max:255',
            'standard_id' => 'nullable|array',
            'standard_id.*' => 'exists:standards,id',
        ];
    }
}
