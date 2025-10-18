<?php

namespace App\Http\Requests;

use App\Enums\CategoryRelationEnum;
use App\Traits\HasIncludeRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name'    => 'required|string|max:100|unique:categories,name',
            'include' => $this->includeRule(CategoryRelationEnum::values()),
        ];
    }
}