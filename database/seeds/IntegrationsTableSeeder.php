<?php

use Illuminate\Database\Seeder;

class IntegrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file for Processmaker
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('integrations')->delete();
        
        \DB::table('integrations')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Processmaker_core',
                'client_id' => null,
                'user_id' => null,
                'client_secret' => null,
                'api_key' => null,
                'api_type' => 'processmaker_core',
                'org_id' => null,
                'created_at' => '2016-06-04 13:42:19',
                'updated_at' => '2016-06-04 13:42:19',
            ),
        ));
    }
}
