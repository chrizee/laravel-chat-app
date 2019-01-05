<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FriendsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS=0");
        factory(\App\Friends::class,20)->create();
        DB::statement("SET FOREIGN_KEY_CHECKS=1");
    }
}
