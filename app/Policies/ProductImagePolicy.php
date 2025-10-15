<?php

namespace App\Policies;

use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductImagePolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, ProductImage $productImage): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, ProductImage $productImage): bool
    {
        return false;
    }

    public function delete(User $user, ProductImage $productImage): bool
    {
        return false;
    }

    public function restore(User $user, ProductImage $productImage): bool
    {
        return false;
    }

    public function forceDelete(User $user, ProductImage $productImage): bool
    {
        return false;
    }
}
