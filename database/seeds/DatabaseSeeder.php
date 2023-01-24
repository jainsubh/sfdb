<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');
        // Ask for db migration refresh, default is no
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            // Call the php artisan migrate:refresh
            $this->command->call('migrate:refresh');
            //$this->command->call('migrate:refresh --path=/database/migrations/2014_10_12_000000_create_users_table.php');
            $this->command->warn("Data cleared, starting from blank database.");
        }

        $this->call([

            // Default Seeder files always require in installing new project
            
            PermissionSeeder::class,
            SuperVisorSeeder::class,
            UserSeeder::class,
            LocationSeeder::class,
            CountrySeeder::class,
            TimezoneSeeder::class,
            ReportTemplateSeeder::class,

            // Other Dummy Data files may or may not require for installing new project
            /*DepartmentSeeder::class,
            SectorSeeder::class,
            SiteSeeder::class,
            OrganizationUrlSeeder::class,
            InstitutionReportSeeder::class,
            EventSeeder::class,
            AlertSeeder::class,*/
        ]);
        
    }
}
