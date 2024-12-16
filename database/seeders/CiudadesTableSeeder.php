<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CiudadesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ciudades')->delete();
        
        \DB::table('ciudades')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombre' => 'Calama',
                'created_at' => '2024-12-04 19:28:01',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'nombre' => 'Iquique',
                'created_at' => '2024-12-04 19:28:01',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'nombre' => 'Antofagasta',
                'created_at' => '2024-12-04 19:28:01',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'nombre' => 'Arica',
                'created_at' => '2024-12-04 19:28:01',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'nombre' => 'Chiu Chiu',
                'created_at' => '2024-12-04 19:28:01',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'nombre' => 'San Pedro de Atacama',
                'created_at' => '2024-12-04 19:28:01',
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}