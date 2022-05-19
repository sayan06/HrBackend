<?php

namespace Database\Seeders;

use App\Hr\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        $faker = Faker::create();

        $superAdmins = [
            [
                'name' => 'Super Admin',
                'email' => 'contact@ncrts.com',
                'email_verified_at' => now()->timestamp,
                'password' => Hash::make(env('HR_ADMIN_PASS')),
                'remember_token' => Str::random(10),
                'title' => 'Super Admin',
                'phone' => $faker->phoneNumber,
            ],
        ];

        foreach ($superAdmins as $superAdmin) {
            User::create($superAdmin);
        }
    }
}
