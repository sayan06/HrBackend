<?php

namespace Database\Seeders;

use App\Hr\Models\IdealMatch;
use Illuminate\Database\Seeder;

class IdealMatchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $matches = [
            'Friendship',
            'Dating',
            'Serious Commitment',
            'Marriage',
            'Conversation',
            'Date Seriously',
            'Chat/meet new people',
            'Long-term',
            'Casual',
            'No Strings',
        ];

        foreach ($matches as $match) {
            $matchesArray[] = ['name' => $match];
        }

        IdealMatch::insert($matchesArray);
    }
}
