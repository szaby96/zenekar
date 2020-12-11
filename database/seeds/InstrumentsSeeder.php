<?php

use Illuminate\Database\Seeder;

class InstrumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('instruments')->insert([
            ['name'=> 'Fuvola'],
            ['name'=> 'Klarinet'],
            ['name'=> 'Oboa'],
            ['name'=> 'Szaxofon'],
            ['name'=> 'Trombita'],
            ['name'=> 'Vadászkürt'],
            ['name'=> 'Tenorkürt'],
            ['name'=> 'Harsona'],
            ['name'=> 'Tuba'],
            ['name'=> 'Ütő'],
        ]);
    }
}
