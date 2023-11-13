<?php

namespace App\Http\Requests\Api;

use App\Rules\UniqueMovieNameReleaseDateRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class MovieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'release_date' => ['required', 'date', new UniqueMovieNameReleaseDateRule()],
            'picture_file_path' => [File::image()->max(1024)],
            'minutes_length' => ['required', 'integer', 'max_digits:3'],
        ];
    }
}
