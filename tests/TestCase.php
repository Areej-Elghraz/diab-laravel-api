<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    public $admin, $remember = false, $accessToken, $rememberToken, $loginResponse, $data;

    protected function SetUp(): void
    {
        parent::SetUp();
        $this->remember = true;
        $this->admin    = User::factory()->create([
            'name'              => 'Admin',
            'username'          => 'ayadiab123',
            'email'             => 'areejelghrazzz@gmail.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('ayadiab'),
            'role'              => 'admin',
        ]);

        $this->loginResponse = $this->postJson('/api/login', [
            // 'input'    => $this->admin->admin-name,
            'input'    => $this->admin->email,
            'password' => 'ayadiab',
            'remember' => $this->remember,
        ]);

        $this->loginResponse->assertOk()
            ->assertJsonStructure([
                'message',
                'data' => [
                    'user' => ['id', 'name', 'username', 'email'],
                    'access_token',
                    'remember_token',
                ],
            ]);
        $this->accessToken   = $this->loginResponse->json('data.access_token');
        $this->rememberToken = $this->loginResponse->json('data.remember_token');

        $models = [
            ['Category', 'categories'],
            ['Product', null, ['images', 'gallery', 'beforeImage', 'afterImage']],
            ['ProductImage'],
            ['SocialLink'],
            ['Banner'],
            ['PhoneNumber'],
        ];
        foreach ($models as $model) {
            $modelVars = lcfirst($model[1] ?? $model[0] . 's');
            $modelVar = lcfirst($model[0]);
            $modelClass = "App\\Models\\{$model[0]}";
            $this->$modelVars = $modelClass::factory()->count(3)->create();
            $this->$modelVar  = $this->$modelVars->first()->load($model[2] ?? []);
        }
    }
}
