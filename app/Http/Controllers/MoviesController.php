<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class MoviesController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'page' => 'numeric',
            'q' => 'string'
        ]);

        $inputs = $request->only(['page', 'q']);

        $search_query = $inputs['q'] ?? '';
        $page = $inputs['page'] ?? 1;
        $cache_key = "movies:$search_query:$page";

        $cached_response = Redis::get($cache_key);
        if ($cached_response !== null) {
            return response()->json(json_decode($cached_response));
        }

        $response = Http::get("http://moviesapi.ir/api/v1/movies", [
            'q' => $inputs['q'] ?? '',
            'page' => $inputs['page'] ?? 1
        ]);

        if ($response->ok()) {
            $response_json = $response->json();
            Redis::setex($cache_key, 3600, json_encode($response_json));
            return response()->json($response_json);
        } else {
            throw new Exception("Failed to retrieve movies list.");
        }
    }
}
