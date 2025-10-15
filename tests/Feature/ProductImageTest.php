<?php

use App\Enums\ProductImagePositionEnum;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->data = [
        'images' => [
            UploadedFile::fake()->image('product1.jpg'),
            UploadedFile::fake()->image('product2.jpg'),
            UploadedFile::fake()->image('product3.jpg'),
            UploadedFile::fake()->image('product4.jpg'),
            UploadedFile::fake()->image('product5.jpg'),
        ],
        'positions' => [
            'gallery',
            'gallery',
            'after',
            'gallery',
            'before',
        ],
        // 'image' => UploadedFile::fake()->image('product.jpg'),
        // 'position' => fake()->randomElement(ProductImagePositionEnum::values())
    ];
    $this->product->images()->createMany([
        ['image' => 'fake1.jpg', 'position' => 'gallery'],
        ['image' => 'fake2.jpg', 'position' => 'gallery'],
        ['image' => 'fake3.jpg', 'position' => 'gallery'],
        ['image' => 'fake4.jpg', 'position' => 'before'],
        ['image' => 'fake5.jpg', 'position' => 'after'],
    ]);

    $this->product->load('images', 'gallery', 'beforeImage', 'afterImage');
    // dd($this->product->load([
    //     // 'images',
    //     'beforeImage',
    //     'afterImage',
    //     'gallery',
    // ]));
});

test('user can view all product images (no pagination)', function () {
    $response = $this->getJson("/api/products/{$this->product->id}/images");

    $response->assertOk()
        ->assertJsonStructure([
            'message',
            'data' => [
                'images' => [
                    '*' => ['id', 'image', 'position', 'created_at', 'updated_at']
                ]
            ]
        ]);
});


test('admin can create a product image', function () {
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->accessToken,
    ])->postJson("/api/products/{$this->product->id}/images", $this->data);

    $response->assertCreated()
        ->assertJsonStructure([
            'message',
            'data' => [
                'images' => [
                    '*' => ['id', 'image', 'position', 'created_at', 'updated_at']
                ]
            ]
        ]);
});


test('user can view specific product image', function () {
    $image_id = $this->product->images->first()->id;
    $response = $this->getJson("/api/products/{$this->product->id}/images/{$image_id}");

    $response->assertOk()
        ->assertJsonStructure([
            'message',
            'data' => [
                'image' => ['id', 'image', 'position', 'created_at', 'updated_at']
            ]
        ]);
});


test('admin can update product image', function () {
    $image_id = $this->product->gallery->first()->id;
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->accessToken,
    ])->putJson("/api/products/{$this->product->id}/images/{$image_id}", $this->data);

    $response->assertOk()
        ->assertJsonStructure([
            'message',
            'data' => [
                'image' => ['id', 'image', 'position', 'created_at', 'updated_at']
            ]
        ]);
});


test('admin can delete a product image', function () {
    $image_id = $this->product->gallery->first()->id;
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->accessToken,
    ])->deleteJson("/api/products/{$this->product->id}/images/{$image_id}");

    $response->assertOk()
        ->assertJsonStructure([
            'message',
            'data' => [
                'image' => ['id', 'image', 'position', 'created_at', 'updated_at']
            ]
        ]);
});

test('admin can delete a all images in specific product', function () {
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->accessToken,
    ])->deleteJson("/api/products/{$this->product->id}/images");

    $response->assertOk()
        ->assertJsonStructure([
            'message',
            'data' => [
                'images' => [
                    '*' => ['id', 'image', 'position', 'created_at', 'updated_at']
                ]
            ]
        ]);
});
