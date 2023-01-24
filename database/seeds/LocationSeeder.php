<?php

use Illuminate\Database\Seeder;
use App\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Location::create(['id' => 1, 'value' => 'Worldwide']);
        Location::create(['id' => 23424738, 'value' => 'UAE']);
    }
}
