<?php

namespace Database\Seeders;

use App\Hr\Models\Religion;
use Illuminate\Database\Seeder;

class ReligionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $religions = [
            'Non Religious',
            'Baptist',
            'Christian',
            'Buddhist',
            'Catholic',
            'Jewish',
            'Hindu',
            'Muslim',
            'Mormon',
            'Methodist',
            'Presbyterian',
            'Other',
        ];

        foreach ($religions as $religion) {
            $religionsArray[] = ['name' => $religion];
        }

        Religion::insert($religionsArray);
    }
}
