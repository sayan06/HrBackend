<?php

namespace Database\Seeders;

use App\Hr\Models\UserPostVisibility;
use Illuminate\Database\Seeder;

class UserPostVisibilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserPostVisibility::insert([
            [
                'name' => 'Public',
                'description' => 'Public Posts'
            ],
            [
                'name' => 'Private',
                'description' => 'Private Posts'
            ]
        ]);
    }
}
