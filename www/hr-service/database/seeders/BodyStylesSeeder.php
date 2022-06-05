<?php

namespace Database\Seeders;

use App\Hr\Models\BodyStyle;
use Illuminate\Database\Seeder;

class BodyStylesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $styles = [
            'A Few Extra Pounds',
            'Athletic',
            'Average',
            'Big & Tall',
            'Curvy',
            'Slim',
            'Stallion Status',
        ];

        foreach ($styles as $style) {
            $stylesArray[] = ['name' => $style];
        }

        BodyStyle::insert($stylesArray);
    }
}
