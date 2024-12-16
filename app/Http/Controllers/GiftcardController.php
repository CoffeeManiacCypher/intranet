<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Promocion;
use App\Models\Personal;
use App\Models\Giftcard;
use Illuminate\Http\Request;

class GiftcardController extends Controller
{
    /**
     * Mostrar la lista de giftcards.
     */
    public function index(Request $request)
    {
        try {
            $query = Giftcard::with(['comprador', 'beneficiador', 'trabajador', 'promocion']);
    
            // Filtro por estado
            if ($request->filled('estatus_giftcard')) {
                $query->where('estatus_giftcard', $request->input('estatus_giftcard'));
            }
    
            // Filtro por rango de fechas
            if ($request->filled('fecha_inicio')) {
                $query->where('fecha_expiracion', '>=', $request->input('fecha_inicio'));
            }
            if ($request->filled('fecha_fin')) {
                $query->where('fecha_expiracion', '<=', $request->input('fecha_fin'));
            }
    
            // Filtro por rango de valor
            if ($request->filled('valor_min')) {
                $query->where('valor', '>=', (float) $request->input('valor_min'));
            }
            if ($request->filled('valor_max')) {
                $query->where('valor', '<=', (float) $request->input('valor_max'));
            }
    
            // Paginación
            $perPage = (int) $request->get('per_page', 10);
            $giftcards = $query->paginate($perPage);
    
            if ($request->ajax()) {
                return response()->json($giftcards);
            }
    
            return view('giftcards.index', compact('giftcards'));
        } catch (\Exception $e) {
            \Log::error('Error al filtrar Giftcards: ' . $e->getMessage());
            return response()->json(['message' => 'Ocurrió un error al filtrar las Giftcards.'], 500);
        }
    }
    
    
    
    /**
     * Obtener opciones dinámicas para el dropdown (API).
     */
    public function apiPacientes()
    {
        $pacientes = Paciente::select('id', 'nombres', 'apellidos')->get();
        return response()->json($pacientes);
    }
    

    public function apiPromociones()
    {
        $promociones = Promocion::select('id', 'nombre')->get();
        return response()->json($promociones);
    }
    

    public function apiPersonal()
    {
        $personal = Personal::select('id', 'nombres', 'apellidos')->get();
        return response()->json($personal);
    }
    
    /**
     * Mostrar el formulario para crear una nueva giftcard.
     */
    public function create()
    {
        $pacientes = Paciente::all();
        $promociones = Promocion::all();
        $trabajadores = Personal::all();

        return view('giftcards.create', compact('pacientes', 'promociones', 'trabajadores'));
    }

    /**
     * Almacenar una nueva giftcard en la base de datos.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'comprado_por' => 'nullable|exists:pacientes,id',
                'beneficiador_id' => 'nullable|exists:pacientes,id',
                'trabajador_id' => 'nullable|exists:personal,id',
                'promocion_id' => 'nullable|exists:promociones,id',
                'valor' => 'nullable|numeric|min:0',
                'mensaje_personalizado' => 'nullable|string',
            ]);
    
            // Generar las fechas automáticamente
            $validated['fecha_compra'] = now()->toDateString(); // Fecha actual
            $validated['fecha_expiracion'] = now()->addMonths(2)->toDateString(); // Dos meses después
            $validated['estatus_giftcard'] = 'activa';
    
            // Crear la giftcard
            $giftcard = Giftcard::create($validated);
    
            // Responder en JSON
            return response()->json([
                'success' => true,
                'message' => 'Giftcard creada exitosamente.',
                'data' => $giftcard,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la giftcard.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Mostrar el formulario para editar una giftcard.
     */
    public function edit(Giftcard $giftcard)
    {
        $pacientes = Paciente::all();
        $promociones = Promocion::all();
        $trabajadores = Personal::all();

        return view('giftcards.edit', compact('giftcard', 'pacientes', 'promociones', 'trabajadores'));
    }

