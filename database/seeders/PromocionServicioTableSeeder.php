<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PromocionServicioTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('promocion_servicio')->delete();
        
        \DB::table('promocion_servicio')->insert(array (
            0 => 
            array (
                'id' => 1,
                'promocion_id' => 1,
                'servicio_id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'promocion_id' => 1,
                'servicio_id' => 14,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'promocion_id' => 2,
                'servicio_id' => 18,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'promocion_id' => 2,
                'servicio_id' => 22,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'promocion_id' => 3,
                'servicio_id' => 20,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'promocion_id' => 5,
                'servicio_id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'promocion_id' => 5,
                'servicio_id' => 15,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'promocion_id' => 10,
                'servicio_id' => 23,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}