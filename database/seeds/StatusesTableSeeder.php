<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
       public function run(Status $status) {

        $status_array = ['Published', 'Unpublished', 'Draft'];

        foreach ($status_array as $state) {

            $status->create([
                'name' => $state,
                'status_key' => strtolower($state)
            ]);
        }
    }
}
