<?php

use Illuminate\Database\Seeder;
use App\Site;
Use App\Departments;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sites = [[
            'company_name' => 'Oliver Wyman Media Releases',
            'company_url' => 'https://www.oliverwyman.com/media-center.html',
            'crawl_interval' => 60,
            'crawl_depth' => 3,
            'site_color' => '#e643de',
            'site_type' => 'normal',
            'selector' => 'tag',
            'selector_value' => 'article__section'
        ],[
            'company_name' => 'Oliver Wyman Insights',
            'company_url' => 'https://www.oliverwyman.com/our-expertise/insights.html',
            'crawl_interval' => 60,
            'crawl_depth' => 3,
            'site_color' => '#e899db',
            'site_type' => 'normal',
            'selector' => 'class',
            'selector_value' => 'page'
        ],[
            'company_name' => 'Brain',
            'company_url' => 'https://www.bain.com/insights/',
            'crawl_interval' => 60,
            'crawl_depth' => 3,
            'site_color' => '#68b6f7',
            'site_type' => 'normal',
            'selector' => 'class',
            'selector_value' => 'row column'
        ],[
            'company_name' => 'Cognizant Blog',
            'company_url' => 'https://digitally.cognizant.com/',
            'crawl_interval' => 60,
            'crawl_depth' => 3,
            'site_color' => '#9bebb6',
            'site_type' => 'normal',
            'selector' => 'class',
            'selector_value' => 'container site-content'
        ],[
            'company_name' => 'Capgemini',
            'company_url' => 'https://www.capgemini.com/',
            'crawl_interval' => 30,
            'crawl_depth' => 3,
            'site_color' => '#55e6cb',
            'site_type' => 'normal',
            'selector' => 'class',
            'selector_value' => 'article-text'
        ]];

        foreach($sites as $value){
            $site = Site::create($value);

            $department_id = Departments::all()->pluck("id")->toArray();
            $site->departments()->attach($department_id);

            $send_data = [
                'url' => $value['company_url'],
                'name' => $value['company_name'],
                'site_color' => $value['site_color'],
                'site_type' => $value['site_type'],
                'interval' => $value['crawl_interval'],
                'depth' => $value['crawl_depth'],
                'site_selector' => $value['selector'],
                'selector_value' => $value['selector_value'],
            ];

            $external_dept = Departments::all()->pluck("external_id")->toArray();
            $send_data['categories'] = array_map(function($value) {
                return ['category_id' => $value];
            }, $external_dept);

            $client = new \GuzzleHttp\Client();
            $response = $client->post(
                Config::get('scma.url').'sites',
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $send_data
                ]
            );
            $body = $response->getBody();
            $response_json = json_decode((string) $body);

            if($response->getStatusCode() == 200){
                $site->external_id = $response_json->data->id;
                $site->save();
            }
        }
    }
}
