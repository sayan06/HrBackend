<?php

namespace Database\Seeders;

use App\Hr\Models\Bucket;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BucketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buckets')->truncate();

        $faker = Faker::create();

        $bucketCapacities = [
            [
                'name' => 'A',
                'volume' => 20,
            ],
            [
                'name' => 'B',
                'volume' => 18,
            ],
            [
                'name' => 'C',
                'volume' => 12,
            ],
            [
                'name' => 'D',
                'volume' => 10,
            ],
            [
                'name' => 'E',
                'volume' => 8,
            ],
        ];

        foreach ($bucketCapacities as $bucketCapacity) {
            Bucket::create($bucketCapacity);
        }
    }
}
