<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AlcoholConsumptionsSeeder::class,
            AstrologicalSignsSeeder::class,
            BodyStylesSeeder::class,
            DegreesSeeder::class,
            EthnicitiesSeeder::class,
            IdealMatchesSeeder::class,
            InterestsSeeder::class,
            QuestionsSeeder::class,
            KidsTypeRequirementsSeeder::class,
            EyeColorsSeeder::class,
            HairColorsSeeder::class,
            LanguagesSeeder::class,
            MaritalStatusesSeeder::class,
            PersonalitiesSeeder::class,
            FlavoursSeeder::class,
            ReligionsSeeder::class,
            RolesAndPermissionsSeeder::class,
            UserPostVisibilitiesSeeder::class,
            UsersSeeder::class,
        ]);
    }
}
