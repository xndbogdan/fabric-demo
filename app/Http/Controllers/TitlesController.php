<?php

namespace App\Http\Controllers;

use App\Facades\OMDB;
use App\Http\Requests\GetTitlesRequest;
use App\Models\SearchedTerm;
use App\Models\Title;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TitlesController extends Controller
{
    public function index(GetTitlesRequest $request)
    {
        $term = SearchedTerm::firstOrCreate([
            'term' => $request->term
        ]);

        $page = $request->page ?? 1;

        // Guard clause, return data straight from the api if it's not cached
        if(!isset($term->caches[$page]) || (Carbon::parse($term->caches[$page])->diffInSeconds(now()) > config('omdb.cache_ttl'))) {
            DB::beginTransaction();
            $results = OMDB::search($request->term, $page);
            $response = collect();
            foreach($results['Search'] as $item) {
                // We now need to convert the results array from pascal case to snake case because OMDB are pure sadists
                $eloquentItem = Title::updateOrCreate([
                    'imdb_id' => $item['imdbID'],
                ], [
                    'title' => $item['Title'],
                    'year' => $item['Year'],
                    'type' => $item['Type'],
                ]);

                if(!$eloquentItem->getFirstMediaUrl('poster') && $item['Poster'] !== 'N/A') {
                    $eloquentItem->addMediaFromUrl($item['Poster'])->toMediaCollection('poster');
                    $eloquentItem->refresh(); // Refresh the model to get the new media url
                }
                $response->push($eloquentItem);

                
            }

            $newCaches = $term->caches;
            $newCaches[$page] = now();

            $term->caches = $newCaches;
            $term->pages = floor($results['totalResults'] / 10);
            $term->save();

            DB::commit();

            // I actually find it funny that OMDB doesn't just use pascal case, but there's some camel case in there too
            return response()->json([
                'titles' => $response,
                'total_pages' => floor($results['totalResults'] / 10),
            ]);
            
        }

        $result = Title::where('title', 'like', '%' . $request->term . '%')->paginate(10)->toArray();
        return response()->json([
            'titles' => $result['data'],
            'total_pages' => $term->pages,
        ]);
    }
}
