<?php

namespace Database\Seeders;

use App\Hr\Models\Ball;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BallsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('balls')->truncate();

        $faker = Faker::create();

        $ballCapacities = [
            [
                'name' => 'Pink',
                'volume' => 2.25,
            ],
            [
                'name' => 'Red',
                'volume' => 2.00,
            ],
            [
                'name' => 'Blue',
                'volume' => 1.00,
            ],
            [
                'name' => 'Orange',
                'volume' => 0.8,
            ],
            [
                'name' => 'Green',
                'volume' => 0.5,
            ],
        ];

        foreach ($ballCapacities as $ballCapacity) {
            Ball::create($ballCapacity);
        }
    }
}
