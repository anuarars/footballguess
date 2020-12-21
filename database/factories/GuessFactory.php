<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Guess;
use Faker\Generator as Faker;

$factory->define(Guess::class, function (Faker $faker) {
    return [
        'user_id' => rand(1,2),
        'schedule_id' => rand(1,2),
        'matchday' => rand(1,2),
        'utcDate' => rand(1,2),
        'FThomeTeam' => rand(1,2),
        "FTawayTeam" => rand(1,2)
    ];
});
