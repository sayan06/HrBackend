<?php

namespace Database\Seeders;

use App\Hr\Models\Flavour;
use Illuminate\Database\Seeder;

class FlavoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $flavours = [
            'Mainstream',
            'Hook-Ups',
            'BBW/BHM',
            'Wealthy Singles',
            'Bi-Sexual - Bi-Curious',
            'Alternative',
            'Ethnic Dating',
            'Swings',
        ];

        foreach ($flavours as $flavour) {
            $flavoursArray[] = ['flavour' => $flavour];
        }

        Flavour::insert($flavoursArray);
    }
}
