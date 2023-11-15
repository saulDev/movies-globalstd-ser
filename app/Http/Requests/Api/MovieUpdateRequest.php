<?php

namespace App\Http\Requests\Api;

use App\Rules\UniqueMovieNameReleaseDateRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class MovieUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'release_date' => ['required', 'date'],
            'picture_file_path' => ['nullable', File::image()->max(1024)],
            'minutes_length' => ['required', 'integer', 'max_digits:3'],
        ];
    }
}
