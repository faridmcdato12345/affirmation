<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $premiumCategories = [
            [
            'id' => 1,
            'text' => 'Intro Month',
            'blurb' => 'Your Free Month of Affirmations. You can repeat this month as many times as you want.',
            'premium' => false,
            ],
            [
            'id' => 2,
            'text' => 'Hope and Grounding',
            'blurb' => 'Affirmations of hope and grounding can help you maintain a positive outlook.'
            ],
            [
            'id' => 3,
            'text' => 'Happiness and Positivity',
            'blurb' => 'Saying affirmations of happiness and positivity every day can bring you more joy.'
            ],
            [
            'id' => 4,
            'text' => 'Body Positivity and Health',
            'blurb' => 'Affirmations of body positivity and health can help to improve your physical appearance and well-being.'
            ],
            [
            'id' => 5,
            'text' => 'Confidence and Self Esteem',
            'blurb' => 'Let go of any negative thoughts about yourself and fill your mind with positive affirmations of confidence and self-esteem.'
            ],
            [
            'id' => 6,
            'text' => 'Parenting',
            'blurb' => 'The practice of affirmations can help cultivate positive belief systems about parenting.'
            ],
            [
            'id' => 7,
            'text' => 'Prosperity and Abundance',
            'blurb' => 'Making affirmations of prosperity and abundance a daily habit will help you reach your goals.'
            ],
            [
            'id' => 8,
            'text' => 'Strength and Wisdom',
            'blurb' => 'Affirmations of Strength and Wisdom will empower you to become the best that you can be.'
            ],
            [
            'id' => 9,
            'text' => 'Love and Relationships',
            'blurb' => 'Affirmations of love and relationships can lead to a more positive outlook on life.'
            ],
            // [
            // 'id' => 10,
            // 'text' => 'Quotes',
            // 'blurb' => 'Select quotes to help you feel at peace.'
            // ],
        ];

        foreach($premiumCategories as $cat) {
            try {
                DB::table('categories')->insert($cat);
            } catch(\Exception $e) {
                echo $e . "\n";
            }
        }
    }
}
