<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Role $roles) {

        $roles_array = ['Admin', 'User'];

        foreach ($roles_array as $role) {

            $roles->create([
                'name' => $role,
                'role_key' => strtolower($role)
            ]);
        }
    }

}
