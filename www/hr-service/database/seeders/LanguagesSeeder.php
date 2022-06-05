<?php

namespace Database\Seeders;

use App\Hr\Models\Language;
use Illuminate\Database\Seeder;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            'English',
            'French',
            'Chinese',
            'Dutch',
            'Arabic',
            'German',
            'Hebrew',
        ];

        foreach ($languages as $language) {
            $languagesArray[] = ['name' => $language];
        }

        Language::insert($languagesArray);
    }
}
