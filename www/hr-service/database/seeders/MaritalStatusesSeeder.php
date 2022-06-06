<?php

namespace Database\Seeders;

use App\Hr\Models\MaritalStatus;
use Illuminate\Database\Seeder;

class MaritalStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'Single',
            'Married',
            'Divorced',
            'Separated',
            'Longest Relationship',
        ];

        foreach ($statuses as $status) {
            $statusesArray[] = ['name' => $status];
        }

        MaritalStatus::insert($statusesArray);
    }
}
