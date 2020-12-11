<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'right_id' => 3,
            'email_verified_at' => now(),
            'password' => bcrypt('Zenekar123'),
            'approved_at' => now(),
        ]);
    }
}
