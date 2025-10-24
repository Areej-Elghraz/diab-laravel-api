<?php

namespace App\Http\Requests;

use App\Enums\SocialMediaEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreSocialLinkRequest extends FormRequest
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
        return [
            'url'          => 'required|url',
            'social_media' => ['required_with:url', new Enum(SocialMediaEnum::class)],
        ];
    }
}
