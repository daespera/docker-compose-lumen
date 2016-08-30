<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UserTableSeeder');
        DB::table('oauth_clients')->insert([
            'id' => '1',
            'secret' => 'lumen',
            'name' => 'lumen'
        ]);
    }
}
