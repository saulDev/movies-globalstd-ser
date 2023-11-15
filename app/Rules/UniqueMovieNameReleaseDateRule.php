<?php

namespace App\Rules;

use App\Models\Movie;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueMovieNameReleaseDateRule implements ValidationRule, DataAwareRule
{
    protected $data = [];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (array_key_exists('name', $this->data) && array_key_exists('release_date', $this->data)) {
            $sameMovie = Movie::where([
                ['name', $this->data['name']],
                ['release_date', $this->data['release_date']],
            ])->first();

            if ($sameMovie) {
                $fail('La pelicula ya existe.');
            }
        }
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
