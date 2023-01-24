<?php

use Illuminate\Database\Seeder;
use Rap2hpoutre\FastExcel\Facades\FastExcel;
use App\Country;


class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FastExcel::import(base_path('database/seeds/sql/countries.xlsx'), function ($line) {
            return Country::create([
                'country_name' => $line['country_name'],
                'city' => $line['city'],
                'longitude' => $line['longitude'],
                'latitude' => $line['latitude'],
                'country_code2' => $line['country_code2'],
                'country_code3' => $line['country_code3'],
                'capital' => $line['capital']
            ]);
        });
    }
}
