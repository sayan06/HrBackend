<?php

namespace Database\Seeders;

use App\Hr\Models\ConsumptionType;
use Illuminate\Database\Seeder;

class AlcoholConsumptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'No',
            'Socially',
            'A Few Times A Week',
            'Prefer Not To Say',
        ];

        foreach ($statuses as $status) {
            $statusesArray[] = ['name' => $status];
        }

        ConsumptionType::insert($statusesArray);
    }
}
