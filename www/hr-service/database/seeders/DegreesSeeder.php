<?php

namespace Database\Seeders;

use App\Hr\Models\Degree;
use Illuminate\Database\Seeder;

class DegreesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $degrees = [
            'Bachelors',
            'Masters',
            'Graduates',
            'Degree',
            'PHD',
            'Some College',
            'No College',
        ];

        foreach ($degrees as $degree) {
            $degreesArray[] = ['name' => $degree];
        }

        Degree::insert($degreesArray);
    }
}
