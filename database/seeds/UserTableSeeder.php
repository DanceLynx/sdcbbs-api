<?php
/*
 * @Author: DanceLynx
 * @Description: 用户表数据填充
 * @Date: 2020-06-22 08:48:02
 */

use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);
        $avatars = [
            'https://cdn.learnku.com/uploads/images/201710/14/1/s5ehp11z6s.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/Lhd1SHqu86.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/LOnMrqbHJn.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/xAuDMxteQy.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/ZqM7iaP4CR.png',
            'https://cdn.learnku.com/uploads/images/201710/14/1/NDnzMutoxX.png',
        ];

        $users = factory(User::class)
            ->times(10)
            ->make()
            ->each(function ($user, $index) use ($avatars, $faker) {
                $user->avatar = $faker->randomElement($avatars);
            });

        $usersArray = $users->makeVisible(['password', 'remember_token'])->toArray();

        User::insert($usersArray);
        $user = User::find(1);
        $user->assignRole("Founder");
        $user = User::find(2);
        $user->assignRole('Maintainer');
    }
}
