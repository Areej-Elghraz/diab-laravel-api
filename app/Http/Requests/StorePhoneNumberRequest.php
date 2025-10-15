<?php

namespace App\Http\Requests;

use App\Enums\PhoneNumberTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StorePhoneNumberRequest extends FormRequest
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
            'phone'  => 'required|unique:phone_numbers,phone|phone:AUTO',
            'type'   => 'required_with:phone|array|min:1',
            'type.*' => ['required', new Enum(PhoneNumberTypeEnum::class)],
        ];
    }

    public function messages()
    {
        return [
            'phone.phone' => __('validation.invalid_value', ['attribute' => __('validation.attributes.phone')])
        ];
    }
}
