<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:create-super-admin';
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new admin';

    public function handle()
    {
        DB::beginTransaction();
        try {
            $name = $this->ask('Enter Name: ');
            $username = $this->ask('Enter Username: ');
            $phone = $this->ask('Enter Phone number: ');
            $email = $this->ask('Enter Email: ');
            $password = $this->secret('Enter Password: ');

            $user = User::firstOrCreate(
                [
                    'email' => $email,
                    'username' => $username,
                ],
                [
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role' => 1,
                    'phone' => $phone,
                ]
            );

            try {
                $user->sendEmailVerificationNotification();
            } catch (\Throwable $mailEx) {
                $this->error("Email verification failed: {$mailEx->getMessage()}");
            }

            DB::commit();

            $this->info("Super admin created successfully with email: {$user->email}");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Creation failed: {$e->getMessage()}");
        }
    }
}
