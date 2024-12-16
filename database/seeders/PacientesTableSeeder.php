<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PacientesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pacientes')->delete();
        
        \DB::table('pacientes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'rut' => '13.529.296-6',
                'nombres' => 'Rodrigo',
                'apellidos' => 'Tapia Celedón',
                'telefono' => '+56958091335',
                'comentario_adicional' => NULL,
                'direccion' => NULL,
                'ciudad_id' => 1,
                'email' => 'erinues@gmail.com',
                'genero' => 'Masculino',
                'estado_info' => 'verificado',
                'fecha_nacimiento' => '1983-08-14',
                'created_at' => '2024-12-05 09:21:51',
                'updated_at' => '2024-12-05 14:07:52',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'rut' => '16.226.513-k',
                'nombres' => 'Manuel',
                'apellidos' => 'Alarcón Alarcón',
                'telefono' => '+56997772298',
                'comentario_adicional' => NULL,
                'direccion' => NULL,
                'ciudad_id' => 1,
                'email' => 'janito79alan@gmail.com',
                'genero' => 'Masculino',
                'estado_info' => 'verificado',
                'fecha_nacimiento' => '1979-07-23',
                'created_at' => '2024-12-05 09:21:51',
                'updated_at' => '2024-12-05 14:07:52',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'rut' => '8.825.663-5',
                'nombres' => 'Natacha',
                'apellidos' => 'Contardo Gahona',
                'telefono' => '+56932246818',
                'comentario_adicional' => NULL,
                'direccion' => NULL,
                'ciudad_id' => 1,
                'email' => 'natta.contardo@gmail.com',
                'genero' => 'Femenino',
                'estado_info' => 'verificado',
                'fecha_nacimiento' => '1991-06-15',
                'created_at' => '2024-12-05 09:21:51',
                'updated_at' => '2024-12-05 14:07:52',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'rut' => '20.347.090-8',
                'nombres' => 'Berta',
                'apellidos' => 'Guerra Araneda',
                'telefono' => '+56944642977',
                'comentario_adicional' => NULL,
                'direccion' => NULL,
                'ciudad_id' => 1,
                'email' => 'bertagaraneda@gmail.com',
                'genero' => 'Femenino',
                'estado_info' => 'verificado',
                'fecha_nacimiento' => '1982-11-22',
                'created_at' => '2024-12-05 09:21:51',
                'updated_at' => '2024-12-05 14:07:52',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'rut' => '17.656.550-0',
                'nombres' => 'Ana',
                'apellidos' => 'Marin Villaroel',
                'telefono' => '+56984459308',
                'comentario_adicional' => NULL,
                'direccion' => NULL,
                'ciudad_id' => 1,
                'email' => 'Asodacristalina@gmail.com',
                'genero' => 'Femenino',
                'estado_info' => 'verificado',
                'fecha_nacimiento' => '1975-05-11',
                'created_at' => '2024-12-05 09:21:51',
                'updated_at' => '2024-12-05 14:07:52',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'rut' => '17.656.368-0',
                'nombres' => 'Javier',
                'apellidos' => 'Ali Ramos',
                'telefono' => '+56930782636',
                'comentario_adicional' => NULL,
                'direccion' => NULL,
                'ciudad_id' => 1,
                'email' => 'javier.ali.ramos@gmail.com',
                'genero' => 'Masculino',
                'estado_info' => 'verificado',
                'fecha_nacimiento' => '1989-03-08',
                'created_at' => '2024-12-05 09:21:51',
                'updated_at' => '2024-12-05 14:07:52',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'rut' => '15.258.487-3',
                'nombres' => 'Caterine',
                'apellidos' => 'Rozas Maurer',
                'telefono' => '+56978548773',
                'comentario_adicional' => NULL,
                'direccion' => NULL,
                'ciudad_id' => 1,
                'email' => 'c.rozas.maurer@gmail.com',
                'genero' => 'Femenino',
                'estado_info' => 'verificado',
                'fecha_nacimiento' => '1993-01-10',
                'created_at' => '2024-12-05 09:21:51',
                'updated_at' => '2024-12-05 14:07:52',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'rut' => '15.048.780-3',
                'nombres' => 'Nathalie',
                'apellidos' => 'Tapia Olivares',
                'telefono' => '+56992658852',
                'comentario_adicional' => NULL,
                'direccion' => NULL,
                'ciudad_id' => 1,
                'email' => 'nathalie.tapia24@hotmail.com',
                'genero' => 'Femenino',
                'estado_info' => 'verificado',
                'fecha_nacimiento' => '1987-10-20',
                'created_at' => '2024-12-05 09:21:51',
                'updated_at' => '2024-12-05 14:07:52',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'rut' => '14.588.971-5',
                'nombres' => 'Rosa',
                'apellidos' => 'Díaz Ramos',
                'telefono' => '+56923866692',
                'comentario_adicional' => NULL,
                'direccion' => NULL,
                'ciudad_id' => 1,
                'email' => 'rmdiazramos@gmail.com',
                'genero' => 'Femenino',
                'estado_info' => 'verificado',
                'fecha_nacimiento' => '1986-12-13',
                'created_at' => '2024-12-05 09:21:51',
                'updated_at' => '2024-12-05 14:07:52',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'rut' => '8.655.380-5',
                'nombres' => 'Jose',
                'apellidos' => 'Tejerina Calle',
                'telefono' => '+56998841689',
                'comentario_adicional' => NULL,
                'direccion' => NULL,
                'ciudad_id' => 1,
                'email' => 'jose.tejerina@live.cl',
                'genero' => 'Masculino',
                'estado_info' => 'verificado',
                'fecha_nacimiento' => '1992-06-28',
                'created_at' => '2024-12-05 09:21:51',
                'updated_at' => '2024-12-05 14:07:52',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'rut' => '17.093.008-8',
                'nombres' => 'Poulette',
                'apellidos' => 'Diaz Rivera',
                'telefono' => '+56944196910',
                'comentario_adicional' => NULL,
                'direccion' => NULL,
                'ciudad_id' => 1,
                'email' => 'poulettediaz88@gmail.com',
                'genero' => 'Femenino',
                'estado_info' => 'verificado',
                'fecha_nacimiento' => '1983-09-14',
                'created_at' => '2024-12-05 09:21:51',
                'updated_at' => '2024-12-05 14:07:52',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'rut' => '16.389.131-k',
                'nombres' => 'Patricio',
                'apellidos' => 'Castañeda Muñoz',
                'telefono' => '+56942717791',
                'comentario_adicional' => NULL,
                'direccion' => NULL,
                'ciudad_id' => 1,
                'email' => 'patosebas18@gmail.com',
                'genero' => 'Masculino',
                'estado_info' => 'verificado',
                'fecha_nacimiento' => '1984-02-25',
                'created_at' => '2024-12-05 09:21:51',
                'updated_at' => '2024-12-05 14:07:52',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'rut' => '11.931.759-2',
                'nombres' => 'Ricardo',
                'apellidos' => 'Pérez Astorga',
                'telefono' => '+56926410070',
                'comentario_adicional' => NULL,
                'direccion' => NULL,
                'ciudad_id' => 1,
                'email' => 'rimomasrph@gmail.com',
                'genero' => 'Masculino',
                'estado_info' => 'verificado',
                'fecha_nacimiento' => '1978-04-17',
                'created_at' => '2024-12-05 09:21:51',
                'updated_at' => '2024-12-05 14:07:52',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'rut' => '17.866.126-4',
                'nombres' => 'Pamela',
                'apellidos' => 'Poblete Iriarte',
                'telefono' => '+56986708973',
                'comentario_adicional' => NULL,
                'direccion' => NULL,
                'ciudad_id' => 1,
                'email' => 'ppobleteiriarte@gmail.com',
                'genero' => 'Femenino',
                'estado_info' => 'verificado',
                'fecha_nacimiento' => '1990-07-06',
                'created_at' => '2024-12-05 09:21:51',
                'updated_at' => '2024-12-05 14:07:52',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'rut' => '13.529.158-7',
                'nombres' => 'Claudia',
                'apellidos' => 'Santibañez Gavia',
                'telefono' => '+56932290625',
                'comentario_adicional' => NULL,
                'direccion' => NULL,
                'ciudad_id' => 1,
                'email' => 'claudysaga@gmail.com',
                'genero' => 'Femenino',
                'estado_info' => 'verificado',
                'fecha_nacimiento' => '1984-12-29',
                'created_at' => '2024-12-05 09:21:51',
                'updated_at' => '2024-12-05 14:07:52',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'rut' => '20.274.732-9',
                'nombres' => 'Joseph Benjamin',
                'apellidos' => 'Ramirez Catalan',
                'telefono' => '+56964115359',
                'comentario_adicional' => NULL,
                'direccion' => 'avenida siempre viva 1234',
                'ciudad_id' => 1,
                'email' => 'benjanewgrooves@hotmail.com',
                'genero' => 'Masculino',
                'estado_info' => 'verificado',
                'fecha_nacimiento' => '1999-09-29',
                'created_at' => '2024-12-05 14:03:37',
                'updated_at' => '2024-12-05 14:03:37',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}