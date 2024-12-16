<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FichaMedica;
use App\Models\Paciente;
use App\Models\Personal;
use App\Models\Servicio;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FichaMedicaController extends Controller
{
    /**
     * Mostrar la lista de fichas médicas (paginadas).
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $fichas = FichaMedica::with(['paciente', 'servicio', 'trabajador'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return view('fichas.index', compact('fichas'));
    }

    public function apiPacientes()
    {
        $pacientes = Paciente::select('id', 'nombres', 'apellidos')->get();
        return response()->json($pacientes);
    }
    
    public function apiServicios()
    {
        $servicios = Servicio::select('id', 'nombre')->get();
        return response()->json($servicios);
    }
    
    public function apiTrabajadores()
    {
        $trabajadores = Personal::select('id', 'nombres', 'apellidos')->get();
        return response()->json($trabajadores);
    }
    
    /**
     * Subir una nueva ficha médica.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'servicio_id' => 'required|exists:servicios,id',
            'trabajador_id' => 'required|exists:personal,id',
            'archivo' => 'required|mimes:pdf,docx|max:5120', // Máximo 5MB
        ]);
    
        try {
            // Subir el archivo al almacenamiento
            $path = $request->file('archivo')->store('fichas_medicas', 'public');
    
            // Crear la ficha médica
            FichaMedica::create([
                'paciente_id' => $validated['paciente_id'],
                'servicio_id' => $validated['servicio_id'],
                'trabajador_id' => $validated['trabajador_id'],
                'archivo' => $path,
            ]);
    
            return redirect()->route('fichas.create')->with('success', 'Ficha médica subida con éxito.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al subir la ficha médica: ' . $e->getMessage()]);
        }
    }
    

    /**
     * Descargar una ficha médica.
     */
    public function descargar($id)
    {
        $ficha = FichaMedica::findOrFail($id);

        if (Storage::disk('public')->exists($ficha->archivo)) {
            return Storage::disk('public')->download($ficha->archivo);
        }

        return back()->withErrors(['error' => 'El archivo no se encuentra disponible.']);
    }

    /**
     * Eliminar (Soft Delete) una ficha médica.
     */
    public function destroy($id)
    {
        try {
            $ficha = FichaMedica::findOrFail($id);
            $ficha->delete();

            return response()->json(['message' => 'Ficha médica eliminada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la ficha médica: ' . $e->getMessage()], 500);
        }
    }

    /**
     * API: Obtener fichas médicas de un paciente específico.
     */
    public function apiFichasMedicas(Request $request)
    {
        try {
            $query = FichaMedica::with(['paciente', 'trabajador', 'servicio']);
    
            // Filtrar por paciente
            if ($request->filled('paciente_id')) {
                $query->where('paciente_id', $request->paciente_id);
            }
    
            // Filtrar por servicio
            if ($request->filled('servicio_id')) {
                $query->where('servicio_id', $request->servicio_id);
            }
    
            // Filtrar por trabajador
            if ($request->filled('trabajador_id')) {
                $query->where('trabajador_id', $request->trabajador_id);
            }
    
            $fichasMedicas = $query->get();
    
            return response()->json([
                'success' => true,
                'data' => $fichasMedicas,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al obtener las fichas médicas.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function create()
    {
        return view('fichas.create');
    }
    
    
    
}
