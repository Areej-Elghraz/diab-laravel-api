<?php

namespace App\Http\Requests;

use App\Enums\ProductImagePositionEnum;
use App\Enums\ProductImageRelationEnum;
use App\Traits\HasIncludeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreProductImageRequest extends FormRequest
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
            'images'      => 'required|array', /// images
            'images.*'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  /// images.*
            'positions'   => "required_with:images|array|size:" . count($this->images),
            'positions.*' => ['required', new Enum(ProductImagePositionEnum::class)], /// positions.*
            'include'     => $this->includeRule(ProductImageRelationEnum::values()),
        ];
    }
}
