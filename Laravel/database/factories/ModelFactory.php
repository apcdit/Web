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
$factory->define(App\Posts::class, function (Faker\Generator $faker) {
    static $password;

    // return [
    //     'uniNameCN' => $faker->name,
    //     'uniNameEN' => $faker->name,
    //     'region' => $faker->name,
    //     'nameEn' => $faker->name,
    //     'nameCn' => $faker->name,
    //     'address' => $faker->address,
    //     'email' => $faker->unique()->safeEmail,
    //     'contactNumber' => $faker->unique()->phoneNumber,
    //     'password' => $password ?: $password = bcrypt('secret'),
    //     'remember_token' => str_random(10),
    // ];

       return [
           'postTitle' => $faker->name,
           'postPic' => $faker->url,
           'postDec' => $faker->sentence($nbWords = 6, $variableNbWords = true),
           'postContent' => $faker->sentence($nbWords = 70, $variableNbWords = true),
   ];
});
