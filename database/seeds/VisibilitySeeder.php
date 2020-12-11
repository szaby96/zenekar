<?php

use Illuminate\Database\Seeder;

class VisibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('visibility')->insert([
            ['name'=> 'public'],
            ['name'=> 'private'],
            ['name'=> 'instrument'],
        ]);
    }
}
