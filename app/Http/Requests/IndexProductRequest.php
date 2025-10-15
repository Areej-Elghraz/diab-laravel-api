<?php

namespace App\Http\Requests;

use App\Enums\ProductRelationEnum;
use App\Traits\HasIncludeRule;
use Illuminate\Foundation\Http\FormRequest;

class IndexProductRequest extends FormRequest
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
            // 'search'      => 'sometimes|nullable|string',
            // 'sort_by'     => 'sometimes|nullable|string|in:name,created_at,updated_at,category.name,creator.name',
            // 'sort_dir'    => 'sometimes|nullable|string|in:asc,desc',
            'category_id' => 'sometimes|nullable|integer|exists:categories,id',
            'per_page'    => 'sometimes|nullable|integer|min:1',
            'include'     => $this->includeRule(ProductRelationEnum::values()),
        ];
    }
}
