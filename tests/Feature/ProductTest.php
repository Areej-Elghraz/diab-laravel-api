<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->data = [
        'name' => fake()->unique()->name(),
        'description' => 'ركنة: 4 فتيه و 1 كنبة و 1 ترابيزة',
        'category_id' => Category::inRandomOrder()->first()->id,
        'images' => [
            UploadedFile::fake()->image('product1.jpg'),
            UploadedFile::fake()->image('product2.jpg'),
            UploadedFile::fake()->image('product3.jpg'),
        ],
        'positions' => [
            'before',
            'after',
            'gallery',
        ],
    ];
});

test('user can view all paginated products list', function () {
    $response = $this->getJson('/api/products');

    $response->assertOk()
        ->assertJsonStructure([
            'message',
            'data' => [
                'products' => [
                    'data' => [
                        '*' => ['id', 'name', 'description', 'created_at', 'updated_at']
                    ]
                ]
            ]
        ]);
});

// test('user can view all deleted products (no pagination)', function () {
//     $this->product->delete();
//     // dd(Product::withTrashed()->find($this->product->id));
//     $response = $this->getJson('/api/products/trashed')->withHeaders([
//         'Authorization' => 'Bearer ' . $this->accessToken,
//     ]);

//     $response->assertOk()
//         ->assertJsonStructure([
//             'message',
//             'data' => [
//                 'products' => ['id', 'name', 'description', 'created_at', 'updated_at']
//             ]
//         ]);
// });


test('admin can create a product', function () {
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->accessToken,
    ])->postJson('/api/products', $this->data);

    $response->assertCreated()
        ->assertJsonStructure([
            'message',
            'data' => [
                'product' => ['id', 'name', 'description', 'created_at', 'updated_at']
            ]
        ]);
});


test('user can view specific product', function () {
    $response = $this->getJson("/api/products/{$this->product->id}");

    $response->assertOk()
        ->assertJsonStructure([
            'message',
            'data' => [
                'product' => ['id', 'name', 'description', 'created_at', 'updated_at']
            ]
        ]);
});

// test('user can view specific deleted product', function () {
//     // $this->product->delete();
//     $response = $this->getJson("/api/products/trashed/{$this->product->id}")->withHeaders([
//         'Authorization' => 'Bearer ' . $this->accessToken,
//     ]);

//     $response->assertOk()
//         ->assertJsonStructure([
//             'message',
//             'data' => [
//                 'product' => ['id', 'name', 'description', 'created_at', 'updated_at']
//             ]
//         ]);
// });


test('admin can update product', function () {
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->accessToken,
    ])->putJson("/api/products/{$this->product->id}", $this->data);

    $response->assertOk()
        ->assertJsonStructure([
            'message',
            'data' => [
                'product' => ['id', 'name', 'description', 'created_at', 'updated_at']
            ]
        ]);
});


test('admin can delete a product', function () {
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->accessToken,
    ])->deleteJson("/api/products/{$this->product->id}");

    $response->assertOk()
        ->assertJsonStructure([
            'message',
            'data' => [
                'product' => ['id', 'name', 'description', 'created_at', 'updated_at']
            ]
        ]);
});
