<?php

use Illuminate\Support\Facades\Hash;

test('user can view their profile', function () {
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->accessToken,
    ])->getJson('/api/profile');

    $response->assertOk()
        ->assertJsonStructure([
            'message',
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'username',
                    'email',
                    'created_at',
                    'updated_at'
                ],
            ],
        ]);
});

test('user can update profile data', function () {
    $data = [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->accessToken,
    ])->putJson('/api/profile', $data);

    $response->assertOk()
        ->assertJsonFragment(['name' => 'Updated Name'])
        ->assertJsonStructure([
            'message',
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'username',
                    'email',
                    'updated_at',
                ],
            ],
        ]);
});

test('user can update password successfully', function () {
    $data = [
        'current_password' => 'ayadiab',
        'new_password' => 'newPassword456',
        'new_password_confirmation' => 'newPassword456',
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->accessToken,
    ])->putJson('/api/profile/password', $data);

    $response->assertOk()
        ->assertJsonStructure([
            'message',
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'username',
                    'email',
                    'updated_at',
                ],
            ],
        ]);

    $this->assertTrue(Hash::check('newPassword456', $this->admin->fresh()->password));
});

test('cannot update password with wrong current password', function () {
    $data = [
        'current_password' => 'wrongOldPass',
        'new_password' => 'newPassword456',
        'new_password_confirmation' => 'newPassword456',
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->accessToken,
    ])->putJson('/api/profile/password', $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['current_password']);
});

test('cannot update password if new password equals current one', function () {
    $data = [
        'current_password' => 'ayadiab',
        'new_password' => 'ayadiab',
        'new_password_confirmation' => 'ayadiab',
    ];

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->accessToken,
    ])->putJson('/api/profile/password', $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['new_password']);
});
