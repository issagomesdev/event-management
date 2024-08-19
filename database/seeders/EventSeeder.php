<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            'name' => Str::random(10),
            'start' => Str::random(10),
            'end' => Str::random(10),
            'password' => Hash::make('password'),
        ]);
    }
}
