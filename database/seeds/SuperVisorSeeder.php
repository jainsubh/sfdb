<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;
use App\User;

class SuperVisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Confirm roles needed
        if ($this->command->confirm('Create Supervisor role? [y|n]', true)) {

            // Ask for roles from input
                $roleInput = 'Supervisor';
                $role = Role::firstOrCreate(['name' => trim($roleInput)]);

                if( $role->name == 'Supervisor' ) {
                $supervisor_permissions = File::get("database/data/supervisor_permission.json");
                $permisson_allow = json_decode($supervisor_permissions, true);
                $role->syncPermissions($permisson_allow);
            }

            $this->command->info('Roles ' . $roleInput . ' added successfully');
        }else {
            Role::firstOrCreate(['name' => 'User']);
            $this->command->info('Added only default user role.');
        }
    }
}
