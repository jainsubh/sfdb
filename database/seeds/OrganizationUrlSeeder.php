<?php

use Illuminate\Database\Seeder;
Use App\OrganizationUrl;

class OrganizationUrlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrganizationUrl::create(['name' => 'Accenture', 'url' => 'https://www.accenture.com/us-en/']);
        OrganizationUrl::create(['name' => 'UN HDR', 'url' => 'http://www.hdr.undp.org/']);
    }
}
