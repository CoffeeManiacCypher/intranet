<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServiciosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('servicios')->delete();
        
        \DB::table('servicios')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombre' => 'Taller Psicología',
                'categoria_servicio_id' => 1,
                'precio' => '30000.00',
                'descripcion' => NULL,
                'duracion' => 60,
                'created_at' => '2024-12-04 20:04:05',
                'updated_at' => '2024-12-07 19:48:55',
                'deleted_at' => '2024-12-07 19:48:55',
            ),
            1 => 
            array (
                'id' => 3,
                'nombre' => '6 clases de Yoga',
                'categoria_servicio_id' => 3,
                'precio' => '28500.00',
                'descripcion' => NULL,
                'duracion' => 60,
                'created_at' => '2024-12-04 20:04:05',
                'updated_at' => '2024-12-04 20:04:05',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 4,
                'nombre' => '4 clases de Yoga',
                'categoria_servicio_id' => 3,
                'precio' => '19000.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 20:04:05',
                'updated_at' => '2024-12-09 16:47:11',
                'deleted_at' => '2024-12-09 16:47:11',
            ),
            3 => 
            array (
                'id' => 5,
                'nombre' => '2 clases de Yoga',
                'categoria_servicio_id' => 3,
                'precio' => '9500.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 20:04:05',
                'updated_at' => '2024-12-04 20:04:05',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 6,
                'nombre' => 'Intervención Social',
                'categoria_servicio_id' => 4,
                'precio' => '0.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 20:04:05',
                'updated_at' => '2024-12-04 20:04:05',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 7,
                'nombre' => 'Intervención TOC Hermanos',
                'categoria_servicio_id' => 5,
                'precio' => '49900.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 20:04:05',
                'updated_at' => '2024-12-04 20:04:05',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 8,
                'nombre' => 'Flores de Bach VIP Control',
                'categoria_servicio_id' => 6,
                'precio' => '25900.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 20:04:05',
                'updated_at' => '2024-12-04 20:04:05',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 9,
                'nombre' => 'Evolet Fonoaudiología',
                'categoria_servicio_id' => 7,
                'precio' => '27900.00',
                'descripcion' => NULL,
                'duracion' => 90,
                'created_at' => '2024-12-04 20:04:05',
                'updated_at' => '2024-12-04 20:04:05',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 10,
                'nombre' => 'Evolet TOC',
                'categoria_servicio_id' => 5,
                'precio' => '27900.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 20:04:05',
                'updated_at' => '2024-12-04 20:04:05',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 12,
                'nombre' => 'Intervención Social',
                'categoria_servicio_id' => 4,
                'precio' => '0.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 20:56:28',
                'updated_at' => '2024-12-04 20:56:28',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 13,
                'nombre' => 'Intervención TOC Hermanos',
                'categoria_servicio_id' => 5,
                'precio' => '49900.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 20:56:28',
                'updated_at' => '2024-12-04 20:56:28',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 14,
                'nombre' => 'Flores de Bach VIP Control',
                'categoria_servicio_id' => 6,
                'precio' => '25900.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 20:56:28',
                'updated_at' => '2024-12-04 20:56:28',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 15,
                'nombre' => 'Evolet Fonoaudiología',
                'categoria_servicio_id' => 7,
                'precio' => '27900.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 20:56:28',
                'updated_at' => '2024-12-04 20:56:28',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 16,
                'nombre' => 'Evolet TOC',
                'categoria_servicio_id' => 5,
                'precio' => '27900.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 20:56:28',
                'updated_at' => '2024-12-04 20:56:28',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 18,
                'nombre' => 'Intervención Clínica Menores 4 años',
                'categoria_servicio_id' => 1,
                'precio' => '30000.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 20:56:28',
                'updated_at' => '2024-12-04 20:56:28',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 19,
                'nombre' => 'Entrega de Informe',
                'categoria_servicio_id' => 5,
                'precio' => '20000.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 20:56:28',
                'updated_at' => '2024-12-04 20:56:28',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 20,
                'nombre' => 'Pack 5  Intervenciones Toc',
                'categoria_servicio_id' => 5,
                'precio' => '134900.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 20:56:28',
                'updated_at' => '2024-12-04 20:56:28',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 21,
                'nombre' => 'Lifting Pestañas Laminado , Full Vitaminas y Botox',
                'categoria_servicio_id' => 8,
                'precio' => '25000.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 21:01:09',
                'updated_at' => '2024-12-04 21:01:09',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 22,
                'nombre' => 'Intervención Clínica Hermanos',
                'categoria_servicio_id' => 1,
                'precio' => '30000.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 21:01:09',
                'updated_at' => '2024-12-04 21:01:09',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 23,
                'nombre' => 'Control Nutrición',
                'categoria_servicio_id' => 10,
                'precio' => '23000.00',
                'descripcion' => NULL,
                'duracion' => NULL,
                'created_at' => '2024-12-04 21:01:09',
                'updated_at' => '2024-12-04 21:01:09',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 24,
                'nombre' => 'Intervención Social 2',
                'categoria_servicio_id' => 1,
                'precio' => '10000.00',
                'descripcion' => NULL,
                'duracion' => 30,
                'created_at' => '2024-12-09 19:34:34',
                'updated_at' => '2024-12-09 19:34:34',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}