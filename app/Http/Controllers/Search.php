<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class Search extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        try {
            if (empty($query)) {
                $query = "Culture Kings";
            }
            $client = new Client(); //GuzzleHttp\Client
            $request = $client->get(
                "https://api.github.com/search/repositories?q=".urlencode($query),
                array(
                    'timeout'           => 5, // Response timeout (seconds)
                    'connect_timeout'   => 5  // Connection timeout (seconds)
                )
            );
            $data = json_decode($request->getBody());
            
            return view('search', ['data' => $data, 'query' => $query]);
            
        } catch (GuzzleException $e) {
            return view('search', ['data' => (object)['items'=>[]], 'query' => $query]);
        }
    }
}
