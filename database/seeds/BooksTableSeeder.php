<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->truncate();
        DB::table('books')->insert([
            [
                'ISBN' => 9784065186893,
                'title' => '進撃の巨人（31)',
                'author' => '諫山 創',
                'img' => 'https://thumbnail.image.rakuten.co.jp/@0_mall/book/cabinet/6893/9784065186893.jpg?_ex=120x120',
                'created_at' => Carbon::create(2017, 12, 3),
            ],
            [
                'ISBN' => 9784488028022,
                'title' => '流浪の月',
                'author' => '凪良 ゆう',
                'img' => 'https://thumbnail.image.rakuten.co.jp/@0_mall/book/cabinet/8022/9784488028022.jpg?_ex=120x120',
                'created_at' => Carbon::create(2017, 10, 3),
            ],
        ]);
    }
}
