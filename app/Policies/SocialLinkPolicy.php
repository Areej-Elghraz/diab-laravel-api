<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SocialLink;

class SocialLinkPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, SocialLink $socialLink): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, SocialLink $socialLink): bool
    {
        return false;
    }

    public function delete(User $user, SocialLink $socialLink): bool
    {
        return false;
    }

    public function restore(User $user, SocialLink $socialLink): bool
    {
        return false;
    }

    public function forceDelete(User $user, SocialLink $socialLink): bool
    {
        return false;
    }
}
