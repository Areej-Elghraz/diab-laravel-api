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
                    'email_verified_at' => now(),
                    'password' => Hash::make($password),
                    'role' => 1,
                ]
            );

            DB::commit();

            $this->info(__('messages.actions.created_success', ['resource' => __('messages.resources.admin.singular')]));
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error(__('messages.actions.error'));
        }
    }
}
