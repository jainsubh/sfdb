<?php

use Illuminate\Database\Seeder;
use App\Departments;

class DepartmentSeeder extends Seeder
{
    public $scma_url;
    public $default_header;

    public function __construct(){
        $this->scma_url = Config::get('scma.url');
        $this->default_header = [
            'Content-Type' => 'application/json',
        ];
    }
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department = Departments::create(['name' => 'Fire Control Management']);

        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            $this->scma_url.'categories',
            [
                'headers' => $this->default_header,
                'json' => ['name' => 'Fire Control Management'],
            ]
        );
        $response_body = $response->getBody();
        $response_arr = json_decode((string) $response_body);

        if($response->getStatusCode() == 200){
            $department->external_id = $response_arr->data->id;
            $department->save();
            
        }

        $department = Departments::create(['name' => 'Emergency Services']);

        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            $this->scma_url.'categories',
            [
                'headers' => $this->default_header,
                'json' => ['name' => 'Emergency Services'],
            ]
        );
        $response_body = $response->getBody();
        $response_arr = json_decode((string) $response_body);

        if($response->getStatusCode() == 200){
            $department->external_id = $response_arr->data->id;
            $department->save();
            
        }

        $department = Departments::create(['name' => 'Finance']);

        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            $this->scma_url.'categories',
            [
                'headers' => $this->default_header,
                'json' => ['name' => 'Finance'],
            ]
        );
        $response_body = $response->getBody();
        $response_arr = json_decode((string) $response_body);

        if($response->getStatusCode() == 200){
            $department->external_id = $response_arr->data->id;
            $department->save();
            
        }

        $department = Departments::create(['name' => 'Planning and Community Development']);

        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            $this->scma_url.'categories',
            [
                'headers' => $this->default_header,
                'json' => ['name' => 'Planning and Community Development'],
            ]
        );
        $response_body = $response->getBody();
        $response_arr = json_decode((string) $response_body);

        if($response->getStatusCode() == 200){
            $department->external_id = $response_arr->data->id;
            $department->save();
            
        }

        $department = Departments::create(['name' => 'Public Works Department']);

        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            $this->scma_url.'categories',
            [
                'headers' => $this->default_header,
                'json' => ['name' => 'Public Works Department'],
            ]
        );
        $response_body = $response->getBody();
        $response_arr = json_decode((string) $response_body);

        if($response->getStatusCode() == 200){
            $department->external_id = $response_arr->data->id;
            $department->save();
            
        }

        $department = Departments::create(['name' => 'Human Resources']);

        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            $this->scma_url.'categories',
            [
                'headers' => $this->default_header,
                'json' => ['name' => 'Human Resources'],
            ]
        );
        $response_body = $response->getBody();
        $response_arr = json_decode((string) $response_body);

        if($response->getStatusCode() == 200){
            $department->external_id = $response_arr->data->id;
            $department->save();
            
        }

        $department = Departments::create(['name' => 'Technology']);

        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            $this->scma_url.'categories',
            [
                'headers' => $this->default_header,
                'json' => ['name' => 'Technology'],
            ]
        );
        $response_body = $response->getBody();
        $response_arr = json_decode((string) $response_body);

        if($response->getStatusCode() == 200){
            $department->external_id = $response_arr->data->id;
            $department->save();
            
        }

        $department = Departments::create(['name' => 'Health']);

        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            $this->scma_url.'categories',
            [
                'headers' => $this->default_header,
                'json' => ['name' => 'Health'],
            ]
        );
        $response_body = $response->getBody();
        $response_arr = json_decode((string) $response_body);

        if($response->getStatusCode() == 200){
            $department->external_id = $response_arr->data->id;
            $department->save();
            
        }

        $department = Departments::create(['name' => 'Broadcasting']);

        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            $this->scma_url.'categories',
            [
                'headers' => $this->default_header,
                'json' => ['name' => 'Broadcasting'],
            ]
        );
        $response_body = $response->getBody();
        $response_arr = json_decode((string) $response_body);

        if($response->getStatusCode() == 200){
            $department->external_id = $response_arr->data->id;
            $department->save();
            
        }

        $department = Departments::create(['name' => 'Sports']);

        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            $this->scma_url.'categories',
            [
                'headers' => $this->default_header,
                'json' => ['name' => 'Sports'],
            ]
        );
        $response_body = $response->getBody();
        $response_arr = json_decode((string) $response_body);

        if($response->getStatusCode() == 200){
            $department->external_id = $response_arr->data->id;
            $department->save();
            
        }

        $department = Departments::create(['name' => 'Telecommunications']);

        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            $this->scma_url.'categories',
            [
                'headers' => $this->default_header,
                'json' => ['name' => 'Telecommunications'],
            ]
        );
        $response_body = $response->getBody();
        $response_arr = json_decode((string) $response_body);

        if($response->getStatusCode() == 200){
            $department->external_id = $response_arr->data->id;
            $department->save();
            
        }

    }
}
