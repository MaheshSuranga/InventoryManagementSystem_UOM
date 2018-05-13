<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $to = Role::create([
            'name' => 'TO',
            'permissions' => json_encode([
                'login-system' => true,
                'register-user' => true,
                'create-inventory' => true,
                'update-inventory' => true,
                'delete-inventory' => true,
                'issue-inventory' => true,
                'update-lecturer' => true,
                'delete-lecturer' => true,
                'update-supervisor' => true,
                'delete-supervisor' => true
            ])
        ]);

        $lecturer = Role::create([
            'name' => 'Lecturer',
            'permissions' => json_encode([
                'login-system' => true,
                'approve-request' => true,
            ])
        ]);

        $supervisor = Role::create([
            'name' => 'Supervisor',
            'permissions' => json_encode([
                'login-system' => true,
                'approve-request' => true,
            ])
        ]);

        $student = Role::create([
            'name' => 'Student',
            'permissions' => json_encode([
            ])
        ]);
    }
}
