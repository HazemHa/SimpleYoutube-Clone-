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

$factory->define(App\subscribersChannel::class, function (Faker $faker) {
    return [
        'channel_id' => function () {
            return App\Channel::inRandomOrder()->first()->id;
        },
        'user_id' => function () {
            return User::inRandomOrder()->first()->id;
        }
    ];
});
