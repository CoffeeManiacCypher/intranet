<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FichasMedicasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('fichas_medicas')->delete();
        
        \DB::table('fichas_medicas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'paciente_id' => 1,
                'trabajador_id' => 1,
                'servicio_id' => 6,
                'archivo' => 'fichas_medicas/AX4Y4mFUEw3EKeYiASqqh27ic0Fvc8vefbfE4oh0.pdf',
                'tipo_archivo' => 'pdf',
                'created_at' => '2024-12-15 03:07:23',
                'updated_at' => '2024-12-15 03:07:23',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'paciente_id' => 1,
                'trabajador_id' => 1,
                'servicio_id' => 6,
                'archivo' => 'fichas_medicas/BSfgGQaVBFVd01Jg0xaKxzWX5Tp9dOK303NFCVtV.docx',
                'tipo_archivo' => 'pdf',
                'created_at' => '2024-12-15 03:12:48',
                'updated_at' => '2024-12-15 03:12:48',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}