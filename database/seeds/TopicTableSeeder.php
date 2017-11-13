<?php

use Illuminate\Database\Seeder;
use App\Topics;
use App\Subtopics;

class TopicTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Topics $topics, Subtopics $subtopics) {

        $topic_array = [
            'Sport' => ['Football', 'Basketball', 'Handball'],
            'Multimedia' => ['Games', 'Videos', 'Music'],
            'Various' => ['Computers', 'History', 'Travelling']
        ];


        foreach ($topic_array as $key => $value_array) {

            $topics->create([
                'name' => $key,
                'topic_key' => strtolower($key)
            ]);

            $topic_key=$topics->where('topic_key', $key)->first();

            foreach ($value_array as $value) {

                $subtopics->create([
                    'topic_id' => $topic_key->id,
                    'name' => $value,
                    'subtopic_key' => strtolower($value)
                ]);
            }
        }
    }

}
