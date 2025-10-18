<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\User;
use App\Models\Category;
use App\Models\PhoneNumber;
use App\Models\Product;
use App\Models\ProductCategories;
use App\Models\ProductImage;
use App\Models\SocialLink;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'              => 'Admin',
            'username'          => 'ayadiab123',
            'email'             => 'areejelghrazzz@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('ayadiab'), // default password
            'role'              => 'admin',
        ]);

        Category::factory(10)->create();
        Banner::factory(7)->create();
        Product::factory(30)->create()->each(function ($product) {
            ProductImage::factory(3)->create([
                'product_id' => $product->id,
            ]);
        });
        PhoneNumber::factory(15)->create();
        SocialLink::factory(5)->create();
    }
}
