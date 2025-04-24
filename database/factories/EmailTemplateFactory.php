<?php

namespace Motor\Backend\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Motor\Backend\Models\Client;
use Motor\Backend\Models\EmailTemplate;
use Motor\Backend\Models\Language;
use Motor\Backend\Models\User;

class EmailTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmailTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_id' => Client::factory()->make()->id,
            'language_id' => Language::factory()->make()->id,
            'name' => $this->faker->sentence,
            'subject' => $this->faker->sentence,
            'body_text' => $this->faker->paragraph(1),
            'body_html' => $this->faker->paragraph(1),
            'default_sender_email' => $this->faker->email,
            'default_sender_name' => $this->faker->name,
            'default_recipient_email' => $this->faker->email,
            'default_recipient_name' => $this->faker->name,
            'created_by' => User::factory()->make()->id,
            'updated_by' => User::factory()->make()->id,
        ];
    }
}
