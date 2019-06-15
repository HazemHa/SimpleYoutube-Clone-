<?php
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
/*
|
--------------------------------------------------------------------------
| Model Factories
|
-------------------------------------------------------------------------
|
| This directory should contain each of the model
factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your
application's database.
|
*/

$factory->define(App\Channel::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'logo' => $faker->imageUrl($width = 150, $height = 180),
        'cover' => $faker->name,
        'about' => $faker->text,
        'user_id' => function () {
            return User::inRandomOrder()->first()->id;
        }
    ];
});
