<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            ReviewsTableSeeder::class,
            BooksTableSeeder::class,
            LikesSeeder::class,
            StocksTableSeeder::class,
            FavoritesTableSeeder::class,
            DepartmentsTableSeeder::class,
            UserDetailsTableSeeder::class
        ]);
    }
}
