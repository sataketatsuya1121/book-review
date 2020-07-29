<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserDetail;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(UserDetail::class, function (Faker $faker) {
    return [
        'dept_id' => $faker->numberBetween(1, 7),
        'joined_company_date' => $faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now')->format('Y-m'),
    ];
});
