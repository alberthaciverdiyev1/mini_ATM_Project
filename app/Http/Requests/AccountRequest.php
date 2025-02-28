<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class AccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge(['user_id' => auth()->id()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|string|min:3|max:255",
            "type" => "required|string|in:normal,business",
            'user_id' => 'required|exists:users,id',
        ];
    }
    public function messages(): array{
        return [
            "name.required" => "Name is required.",
            "name.string" => "Name must be a string.",
            "name.min" => "Name must be at least 3 characters.",
            "name.max" => "Name may not be greater than 255 characters.",
            "type.required" => "Type is required.",
            "type.string" => "Type must be a string.",
            "type.in" => "Type must be a string.",
        ];
    }
}
