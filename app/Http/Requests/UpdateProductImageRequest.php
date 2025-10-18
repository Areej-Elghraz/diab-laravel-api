<?php

namespace App\Http\Requests;

use App\Enums\ProductImagePositionEnum;
use App\Enums\ProductImageRelationEnum;
use App\Traits\HasIncludeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateProductImageRequest extends FormRequest
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
            'image'    => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', /// images
            'position' => ['sometimes', 'required_with:image', new Enum(ProductImagePositionEnum::class)], /// positions.*
            'include'  => $this->includeRule(ProductImageRelationEnum::values()),
        ];
    }
}
