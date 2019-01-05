<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS=0");
        factory(\App\Chat::class, 300)->create();
        DB::statement("SET FOREIGN_KEY_CHECKS=1");
    }
}
