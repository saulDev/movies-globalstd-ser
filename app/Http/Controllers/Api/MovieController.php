<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MovieRequest;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();

        return response()->json($movies);
    }

    public function create()
    {
        //
    }

    public function store(MovieRequest $request)
    {
        $path = $request->picture_file_path->store('images', 'public');
        $movie = Movie::create([
            'name' => $request->name,
            'release_date' => $request->release_date,
            'is_active' => $request->is_active,
            'picture_file_path' => $path,
            'minutes_length' => $request->minutes_length,
        ]);

        return response()->json($movie);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(MovieRequest $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
