<?php

namespace App\Policies;

use App\Models\PhoneNumber;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PhoneNumberPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, PhoneNumber $phoneNumber): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, PhoneNumber $phoneNumber): bool
    {
        return false;
    }

    public function delete(User $user, PhoneNumber $phoneNumber): bool
    {
        return false;
    }

    public function restore(User $user, PhoneNumber $phoneNumber): bool
    {
        return false;
    }

    public function forceDelete(User $user, PhoneNumber $phoneNumber): bool
    {
        return false;
    }
}
