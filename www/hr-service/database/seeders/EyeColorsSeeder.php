<?php

namespace Database\Seeders;

use App\Hr\Models\EyeColor;
use Illuminate\Database\Seeder;

class EyeColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
            'Blue',
            'Green',
            'Brown',
            'Gray',
            'Hazel',
            'Others',
        ];

        foreach ($colors as $color) {
            $colorsArray[] = ['name' => $color];
        }

        EyeColor::insert($colorsArray);
    }
}
