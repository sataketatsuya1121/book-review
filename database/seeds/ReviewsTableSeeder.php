<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('reviews')->truncate();
        DB::table('reviews')->insert([
            [
                'user_id'          => 1,
                'evaluation'         => 3,
                'content'      => 'testtesttesttesttesttest',
                'likes_count' => random_int(0, 10),
                'ISBN'        => 9784065186893,
                'created_at'    => Carbon::create(2017, 12, 3),
            ],
            [
                'user_id'          => 2,
                'evaluation'         => 3,
                'content'      => 'testtesttesttesttesttest',
                'likes_count' => random_int(0, 10),
                'ISBN'        => 9784065186893,
                'created_at'    => Carbon::create(2017, 12, 3),
            ],
            [
                'user_id'          => 3,
                'evaluation'         => 1,
                'content'      => 'testtesttesttesttesttestaaaaaaaaaaaaaa',
                'likes_count' => random_int(0, 10),
                'ISBN'        => 9784065186893,
                'created_at'    => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id'          => 4,
                'evaluation'         => 5,
                'content'      => 'testtesttesttesttest',
                'likes_count' => random_int(0, 10),
                'ISBN'        => 9784065186893,
                'created_at'    => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id'          => 1,
                'evaluation'         => 5,
                'content'      => 'testtesttesttesttest',
                'likes_count' => random_int(0, 10),
                'ISBN'        => 9784488028022,
                'created_at'    => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id'          => 2,
                'evaluation'         => 5,
                'content'      => 'testtesttesttesttest',
                'likes_count' => random_int(0, 10),
                'ISBN'        => 9784488028022,
                'created_at'    => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id'          => 3,
                'evaluation'         => 5,
                'content'      => 'testtesttesttesttest',
                'likes_count' => random_int(0, 10),
                'ISBN'        => 9784488028022,
                'created_at'    => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id'          => 4,
                'evaluation'         => 5,
                'content'      => 'testtesttesttesttest',
                'likes_count' => random_int(0, 10),
                'ISBN'        => 9784488028022,
                'created_at'    => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id'          => 5,
                'evaluation'         => 4,
                'content'      => 'testtesttesttesttest',
                'likes_count' => random_int(0, 10),
                'ISBN'        => 9784488028022,
                'created_at'    => Carbon::create(2017, 10, 3),
            ],
        ]);
    }
}
