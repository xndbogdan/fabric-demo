<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class OMDB
{
    public static function search(string $term, $page = 1): array
    {
        // Do an HTTP request to the OMDB API
        $response = Http::get(config('omdb.base_url'), [
            'apikey' => config('omdb.api_key'),
            's' => $term,
            'page' => $page
        ]);
        if($response->failed()) {
            ray($response->body());
            throw new \Exception('OMDB API request failed');
        }
        $response = $response->json();
        if($response['Response'] === 'False') {
            throw new \Exception($response['Error']);
        }
        return $response;
    }
}