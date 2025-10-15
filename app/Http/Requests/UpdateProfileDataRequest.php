<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileDataRequest extends FormRequest
{
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
        $user = auth('sanctum')->user();
        return [
            'name'     => 'sometimes|nullable|string|max:100',
            'username' => 'sometimes|nullable|string|min:3|max:100|regex:/^[a-zA-Z][a-zA-Z0-9._]*$/|unique:users,username,' . $user->id,
            'email'    => 'sometimes|nullable|email|unique:users,email,' . $user->id,
        ];
    }
}
