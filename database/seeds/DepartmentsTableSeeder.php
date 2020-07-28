<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            [
                'name' => 'フロントエンド',
            ],
            [
                'name' => 'バックエンド',
            ],
            [
                'name' => 'ネットワーク',
            ],
            [
                'name' => '教育',
            ],
            [
                'name' => '人事',
            ],
            [
                'name' => '役職',
            ],
            [
                'name' => '営業',
            ],

        ]);
    }
}
