<?php

return [
  'api_key' => env('OMDB_API_KEY', null),
  'base_url' => env('OMDB_BASE_URL', 'http://www.omdbapi.com/'),
  'cache_ttl' => env('OMDB_CACHE_TTL', 3600),
];