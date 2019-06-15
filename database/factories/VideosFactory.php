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
$factory->define(App\Video::class, function (Faker $faker) {

    return [
        'title' => $faker->name,
        'description' => $faker->text,
        'published' => $faker->boolean,
        'url' => 'http://techslides.com/demos/sample-videos/small.mp4',
        'thumbnail' => $faker->imageUrl($width = 640, $height = 480),
        'allow_comments' => $faker->boolean,
        'views' => $faker->randomDigit,
        'channel_id' => function(){
            return App\Channel::inRandomOrder()->first()->id;
        },
        'user_id' => function(){
            return User::inRandomOrder()->first()->id;

        }
    ];
});
