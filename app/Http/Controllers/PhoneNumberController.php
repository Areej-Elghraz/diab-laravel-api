<?php

namespace App\Http\Controllers;

use App\Filters\PhoneNumberFilter;
use App\Http\Requests\IndexPhoneNumberRequest;
use App\Http\Requests\StorePhoneNumberRequest;
use App\Http\Requests\UpdatePhoneNumberRequest;
use App\Models\PhoneNumber;
use App\Traits\HasIncludeRule;

class PhoneNumberController extends ApiController
{
    use HasIncludeRule;
    protected $key = 'phonenumber';
    public function index(IndexPhoneNumberRequest $request)
    {
        return $this->runWithTransaction(function () use ($request) {
            return [
                'phone_numbers' => (new PhoneNumberFilter())->apply(PhoneNumber::query(), $request)->get(),
            ];
        },  __('messages.actions.retrieved_success', ['resource' => $this->resources($this->key)]));
    }

    public function store(StorePhoneNumberRequest $request)
    {
        return $this->runWithTransaction(function () use ($request) {

            $phoneNumber = PhoneNumber::create($request->validated());

            return [
                'phone_number' => $phoneNumber,
            ];
        },  __('messages.actions.created_success', replace: ['resource' => $this->resource($this->key)]), successStatus: 201);
    }

    public function show(PhoneNumber $phoneNumber)
    {
        return $this->runWithTransaction(function () use ($phoneNumber) {
            return [
                'phone_number' => $phoneNumber,
            ];
        },  __('messages.actions.retrieved_success', ['resource' => $this->resource($this->key)]));
    }

    public function showByType(string $type)
    {
        return $this->runWithTransaction(function () use ($type) {

            $phoneNumber = PhoneNumber::ofType($this->includeStrToArray($type))->first();
            return [
                'phone_number' => $phoneNumber,
            ];
        },  __('messages.actions.retrieved_success', ['resource' => $this->resource($this->key)]));
    }

    public function update(UpdatePhoneNumberRequest $request, PhoneNumber $phoneNumber)
    {
        return $this->runWithTransaction(function () use ($request, $phoneNumber) {

            $phoneNumber->update($request->validated());

            return [
                'phone_number' => $phoneNumber->refresh(),
            ];
        },  __('messages.actions.updated_success', ['resource' => $this->resource($this->key)]));
    }

    public function destroy(PhoneNumber $phoneNumber)
    {
        return $this->runWithTransaction(function () use ($phoneNumber) {

            $phoneNumber->delete();

            return [
                'phone_number' => $phoneNumber,
            ];
        },  __('messages.actions.deleted_success', replace: ['resource' => $this->resource($this->key)]));
    }
}
