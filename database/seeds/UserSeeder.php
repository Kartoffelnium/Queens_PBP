<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')
            ->insert([
                'name' => 'Rama',
                'email' => 'bangjago@admin.com',
                'password' => '$2b$10$KEo9HiFffxRGkE.eWj6LEezFVw11V4RZNCbuIy9WZAWwa0/PQG3M2',
                'created_at' => Carbon\Carbon::now(),
                'updated_at' => Carbon\Carbon::now()
            ]);
    }
}
