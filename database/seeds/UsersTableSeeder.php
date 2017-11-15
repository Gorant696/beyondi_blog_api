<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(User $user, Role $roles) {

        $admin = $user->create([
            'name' => 'BlogAdmin',
            'email' => 'blogadmin@gmail.com',
            'password' => app('hash')->make('password'),
        ]);

        $roleid = $roles->where('role_key', User::ROLE_ADMIN)->first();
        $admin->roles()->attach($roleid->id);
    }

}
