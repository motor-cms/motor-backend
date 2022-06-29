<?php

namespace Motor\Backend\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Motor\Backend\Models\Client;
use Motor\Backend\Models\User;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'               => $this->faker->sentence,
            'country_iso_3166_1' => Str::random(2),
            'created_by'         => User::factory()->make()->id,
            'updated_by'         => User::factory()->make()->id,
        ];
    }
}
