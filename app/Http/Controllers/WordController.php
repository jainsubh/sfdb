<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Auth;
use Config;

class WordController extends Controller
{
    public $dictionary_url;
    public $default_header;

    public function __construct(){
        $this->dictionary_url = Config::get('dictionary.url');
        $this->default_header = [
            'Content-Type' => 'application/json',
        ];
    }

    public function meaning($word, $form_search = 0){
        try{
            if($word != ''){
                $client = new \GuzzleHttp\Client();
                $response = $client->get(
                    $this->dictionary_url.'en/'.$word,
                    [
                        'headers' => $this->default_header,
                    ]
                );

                $response_body = $response->getBody();
                $response_arr = json_decode((string) $response_body);
                
                $word = $response_arr[0]->word;
                $phonetic = (isset($response_arr[0]->phonetic)? $response_arr[0]->phonetic: '');
                $meanings = $response_arr[0]->meanings;
                if($response->getStatusCode() == 200){
                    return view('words.meaning', compact(['word', 'phonetic', 'meanings', 'form_search']));
                }
            }else{
                return view('words.meaning', compact(['word', 'form_search']));
            }
        }
        /*
        catch(\GuzzleHttp\Exception\RequestException $e){
            dd($e);
            return "<h3 style='text-align: center; padding-top: 40px;'>No word found in dictionary</h3>";
        }*/
        catch (ClientErrorResponseException $exception) {
            $responseBody = $exception->getResponse()->getBody(true);
            dd($responseBody);
        }
    }
}
