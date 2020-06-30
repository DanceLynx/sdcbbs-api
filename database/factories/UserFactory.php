<?php
/*
 * @Author: DanceLynx
 * @Description: 用户数据模拟
 * @Date: 2020-06-20 16:58:26
 */

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'introduction' => $faker->sentence(5),
        'remember_token' => Str::random(10),
        'created_at'=>$faker->dateTimeThisMonth,
        'updated_at'=>$faker->dateTimeThisMonth,
    ];
});
