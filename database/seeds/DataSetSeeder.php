<?php

use Illuminate\Database\Seeder;
use App\Dataset;

class DataSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dataset::create(['name' => 'Strategic Directions']);
        Dataset::create(['name' => 'Future Priorities']);
        Dataset::create(['name' => 'Future Challenges']);
        Dataset::create(['name' => 'Security Sectors']);
    }
}
