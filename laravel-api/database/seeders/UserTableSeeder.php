<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'name' => 'nahid ferdous',
            'username' => 'nahid123',
            'email' => 'nahid@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('nahid@gmail.com'),
        ]);
    }
}
