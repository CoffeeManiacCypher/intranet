<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PersonalTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('personal')->delete();
        
        \DB::table('personal')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombres' => 'Verónica',
                'apellidos' => 'Calani Alcayni',
                'email' => 'verocalani@gmail.com',
                'telefono' => '+56978157000',
                'rol' => 'Administrador',
                'created_at' => '2024-12-05 07:56:02',
                'updated_at' => '2024-12-05 07:56:02',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'nombres' => 'Katherine',
                'apellidos' => 'Pezoa Díaz',
                'email' => 'kpezoa@gmail.com',
                'telefono' => '+56977752032',
                'rol' => 'Administrador',
                'created_at' => '2024-12-05 07:56:02',
                'updated_at' => '2024-12-05 07:56:02',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 12,
                'nombres' => 'Catalina',
                'apellidos' => 'Trillo',
                'email' => 'secretaria.arterapia@gmail.com',
                'telefono' => '+56978157000',
                'rol' => 'Recepcionista',
                'created_at' => '2024-12-05 09:01:50',
                'updated_at' => '2024-12-05 09:01:50',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 13,
                'nombres' => 'Christianne',
                'apellidos' => 'Cubillos',
                'email' => 'secretaria.arterapia@gmail.com',
                'telefono' => '+56978157000',
                'rol' => 'Recepcionista',
                'created_at' => '2024-12-05 09:01:50',
                'updated_at' => '2024-12-05 09:01:50',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 14,
                'nombres' => 'Sharon',
                'apellidos' => 'Segovia',
                'email' => 'secretaria.arterapia@gmail.com',
                'telefono' => '+56978157000',
                'rol' => 'Recepcionista',
                'created_at' => '2024-12-05 09:01:50',
                'updated_at' => '2024-12-05 09:01:50',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 15,
                'nombres' => 'Lissette',
                'apellidos' => 'Plaza',
                'email' => 'secretaria.arterapia@gmail.com',
                'telefono' => '+56978157000',
                'rol' => 'Recepcionista',
                'created_at' => '2024-12-05 09:01:50',
                'updated_at' => '2024-12-05 09:01:50',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 16,
                'nombres' => 'Alejandra',
                'apellidos' => 'Suárez',
                'email' => 'secretaria.arterapia@gmail.com',
                'telefono' => '+56978157000',
                'rol' => 'Recepcionista',
                'created_at' => '2024-12-05 09:01:50',
                'updated_at' => '2024-12-05 09:01:50',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 17,
                'nombres' => 'Natalie',
                'apellidos' => 'Gutiérrez',
                'email' => 'secretaria.arterapia@gmail.com',
                'telefono' => '+56978157000',
                'rol' => 'Recepcionista',
                'created_at' => '2024-12-05 09:01:50',
                'updated_at' => '2024-12-05 09:01:50',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 18,
                'nombres' => 'Vanessa',
                'apellidos' => 'Hidalgo',
                'email' => 'secretaria.arterapia@gmail.com',
                'telefono' => '+56978157000',
                'rol' => 'Recepcionista',
                'created_at' => '2024-12-05 09:01:50',
                'updated_at' => '2024-12-05 09:01:50',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 19,
                'nombres' => 'Clara',
                'apellidos' => 'Pereira',
                'email' => 'secretaria.arterapia@gmail.com',
                'telefono' => '+56978157000',
                'rol' => 'Recepcionista',
                'created_at' => '2024-12-05 09:01:50',
                'updated_at' => '2024-12-05 09:01:50',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 20,
                'nombres' => 'Gabriela',
                'apellidos' => 'Varela',
                'email' => 'secretaria.arterapia@gmail.com',
                'telefono' => '+56978157000',
                'rol' => 'Recepcionista',
                'created_at' => '2024-12-05 09:01:50',
                'updated_at' => '2024-12-05 09:01:50',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 21,
                'nombres' => 'Catalina ',
                'apellidos' => 'Villalobos',
                'email' => 'secretaria.arterapia@gmail.com',
                'telefono' => '+56978157000',
                'rol' => 'Recepcionista',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}