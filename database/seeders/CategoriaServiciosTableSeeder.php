<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriaServiciosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categoria_servicios')->delete();
        
        \DB::table('categoria_servicios')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombre' => 'Psicología',
                'descripcion' => NULL,
                'created_at' => '2024-12-04 19:51:17',
                'updated_at' => '2024-12-04 19:51:17',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'nombre' => 'Masoterapia',
                'descripcion' => NULL,
                'created_at' => '2024-12-04 19:51:17',
                'updated_at' => '2024-12-04 19:51:17',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'nombre' => 'Clases',
                'descripcion' => NULL,
                'created_at' => '2024-12-04 19:51:17',
                'updated_at' => '2024-12-04 19:51:17',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'nombre' => 'Psicopedagogía',
                'descripcion' => NULL,
                'created_at' => '2024-12-04 19:51:17',
                'updated_at' => '2024-12-04 19:51:17',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'nombre' => 'Terapia Ocupacional',
                'descripcion' => NULL,
                'created_at' => '2024-12-04 19:51:17',
                'updated_at' => '2024-12-04 19:51:17',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'nombre' => 'Terapias Complementarias',
                'descripcion' => NULL,
                'created_at' => '2024-12-04 19:51:17',
                'updated_at' => '2024-12-04 19:51:17',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'nombre' => 'Fonoaudiología',
                'descripcion' => NULL,
                'created_at' => '2024-12-04 19:51:17',
                'updated_at' => '2024-12-04 19:51:17',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'nombre' => 'Cosmetología',
                'descripcion' => NULL,
                'created_at' => '2024-12-04 19:51:17',
                'updated_at' => '2024-12-04 19:51:17',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'nombre' => 'Talleres ',
                'descripcion' => NULL,
                'created_at' => '2024-12-04 19:51:17',
                'updated_at' => '2024-12-04 19:51:17',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'nombre' => 'Nutrición',
                'descripcion' => NULL,
                'created_at' => '2024-12-04 19:51:18',
                'updated_at' => '2024-12-04 19:51:18',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'nombre' => 'Kinesiología',
                'descripcion' => NULL,
                'created_at' => '2024-12-04 19:51:18',
                'updated_at' => '2024-12-04 19:51:18',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}