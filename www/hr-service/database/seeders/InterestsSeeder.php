<?php

namespace Database\Seeders;

use App\Hr\Models\Interest;
use Illuminate\Database\Seeder;

class InterestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $interests = [
            'Movies',
            'Design',
            'Technology',
            'Music',
            'Athlete',
            'Gaming',
            'Swimming',
            'Shopping',
            'Cooking',
            'Art',
            'Photography',
            'Book Read',
        ];

        foreach ($interests as $interest) {
            $interestsArray[] = ['name' => $interest];
        }

        Interest::insert($interestsArray);
    }
}
