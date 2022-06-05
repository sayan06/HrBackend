<?php

namespace Database\Seeders;

use App\Hr\Models\AstrologicalSign;
use Illuminate\Database\Seeder;

class AstrologicalSignsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $signs = [
            'Aquarius',
            'Aries',
            'Cancer',
            'Capricorn',
            'Gemini',
            'Leo',
            'Libra',
            'Pisces',
            'Sagittarius',
            'Scorpio',
            'Taurus',
            'Virgo',
        ];

        foreach ($signs as $sign) {
            $signsArray[] = ['name' => $sign];
        }

        AstrologicalSign::insert($signsArray);
    }
}
