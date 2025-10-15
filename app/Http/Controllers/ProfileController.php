<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileDataRequest;
use App\Http\Requests\UpdateProfilePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends ApiController
{
    protected $key = 'profile';

    public function show()
    {
        return $this->runWithTransaction(function () {
            return [
                'user' => auth('sanctum')->user(),
            ];
        },  __('messages.actions.retrieved_success', ['resource' => $this->resource($this->key)]));
    }

    public function updateData(UpdateProfileDataRequest $request)
    {
        return $this->runWithTransaction(function () use ($request) {

            /** @var \App\Models\User $user */
            $user = auth('sanctum')->user();
            $user->update($request->validated());

            return [
                'user' => $user->refresh(),
            ];
        },  __('messages.actions.updated_success', ['resource' => $this->resource($this->key)]));
    }

    public function updatePassword(UpdateProfilePasswordRequest $request)
    {
        return $this->runWithTransaction(function () use ($request) {

            /** @var \App\Models\User $user */
            $user = auth('sanctum')->user();

            $validated = $request->validated();

            if (isset($validated['current_password']) && !Hash::check($validated['current_password'], $user->password)) {
                throw ValidationException::withMessages(['current_password' => __('validation.invalid_value', ['attribute' => __('validation.attributes.current_password')])]);
            }

            if (Hash::check($validated['new_password'], $user->password)) {
                throw ValidationException::withMessages(['new_password' => __('validation.new_password_must_differ')]);
            }

            $user->update([
                'password' => Hash::make($validated['new_password']),
            ]);

            return [
                'user' => $user->refresh(),
            ];
        },  __('messages.password_reset'));
    }
}
