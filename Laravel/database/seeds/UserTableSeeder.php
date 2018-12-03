<?php

use Illuminate\Database\Seeder;
use App\Posts;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Posts::class,50)->create();
    }
}
