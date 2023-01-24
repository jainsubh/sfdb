<?php

use Illuminate\Database\Seeder;
Use App\ReportTemplate;

class ReportTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReportTemplate::create(['name' => 'Automatic', 'type' => 'automatic']);
        ReportTemplate::create(['name' => 'Semi Automatic', 'type' => 'semi_automatic']);
        ReportTemplate::create(['name' => 'Fully Manual', 'type' => 'manual']);
        ReportTemplate::create(['name' => 'FreeForm Report', 'type' => 'freeform_report']);
        ReportTemplate::create(['name' => 'Product Report', 'type' => 'product']);
    }
}
