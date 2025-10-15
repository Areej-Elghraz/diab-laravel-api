<?php

namespace App\Http\Requests;

use App\Enums\ProductImagePositionEnum;
use App\Enums\SocialMediaEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateSocialLinkRequest extends FormRequest
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
            'url'          => 'sometimes|nullable|url',
            'social_media' => ['sometimes', 'required_with:url', new Enum(SocialMediaEnum::class)],
        ];
    }
}