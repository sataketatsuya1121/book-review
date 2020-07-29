<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stocks')->truncate();
        DB::table('stocks')->insert([
            [
                'user_id' => 1,
                'ISBN' => 9784065186893,
                'created_at' => Carbon::create(2017, 12, 3),
            ],
            [
                'user_id' => 2,
                'ISBN' => 9784065186893,
                'created_at' => Carbon::create(2017, 12, 3),
            ],
            [
                'user_id' => 3,
                'ISBN' => 9784065186893,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 4,
                'ISBN' => 9784065186893,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 5,
                'ISBN' => 9784065186893,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 6,
                'ISBN' => 9784065186893,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 7,
                'ISBN' => 9784065186893,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 8,
                'ISBN' => 9784065186893,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 9,
                'ISBN' => 9784065186893,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 10,
                'ISBN' => 9784065186893,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 1,
                'ISBN' => 9784488028022,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 2,
                'ISBN' => 9784488028022,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 3,
                'ISBN' => 9784488028022,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 4,
                'ISBN' => 9784488028022,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 5,
                'ISBN' => 9784488028022,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 6,
                'ISBN' => 9784488028022,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 7,
                'ISBN' => 9784488028022,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 8,
                'ISBN' => 9784488028022,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 9,
                'ISBN' => 9784488028022,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
            [
                'user_id' => 10,
                'ISBN' => 9784488028022,
                'created_at' => Carbon::create(2017, 10, 3),
            ],
        ]);
    }
}
