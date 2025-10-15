<?php

namespace App\Policies;

use App\Models\Banner;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BannerPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Banner $banner): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Banner $banner): bool
    {
        return false;
    }

    public function delete(User $user, Banner $banner): bool
    {
        return false;
    }

    public function restore(User $user, Banner $banner): bool
    {
        return false;
    }

    public function forceDelete(User $user, Banner $banner): bool
    {
        return false;
    }
}