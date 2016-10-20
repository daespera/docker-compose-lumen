<?php
namespace database\seeds;

use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder  
{
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'id' => '1',
            'secret' => 'lumen',
            'name' => 'lumen'
        ]);
    }
}