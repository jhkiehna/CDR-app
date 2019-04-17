<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'email' => config('database.initial-user-email'),
            'password' => Hash::make(config('database.initial-user-password')),
            'root' => true,
        ]);
    }
}
