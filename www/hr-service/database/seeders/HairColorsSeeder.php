<?php

namespace Database\Seeders;

use App\Hr\Models\HairColor;
use Illuminate\Database\Seeder;

class HairColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = [
            'Black',
            'Blonde',
            'Brown',
            'Brunette',
            'Gray',
            'Red',
        ];

        foreach ($colors as $color) {
            $colorsArray[] = ['name' => $color];
        }

        HairColor::insert($colorsArray);
    }
}
