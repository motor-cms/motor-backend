<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Motor\Backend\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'api_token'      => str_random(60),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Motor\Backend\Models\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word . $faker->word . str_random(20)
    ];
});

$factory->define(Motor\Backend\Models\Language::class, function (Faker\Generator $faker) {
    return [
        'iso_639_1'    => str_random(2),
        'english_name' => $faker->word,
        'native_name'  => $faker->word
    ];
});

$factory->define(Motor\Backend\Models\Client::class, function (Faker\Generator $faker) {
    return [
        'name'               => $faker->sentence,
        'country_iso_3166_1' => str_random(2),
        'created_by'         => factory(Motor\Backend\Models\User::class)->create()->id,
        'updated_by'         => factory(Motor\Backend\Models\User::class)->create()->id,
    ];
});

$factory->define(Motor\Backend\Models\Permission::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word . '.' . $faker->word . '.' . $faker->word
    ];
});

$factory->define(Motor\Backend\Models\PermissionGroup::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(Motor\Backend\Models\EmailTemplate::class, function (Faker\Generator $faker) {
    return [
        'client_id'               => factory(Motor\Backend\Models\Client::class)->create()->id,
        'language_id'             => factory(Motor\Backend\Models\Language::class)->create()->id,
        'name'                    => $faker->sentence,
        'subject'                 => $faker->sentence,
        'body_text'               => $faker->paragraph(1),
        'body_html'               => $faker->paragraph(1),
        'default_sender_email'    => $faker->email,
        'default_sender_name'     => $faker->name,
        'default_recipient_email' => $faker->email,
        'default_recipient_name'  => $faker->name,
        'created_by'              => factory(Motor\Backend\Models\User::class)->create()->id,
        'updated_by'              => factory(Motor\Backend\Models\User::class)->create()->id,
    ];
});

$factory->define(Motor\Backend\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(Motor\Backend\Models\CategoryTree::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});
