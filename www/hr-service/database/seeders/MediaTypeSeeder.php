<?php

namespace Database\Seeders;

use App\Hr\Models\MediaType;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MediaTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('media_types')->truncate();

        $faker = Faker::create();

        for ($i = 0; $i < 4; $i++) {
            MediaType::create([
                'name' => $faker->word,
                'description' => $faker->sentence(),
            ]);
        }
    }
}
