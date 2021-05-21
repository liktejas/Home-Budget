<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Tejas Sonawane',
            'email' => 'liktejas@gmail.com',
            'password' => Hash::make('tejas'),
            'image'=> 'tejas.jpg'
        ]);

        DB::table('users')->insert([
            'name' => 'Prabhakar Sonawane',
            'email' => 'prabhakar.sonawane06@gmail.com',
            'password' => Hash::make('prabhakar'),
            'image'=> 'prabhakar.jpg'
        ]);
    }
}
