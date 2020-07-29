<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 50)->create()->each(function ($user) {
            $user->userDetail()->save(factory(App\Models\UserDetail::class)->make());
        });
        DB::table('users')->insert([
            [
                'name' => '佐竹',
                'email' => 'hoge@gmail.com',
                'password' => bcrypt('aaaaaaaa'),
                'avatar' => null,
                'created_at' => Carbon::create(2017, 12, 3),
            ],
            [
                'name' => '粂川',
                'email' => 'a24arc.ad@gmail.com',
                'password' => bcrypt('a24arc.ad@gmail.com'),
                'avatar' => 'https://www.pakutaso.com/shared/img/thumb/KAZUHIRO171013022_TP_V.jpg',
                'created_at' => Carbon::create(2017, 4, 3),
            ],
            [
                'name' => '岡村',
                'email' => 'foo@gmail.com',
                'password' => bcrypt('foo@gmail.com'),
                'avatar' => null,
                'created_at' => Carbon::create(2017, 7, 16),
            ],
            [
                'name' => '尾形',
                'email' => 'aoo@gmail.com',
                'password' => bcrypt('aoo@gmail.com'),
                'avatar' => null,
                'created_at' => Carbon::create(2017, 2, 16),
            ],
        ]);
    }
}
