<?php

use Illuminate\Database\Seeder;
Use App\InstitutionReport;

class InstitutionReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InstitutionReport::create(['name' => 'Covid-19-Adaptive Security', 'institute_id' => 1, 'date_time' => Carbon\Carbon::now(),'institution_report'=>'INSR-817561-1600577922']);
        InstitutionReport::create(['name' => 'Human Development Report 2019', 'institute_id' => 2, 'date_time' => Carbon\Carbon::now(),'institution_report'=>'INSR-842231-1600596443']);
    }
}
