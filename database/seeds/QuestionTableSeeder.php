<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
          [
            "id" => uniqid('Q-'),
            "title" => Str::random(20),
            "content" => Str::random(100)
          ],
          [
            "id" => uniqid('Q-'),
            "title" => Str::random(20),
            "content" => Str::random(100)
          ],
          [
            "id" => uniqid('Q-'),
            "title" => Str::random(20),
            "content" => Str::random(100)
          ]
        ]);
    }
}
