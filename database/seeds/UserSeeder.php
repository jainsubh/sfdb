<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;
use App\User;

class UserSeeder extends Seeder
{
    public $live_password;
    public $local_password;
    public $timezone;
    public $local_timezone;

    public function __construct(){
        

        $this->local_password = Hash::make('admin@123');
        $this->admin_password = Hash::make('$F@dm1nu$3r');
        $this->manager_password = Hash::make('$F@manag3r');
        $this->analyst_password = Hash::make('$F@@na1y$t');
        $this->timezone = 'Asia/Dubai';
        $this->local_timezone = 'Asia/Kolkata';
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $admin = [[
            'name' => 'Sourabh Jain',
            'email' => 'jain.sourabh690@hotmail.com',
            'password' => $this->local_password,
            'phone_no' => '9815177107',
            'timezone' => $this->local_timezone,
            'email_verified_at' => Carbon\Carbon::now()
        ],[
            'name' => 'Super Admin',
            'email' => 'sfadmin@mgdsw.info',
            'password' => $this->admin_password,
            'timezone' => $this->timezone,
            'email_verified_at' => Carbon\Carbon::now()
        ]];

        foreach($admin as $value)
        {
            $admin = User::create($value);
            $admin->assignRole('Admin');
            $this->command->warn($admin->email);
        }
        
        $this->command->info('Administrator created successfully');

        $manager = [[
            'name' => 'Bhavika Jain',
            'email' => 'jain.bhavika32@gmail.com',
            'password' => $this->local_password,
            'phone_no' => '9855343329',
            'timezone' => $this->local_timezone,
            'email_verified_at' => Carbon\Carbon::now()
        ],[
            'name' => 'SF Manager',
            'email' => 'sfmanager@mgdsw.info',
            'password' => $this->manager_password, 
            'timezone' => $this->timezone,
            'email_verified_at' => Carbon\Carbon::now()
        ]];

        foreach($manager as $value)
        {
            $manager = User::create($value);
            $manager->assignRole('Manager');
            $this->command->warn($manager->email);
        }

        $this->command->info('Manager created successfully');

        $analyst = [[
            'name' => 'Keshav Jain',
            'email' => 'jain.keshav25@gmail.com',
            'password' => $this->local_password,
            'phone_no' => '9803125047',
            'timezone' => $this->local_timezone,
            'email_verified_at' => Carbon\Carbon::now()
        ],[
            'name' => 'Mohammed Khalid',
            'email' => 'sfanalyst1@mgdsw.info',
            'password' => $this->analyst_password,
            'timezone' => $this->timezone,
            'email_verified_at' => Carbon\Carbon::now()
        ],[
            'name' => 'Chris Jordan',
            'email' => 'sfanalyst2@mgdsw.info',
            'password' => $this->analyst_password,
            'timezone' => $this->timezone,
            'email_verified_at' => Carbon\Carbon::now()
        ],[
            'name' => 'Rajesh Kumar',
            'email' => 'sfanalyst3@mgdsw.info',
            'password' => $this->analyst_password,
            'timezone' => $this->timezone,
            'email_verified_at' => Carbon\Carbon::now()
        ]];
        foreach($analyst as $value)
        {
            $analyst = User::create($value);
            $analyst->assignRole('Analyst');
            $this->command->warn($analyst->email);
        }

        $this->command->info('Analyst created successfully');
    }
}