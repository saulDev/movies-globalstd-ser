<?php

namespace Tests\Feature\Api;

use App\Models\Movie;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testRequestWithUnauthorizedUser(): void
    {
        $response = $this->json('POST', '/api/v1/movies');

        $response->assertStatus(401);
    }

    /**
     * @dataProvider dataThatShouldFail
     */
    public function testStoreShouldFailValidation($invalidData, $invalidFields): void
    {
        $this->seed();
        $user = User::first();
        $response = $this->actingAs($user)->json('POST', '/api/v1/movies', $invalidData);

        $response->assertStatus(422)->assertInvalid($invalidFields);
    }

    public function testStoreShouldPassValidationAndStore()
    {
        $this->seed();
        $user = User::first();

        $data = [
            'name' => fake()->company(),
            'release_date' => fake()->date(),
            'is_active' => fake()->boolean(),
            'picture_file_path' => UploadedFile::fake()->image('avatar.jpg'),
            'minutes_length' => fake()->numerify(),
        ];

        $response = $this->actingAs($user)->json('POST', '/api/v1/movies', $data);

        $response->assertStatus(200)->assertValid()->assertJsonStructure(['name', 'release_date', 'is_active', 'picture_file_path', 'minutes_length']);
    }

    public static function dataThatShouldFail():array
    {
        return [
            [
                ['name' => '', 'release_date' => '', 'minutes_length' => ''],
                ['name', 'release_date', 'minutes_length'],
            ],
            [
                ['name' => Str::random(256)],
                ['name'],
            ],
            [
                ['release_date' => 'hello'],
                ['release_date'],
            ],
            [
                ['release_date' => '2022-01-01', 'name' => 'Avengers'],
                ['release_date'],
            ],
            [
                ['minutes_length' => 1.2],
                ['minutes_length'],
            ],
            [
                ['minutes_length' => 1234],
                ['minutes_length'],
            ],
            [
                ['picture_file_path' => UploadedFile::fake()->create('avatar.xml', '1', 'text/xml')],
                ['picture_file_path'],
            ],
            [
                ['picture_file_path' => UploadedFile::fake()->image('avatar.jpg')->size(1025)],
                ['picture_file_path'],
            ],
        ];
    }
}
