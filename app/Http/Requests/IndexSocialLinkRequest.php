<?php

namespace App\Http\Requests;

use App\Enums\SocialMediaEnum;
use App\Traits\HasIncludeRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexSocialLinkRequest extends FormRequest
{
    use HasIncludeRule;
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
            'social_media' => $this->includeRule(SocialMediaEnum::values()),
        ];
    }
}
