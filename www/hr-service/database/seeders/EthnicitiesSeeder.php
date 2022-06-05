<?php

namespace Database\Seeders;

use App\Hr\Models\Ethnicity;
use Illuminate\Database\Seeder;

class EthnicitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ethnicities = [
            'Asian',
            'Black',
            'White',
            'Latin',
            'Middle Eastern',
            'German',
            'Hebrew',
        ];

        foreach ($ethnicities as $ethnicity) {
            $ethnicitiesArray[] = ['name' => $ethnicity];
        }

        Ethnicity::insert($ethnicitiesArray);
    }
}
