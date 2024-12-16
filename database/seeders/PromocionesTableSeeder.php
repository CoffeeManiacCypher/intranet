<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PromocionesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('promociones')->delete();
        
        \DB::table('promociones')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombre' => 'Flores de Bach VIP Control',
                'categoria_promocion_id' => 3,
                'descripcion' => NULL,
                'created_at' => '2024-12-05 07:44:31',
                'updated_at' => '2024-12-05 07:44:31',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'nombre' => 'Intervención Clínica',
                'categoria_promocion_id' => 3,
                'descripcion' => NULL,
                'created_at' => '2024-12-05 07:44:31',
                'updated_at' => '2024-12-05 07:44:31',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'nombre' => 'Pack 5 intervenciones Psicopedagógicas',
                'categoria_promocion_id' => 1,
                'descripcion' => NULL,
                'created_at' => '2024-12-05 07:44:31',
                'updated_at' => '2024-12-05 07:44:31',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'nombre' => 'GiftCard Día del Profe',
                'categoria_promocion_id' => 2,
                'descripcion' => NULL,
                'created_at' => '2024-12-05 07:44:31',
                'updated_at' => '2024-12-05 07:44:31',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'nombre' => 'Evolet Fonoaudiología',
                'categoria_promocion_id' => 3,
                'descripcion' => NULL,
                'created_at' => '2024-12-05 07:44:31',
                'updated_at' => '2024-12-05 07:44:31',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'nombre' => 'Masaje Una Hora',
                'categoria_promocion_id' => 3,
                'descripcion' => NULL,
                'created_at' => '2024-12-05 07:44:31',
                'updated_at' => '2024-12-05 07:44:31',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'nombre' => 'Pack 5  Intervenciones Toc',
                'categoria_promocion_id' => 1,
                'descripcion' => NULL,
                'created_at' => '2024-12-05 07:44:31',
                'updated_at' => '2024-12-05 07:44:31',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'nombre' => 'Kine  Pack 10 sesiones',
                'categoria_promocion_id' => 1,
                'descripcion' => NULL,
                'created_at' => '2024-12-05 07:44:31',
                'updated_at' => '2024-12-05 07:44:31',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'nombre' => 'Giftcard Cumpleaños',
                'categoria_promocion_id' => 2,
                'descripcion' => NULL,
                'created_at' => '2024-12-05 07:44:31',
                'updated_at' => '2024-12-05 07:44:31',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'nombre' => 'Control Nutrición',
                'categoria_promocion_id' => 3,
                'descripcion' => NULL,
                'created_at' => '2024-12-05 07:44:31',
                'updated_at' => '2024-12-05 07:44:31',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}