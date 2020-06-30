<?php
/*
 * @Author: DanceLynx
 * @Description: 帖子数据填充
 * @Date: 2020-06-22 08:36:33
 */

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
use Faker\Generator;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        $userIds = User::all()->pluck('id')->toArray();
        $categoryIds = Category::all()->pluck('id')->toArray();
        $faker = app(Generator::class);
        $topics = factory(Topic::class)
            ->times(50)
            ->make()
            ->each(function ($topic, $index) use ($userIds, $faker, $categoryIds) {
                $topic->user_id = $faker->randomElement($userIds);
                $topic->category_id = $faker->randomElement($categoryIds);
            });

        Topic::insert($topics->toArray());
    }
}
