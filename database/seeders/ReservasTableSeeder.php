<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReservasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('reservas')->delete();
        
        \DB::table('reservas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'paciente_id' => 1,
                'servicio_id' => 3,
                'personal_id' => NULL,
                'fecha_reserva' => '2024-12-06 00:00:00',
                'fecha_cobro' => NULL,
                'estado_pago' => 'Pendiente',
                'asistencia' => 'Pendiente',
                'precio' => '19000.00',
                'created_at' => '2024-12-05 11:39:39',
                'updated_at' => '2024-12-05 11:39:39',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'paciente_id' => 2,
                'servicio_id' => 5,
                'personal_id' => NULL,
                'fecha_reserva' => '2024-12-07 00:00:00',
                'fecha_cobro' => NULL,
                'estado_pago' => 'Pagado',
                'asistencia' => 'Asistió',
                'precio' => '9500.00',
                'created_at' => '2024-12-05 11:39:39',
                'updated_at' => '2024-12-05 11:39:39',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'paciente_id' => 3,
                'servicio_id' => 8,
                'personal_id' => NULL,
                'fecha_reserva' => '2024-12-06 00:00:00',
                'fecha_cobro' => NULL,
                'estado_pago' => 'Pendiente',
                'asistencia' => 'No asistió',
                'precio' => '25900.00',
                'created_at' => '2024-12-05 11:39:39',
                'updated_at' => '2024-12-05 11:39:39',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'paciente_id' => 4,
                'servicio_id' => 10,
                'personal_id' => NULL,
                'fecha_reserva' => '2024-12-08 00:00:00',
                'fecha_cobro' => NULL,
                'estado_pago' => 'Pendiente',
                'asistencia' => 'Pendiente',
                'precio' => '27900.00',
                'created_at' => '2024-12-05 11:39:39',
                'updated_at' => '2024-12-05 11:39:39',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'paciente_id' => 5,
                'servicio_id' => 12,
                'personal_id' => NULL,
                'fecha_reserva' => '2024-12-09 00:00:00',
                'fecha_cobro' => NULL,
                'estado_pago' => 'Pagado',
                'asistencia' => 'Asistió',
                'precio' => '0.00',
                'created_at' => '2024-12-05 11:39:39',
                'updated_at' => '2024-12-05 11:39:39',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'paciente_id' => 6,
                'servicio_id' => 15,
                'personal_id' => NULL,
                'fecha_reserva' => '2024-12-10 00:00:00',
                'fecha_cobro' => NULL,
                'estado_pago' => 'Pagado',
                'asistencia' => 'Asistió',
                'precio' => '25900.00',
                'created_at' => '2024-12-05 11:39:39',
                'updated_at' => '2024-12-05 11:39:39',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}