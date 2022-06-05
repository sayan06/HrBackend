<?php

namespace Database\Seeders;

use App\Hr\Models\Personality;
use Illuminate\Database\Seeder;

class PersonalitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $traits = [
            'Rockstar',
            'Yuppy',
            'Techie',
            'Fashion Concession',
            'Tattooed/Pierced',
            'Professional',
            'Vagan',
            'Princess',
            'Nomad',
            'Intellectual',
            'Hippie',
            'Gamer',
            'Geek',
            'Free Thinker',
            'Diva',
            'Crafty',
            'Athletic',
            'Blue Caller',
            'Artsy',
            'Adventurous',
            'Pet Lovers',
            'Daredevil',
            'Foodie',
            'Hipster',
            'Movie/T.V.',
            'Junkie',
            'Homebody',
            'Music Lover',
            'Introvert',
            'Vegetarian',
            'Flexitarians',
        ];

        foreach ($traits as $trait) {
            $traitsArray[] = ['name' => $trait];
        }

        Personality::insert($traitsArray);
    }
}
