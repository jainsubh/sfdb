<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;
use App\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Seed the default permissions
        //$this->command->call('migrate:refresh --path=../database/migrations/2020_08_09_190718_create_permission_tables.php');
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms]);
        }

        $this->command->info('Default Permissions added.');

        // Confirm roles needed
        if ($this->command->confirm('Create Roles for user, default is admin and user? [y|n]', true)) {

            // Ask for roles from input
            $input_roles = 'Admin,Manager,Analyst';
            // Explode roles
            $roles_array = explode(',', $input_roles);

            // add roles
            foreach($roles_array as $role) {
                $role = Role::firstOrCreate(['name' => trim($role)]);

                if( $role->name == 'Admin' ) {
                    // assign all permissions
                    $role->syncPermissions(Permission::all());
                    $this->command->info('Admin granted all the permissions');
                } else if( $role->name == 'Manager' ) {
                    $manager_permissions = File::get("database/data/manager_permission.json");
                    $permisson_allow = json_decode($manager_permissions, true);
                    $role->syncPermissions($permisson_allow);
                } else if( $role->name == 'Analyst' ) {
                    $analyst_permissions = File::get("database/data/analyst_permission.json");
                    $permisson_allow = json_decode($analyst_permissions, true);
                    $role->syncPermissions($permisson_allow);
                }
            }

            $this->command->info('Roles ' . $input_roles . ' added successfully');
        }else {
            Role::firstOrCreate(['name' => 'User']);
            $this->command->info('Added only default user role.');
        }
    }
}
