<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Ciudad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class PacientesController extends Controller
{
    /**
     * Muestra la lista de pacientes junto con las ciudades relacionadas.
     */
    public function index(Request $request)
    {
        // Actualizar automáticamente el estado de los pacientes que cumplen con los requisitos
        try {
            Paciente::where('estado_info', 'pendiente')
                ->whereNotNull('rut')
                ->whereNotNull('nombres')
                ->whereNotNull('apellidos')
                ->where('rut', '!=', '')
                ->where('nombres', '!=', '')
                ->where('apellidos', '!=', '')
                ->update(['estado_info' => 'verificado']);
        } catch (\Exception $e) {
            // Manejar el error si algo falla durante la actualización
            return back()->withErrors(['error' => 'Error al actualizar los estados de los pacientes: ' . $e->getMessage()]);
        }
    
        // Obtener los pacientes con la paginación correspondiente
        $perPage = $request->input('per_page', 10);
        $query = Paciente::with(['ciudad'])->whereNull('deleted_at');
    
        // Aplicar filtros
        if ($request->filled('nombre')) {
            $query->where('nombres', 'like', '%' . $request->nombre . '%')
                  ->orWhere('apellidos', 'like', '%' . $request->nombre . '%');
        }
    
        if ($request->filled('rut')) {
            $query->where('rut', 'like', '%' . $request->rut . '%');
        }
    
        if ($request->filled('correo')) {
            $query->where('email', 'like', '%' . $request->correo . '%');
        }
    
        if ($request->filled('estado_info')) {
            $query->where('estado_info', $request->estado_info);
        }
    
        if ($request->filled('telefono')) {
            $query->where('telefono', 'like', '%' . $request->telefono . '%');
        }
    
        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }
    
        if ($request->filled('ciudad')) {
            $query->where('ciudad_id', $request->ciudad);
        }
    
        $pacientes = $query->paginate($perPage);
    
        // Retornar JSON si es una solicitud AJAX
        if ($request->ajax()) {
            return response()->json($pacientes);
        }
    
        $ciudades = Ciudad::all();
    
        return view('pacientes.index', compact('pacientes', 'ciudades'));
    }
    public function actualizarEstadoPacientes()
    {
        try {
            // Obtener todos los pacientes cuyo estado es 'pendiente'
            $pacientesPendientes = Paciente::where('estado_info', 'pendiente')
                ->whereNotNull('rut')
                ->whereNotNull('nombres')
                ->whereNotNull('apellidos')
                ->get();
    
            // Actualizar el estado a 'verificado' si cumplen con los requisitos
            foreach ($pacientesPendientes as $paciente) {
                if (!empty($paciente->rut) && !empty($paciente->nombres) && !empty($paciente->apellidos)) {
                    $paciente->update(['estado_info' => 'verificado']);
                }
            }
    
            return response()->json(['message' => 'Estado de los pacientes actualizado con éxito.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el estado de los pacientes: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Muestra el formulario para añadir un nuevo paciente.
     */
    public function create()
    {
        $ciudades = Ciudad::all();

        return view('pacientes.create', compact('ciudades'));
    }

    /**
     * Valida los datos antes de guardar o registrar un paciente.
     */
    public function validarDatos(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email|unique:pacientes,email',
            'rut' => 'nullable|string|unique:pacientes,rut',
        ]);

        return response()->json(['valid' => true]);
    }

    /**
     * Almacena un nuevo paciente.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validación de datos
            $validated = $request->validate([
                'rut' => 'nullable|string|max:15|unique:pacientes,rut',
                'nombres' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'telefono' => 'nullable|string|max:15',
                'comentario_adicional' => 'nullable|string|max:255',
                'direccion' => 'nullable|string|max:255',
                'ciudad_id' => 'nullable|exists:ciudades,id',
                'email' => 'nullable|email|unique:pacientes,email',
                'genero' => 'required|in:Masculino,Femenino,Otro',
                'fecha_nacimiento' => 'nullable|date',
            ]);

            // Asignar estado_info
            $validated['estado_info'] = ($validated['rut'] && $validated['nombres'] && $validated['apellidos']) ? 'verificado' : 'pendiente';

            // Crear y guardar el paciente
            $paciente = Paciente::create($validated);

            DB::commit(); // Confirmar transacción

            return redirect()->route('pacientes.index')->with('success', 'Paciente creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack(); // Revertir los cambios si ocurre un error
            return back()->withErrors(['error' => 'Error al guardar el paciente: ' . $e->getMessage()]);
        }
    }

    /**
     * Actualiza los datos del paciente existente.
     */
    public function update(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);

        $validated = $request->validate([
            'rut' => [
                'nullable', 'string', 'max:15',
                Rule::unique('pacientes', 'rut')->ignore($paciente->id),
            ],
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:15',
            'comentario_adicional' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'ciudad_id' => 'nullable|exists:ciudades,id',
            'email' => [
                'nullable', 'email', 'max:255',
                Rule::unique('pacientes', 'email')->ignore($paciente->id),
            ],
            'genero' => 'required|in:Masculino,Femenino,Otro',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        // Asignar estado_info
        $validated['estado_info'] = ($validated['rut'] && $validated['nombres'] && $validated['apellidos']) ? 'verificado' : 'pendiente';

        $paciente->update($validated);

        return response()->json(['message' => 'Paciente actualizado con éxito.']);
    }

    /**
     * Elimina (lógicamente) un paciente.
     */
    public function destroy($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->delete(); // Soft delete

        return response()->json(['message' => 'Paciente eliminado con éxito.']);
    }

    /**
     * Restaura un paciente eliminado.
     */
    public function restore($id)
    {
        $paciente = Paciente::withTrashed()->findOrFail($id);
        $paciente->restore(); // Restaurar paciente

        return response()->json(['message' => 'Paciente restaurado con éxito.']);
    }

    /**
     * Muestra la información detallada de un paciente.
     */
    public function show($id)
    {
        $paciente = Paciente::with(['ciudad'])->findOrFail($id);
        return response()->json($paciente);
    }

    public function apiResumenPaciente($id)
    {
        $paciente = Paciente::with('reservas.servicio')->find($id);
    
        if (!$paciente) {
            return response()->json(['error' => 'Paciente no encontrado.'], 404);
        }
    
        // Total de reservas
        $totalReservas = $paciente->reservas->count();
    
        // Calcular el porcentaje de asistencia (solo las asistencias válidas)
        $asistenciasValidas = $paciente->reservas->where('asistencia', 'Asistió')->count();
        $porcentajeAsistencia = $totalReservas > 0 ? round(($asistenciasValidas / $totalReservas) * 100, 2) : 0;
    
        // Calcular asistencias en porcentajes para el gráfico
        $estadoAsistencias = [
            'Asistió' => $paciente->reservas->where('asistencia', 'Asistió')->count(),
            'No asistió' => $paciente->reservas->where('asistencia', 'No asistió')->count(),
            'Cancelado' => $paciente->reservas->where('asistencia', 'Cancelado')->count(),
            'Pendiente' => $paciente->reservas->where('asistencia', 'Pendiente')->count()
        ];
    
        $asistenciasPorcentajes = array_map(function ($cantidad) use ($totalReservas) {
            return $totalReservas > 0 ? round(($cantidad / $totalReservas) * 100, 2) : 0;
        }, $estadoAsistencias);
    
        // Sumar el valor total de los servicios adquiridos
        $valorTotalServicios = $paciente->reservas->sum('precio');
    
        return response()->json([
            'asistencias' => $asistenciasPorcentajes,
            'valor_total_servicios' => $valorTotalServicios,
            'porcentaje_asistencia' => $porcentajeAsistencia,
            'total_reservas' => $totalReservas,
            'estado_asistencias' => $estadoAsistencias // Valores absolutos, por si se necesitan.
        ]);
    }
    
    
    
    
    
}
