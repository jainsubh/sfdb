<?php

use Illuminate\Database\Seeder;
use App\Sectors;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sectors::create(['name' => 'Agriculture']);
        Sectors::create(['name' => 'Chemical']);
        Sectors::create(['name' => 'Construction']);
        Sectors::create(['name' => 'Education']);
        Sectors::create(['name' => 'Food Manufacturing and Processing']);
        Sectors::create(['name' => 'Financial Services']);
        Sectors::create(['name' => 'Health Services']);
        Sectors::create(['name' => 'Hospitality and Tourism']);
        Sectors::create(['name' => 'Information Technology']);
        Sectors::create(['name' => 'Industrial manufacturing']);
        Sectors::create(['name' => 'Media and Digital Sector']);
        Sectors::create(['name' => 'Public Sector Services']);
        Sectors::create(['name' => 'Retail and Commerce']);
        Sectors::create(['name' => 'Transportation']);
        Sectors::create(['name' => 'Utility Sector']);
    }
}
