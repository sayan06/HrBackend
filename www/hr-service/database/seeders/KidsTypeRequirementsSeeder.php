<?php

namespace Database\Seeders;

use App\Hr\Models\KidRequirementType;
use Illuminate\Database\Seeder;

class KidsTypeRequirementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Definitely',
            'One Day',
            'Nope',
        ];

        foreach ($types as $type) {
            $typesArray[] = ['name' => $type];
        }

        KidRequirementType::insert($typesArray);
    }
}