    /**
     * Actualizar una giftcard existente.
     */
    public function update(Request $request, Giftcard $giftcard)
    {
        $validated = $request->validate([
            'comprado_por' => 'nullable|exists:pacientes,id',
            'beneficiador_id' => 'nullable|exists:pacientes,id',
            'trabajador_id' => 'nullable|exists:personal,id',
            'promocion_id' => 'nullable|exists:promociones,id',
            'valor' => 'required|numeric|min:0',
            'mensaje_personalizado' => 'nullable|string',
            'fecha_compra' => 'required|date',
            'fecha_expiracion' => 'required|date|after_or_equal:fecha_compra',
        ]);

        $giftcard->update($validated);

        return response(null, 204); // Responder sin contenido, ya que las alertas se manejan en el frontend.
    }

    /**
     * Eliminar (soft delete) una giftcard.
     */
    public function destroy(Giftcard $giftcard)
    {
        $giftcard->delete(); // Realiza el SoftDelete
        return response(null, 204); // Responder sin contenido, ya que las alertas se manejan en el frontend.
    }
    

    /**
     * Restaurar una giftcard eliminada lógicamente.
     */
    public function restore($id)
    {
        $giftcard = Giftcard::withTrashed()->findOrFail($id);
        $giftcard->restore();

        return redirect()->route('giftcard.index')->with('success', 'Giftcard restaurada exitosamente.');
    }

    /**
     * Mostrar giftcards eliminadas lógicamente.
     */
    public function trashed(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $giftcards = Giftcard::onlyTrashed()
            ->with(['comprador:id,nombres', 'beneficiador:id,nombres', 'trabajador:id,nombres', 'promocion:id,nombre'])
            ->paginate($perPage);

        return view('giftcards.trashed', compact('giftcards'));
    }

    public function cobrar($id)
    {
        $giftcard = Giftcard::find($id);

        if (!$giftcard || $giftcard->estatus_giftcard === 'cobrada') {
            return response()->json(['message' => 'Giftcard no encontrada o ya cobrada'], 400);
        }

        $giftcard->estatus_giftcard = 'cobrada';
        $giftcard->fecha_cobro = now();
        $giftcard->save();

        return response()->json(['message' => 'Giftcard cobrada exitosamente']);
    }
    /**
     * Obtener las Giftcards relacionadas a un paciente específico.
     */
    public function giftcardsPorPaciente($pacienteId)
    {
        try {
            // Validar que el paciente exista
            $paciente = Paciente::findOrFail($pacienteId);
    
            // Obtener las Giftcards relacionadas al paciente (compradas o beneficiadas por él)
            $giftcards = Giftcard::with([
                'comprador',
                'beneficiador',
                'trabajador',
                'promocion',
            ])
            ->where('comprado_por', $pacienteId)
            ->orWhere('beneficiador_id', $pacienteId)
            ->get()
            ->map(function ($giftcard) {
                return [
                    'id' => $giftcard->id,
                    'promocion_nombre' => $giftcard->promocion->nombre ?? 'Sin promoción',
                    'fecha_compra' => $giftcard->fecha_compra,
                    'fecha_vencimiento' => $giftcard->fecha_expiracion,
                    'valor' => $giftcard->valor,
                    'estatus_giftcard' => $giftcard->estatus_giftcard,
                    'beneficiador_nombre' => $giftcard->beneficiador
                        ? $giftcard->beneficiador->nombres . ' ' . $giftcard->beneficiador->apellidos
                        : 'Sin beneficiario',
                    'trabajador_nombre' => $giftcard->trabajador
                        ? $giftcard->trabajador->nombres . ' ' . $giftcard->trabajador->apellidos
                        : 'Sin trabajador asignado',
                ];
            });
    
            return response()->json($giftcards);
        } catch (\Exception $e) {
            \Log::error('Error al obtener Giftcards para el paciente: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudieron obtener las Giftcards del paciente.'], 500);
        }
    }
    


    
}
