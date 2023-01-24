<?php

use Illuminate\Database\Seeder;
use App\Event;
use App\Sectors;
Use App\Departments;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $events = [[
            'name' => 'Covid-19 Pandemic Impact On Business',
            'keywords' => 'covid,corona,coronavirus,virus,pandemic',
            'sector_id' => Sectors::all()->random()->id,
            'match_condition' => '(^covid^ or ^corona^) and (^virus^ or ^pandemic^)'
        ],[
            'name' => 'AI Tracking for Financial Fraud',
            'keywords' => 'AI,artificialintelligence,intelligence,artificial',
            'sector_id' => Sectors::all()->random()->id,
            'match_condition' => '(^covid^ or ^corona^) and (^virus^ or ^pandemic^)'
        ]];


        foreach($events as $value){
            
            $event = Event::create($value);
            $department_id = Departments::all()->pluck("id")->toArray();
            $event->departments()->attach($department_id);

            $send_data = [
                'name' => $value['name'],
                'match_condition' => $value['match_condition'],
                'search_type' => 'and',
                'crawl_type' => 1
                
            ];

            $external_dept = Departments::all()->pluck("external_id")->toArray();
            $send_data['categories'] = array_map(function($value) {
                return ['category_id' => $value];
            }, $external_dept);

            $client = new \GuzzleHttp\Client();
            $response = $client->post(
                config('scma.url').'events',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $send_data,
                ]
            );
            $body = $response->getBody();
            $response_json = json_decode((string) $body);

            if($response->getStatusCode() == 200){
                $event->external_id = $response_json->data->id;
                $event->save();
            }
        }
    }
}
