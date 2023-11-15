<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MovieRequest;
use App\Http\Requests\Api\MovieUpdateRequest;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();

        return response()->json($movies);
    }

    public function store(MovieRequest $request)
    {
        $path = $request->picture_file_path->store('images', 'public');
        $movie = Movie::create([
            'name' => $request->name,
            'release_date' => $request->release_date,
            'is_active' => 1,
            'picture_file_path' => $path,
            'minutes_length' => $request->minutes_length,
        ]);

        return response()->json($movie);
    }

    public function show(string $id)
    {
        //
    }

    public function update(MovieUpdateRequest $request, string $id)
    {
        $movie = Movie::findOrFail($id);

        $movie->name = $request->name;
        $movie->release_date = $request->release_date;
        $movie->minutes_length = $request->minutes_length;

        if ($request->picture_file_path) {
            $path = $request->picture_file_path->store('images', 'public');
            $movie->picture_file_path = $path;
        }
        $movie->save();

        return response()->json($movie);
    }

    public function destroy(string $id)
    {
        Movie::findOrFail($id)->delete();
    }
}
