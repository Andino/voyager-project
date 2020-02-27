<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Admin Test",
            'email' => 'admin@gmail.com',
            'password' => Hash::make('secret'),
        ]);
        // $this->call(UsersTableSeeder::class);
    }
}
