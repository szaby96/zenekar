<?php

use Illuminate\Database\Seeder;

class RightsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rights')->insert([
            ['name'=> 'Tag'],
            ['name'=> 'Szólamvezető'],
            ['name'=> 'Zenekari vezető']
        ]);
    }
}
