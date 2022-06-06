<?php

namespace Database\Seeders;

use App\Hr\Models\Question;
use Illuminate\Database\Seeder;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            'What makes you laugh?',
            'What makes you happy?',
            'What genre of music do you listen to?',
            'Perfect first date?',
            'What do you love about yourself?',
            'How would your friends describe you?',
            'What do you value most?',
            'How do you show affection?',
            'What does love look like to you?',
        ];

        foreach ($questions as $question) {
            $questionsArray[] = ['question' => $question];
        }

        Question::insert($questionsArray);
    }
}
