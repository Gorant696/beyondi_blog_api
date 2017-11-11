<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(User $user)
    {
        //@TODO PROVJERIT RADI LI
        $items = [
            [
                'name' => str_random(10),
                'email' => str_random(10).'@gmail.com',
                'password' => app('hash')->make('secret'),
            ],

            [
                'name' => str_random(10),
                'email' => str_random(10).'@gmail.com',
                'password' => app('hash')->make('secret'),
            ]
        ];

        foreach ($items as $item) {
            $user->create($item);
        }
    }
}
