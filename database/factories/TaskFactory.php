<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {

    $title = $faker->realText(rand(10,20));
    $descr = $faker->realText(rand(10,200));
    $deadline = $faker->dateTimeBetween('1 days', '2 days');
    $created = $faker->dateTimeBetween('-30 days', '-1 days');

    return [
        'executor_id' => rand(1,5),
        'title' => $title,
        'descr' => $descr,
        'deadline' => $deadline,
        'done' => rand(0,1),
        'created_at' => $created,
        'updated_at' => $created,
    ];
});
