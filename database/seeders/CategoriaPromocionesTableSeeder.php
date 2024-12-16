<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriaPromocionesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categoria_promociones')->delete();
        
        \DB::table('categoria_promociones')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombre' => 'Paquetes Especiales',
                'descripcion' => 'Agrupación de servicios con descuento.',
                'created_at' => '2024-12-04 21:17:53',
                'updated_at' => '2024-12-04 21:17:53',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'nombre' => 'Campañas Estacionales',
                'descripcion' => 'Ofertas para fechas y eventos especiales.',
                'created_at' => '2024-12-04 21:17:53',
                'updated_at' => '2024-12-04 21:17:53',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'nombre' => 'Servicios en Oferta',
                'descripcion' => 'Servicios individuales con un precio reducido.',
                'created_at' => '2024-12-04 21:17:53',
                'updated_at' => '2024-12-04 21:17:53',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}