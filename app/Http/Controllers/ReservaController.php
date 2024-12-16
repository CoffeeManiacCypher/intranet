<<<<<<< HEAD
<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Paciente;
use App\Models\Servicio;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $reservas = Reserva::with(['paciente', 'servicio', 'personal'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return view('reservas.index', compact('reservas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pacientes = Paciente::all();
        $servicios = Servicio::all();
        $personal = Personal::all();

        return view('reservas.create', compact('pacientes', 'servicios', 'personal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|exists:pacientes,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'personal_id' => 'nullable|exists:personal,id',
            'fecha_reserva' => 'required|date',
            'estado_pago' => 'required|in:Pagado,Pendiente',
            'asistencia' => 'nullable|in:Asistió,No asistió,Cancelado,Pendiente',
            'precio' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            Reserva::create($request->all());
            return redirect()->route('reservas.index')->with('success', 'Reserva creada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear la reserva: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al crear la reserva.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $reserva = Reserva::with(['paciente', 'servicio', 'personal'])->findOrFail($id);
        $pacientes = Paciente::all();
        $servicios = Servicio::all();
        $personal = Personal::all();

        return view('reservas.edit', compact('reserva', 'pacientes', 'servicios', 'personal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|exists:pacientes,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'personal_id' => 'nullable|exists:personal,id',
            'fecha_reserva' => 'required|date',
            'estado_pago' => 'required|in:Pagado,Pendiente',
            'asistencia' => 'nullable|in:Asistió,No asistió,Cancelado,Pendiente',
            'precio' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $reserva = Reserva::findOrFail($id);
            $reserva->update($request->all());
            return redirect()->route('reservas.index')->with('success', 'Reserva actualizada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar la reserva: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al actualizar la reserva.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $reserva = Reserva::findOrFail($id);
            $reserva->delete();
            return redirect()->route('reservas.index')->with('success', 'Reserva eliminada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar la reserva: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al eliminar la reserva.');
        }
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        try {
            $reserva = Reserva::withTrashed()->findOrFail($id);
            $reserva->restore();
            return redirect()->route('reservas.index')->with('success', 'Reserva restaurada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al restaurar la reserva: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al restaurar la reserva.');
        }
    }
    public function createqr()
    {


        return view('reservas.createqr');
    }
    
    public function reservasPorPaciente($pacienteId)
    {
        try {
            // Validar que el paciente exista
            $paciente = Paciente::findOrFail($pacienteId);
    
            // Obtener las reservas del paciente, incluyendo los servicios y el personal asociado
            $reservas = Reserva::with(['servicio', 'personal'])
                ->where('paciente_id', $pacienteId)
                ->get();
    
            return response()->json($reservas);
        } catch (\Exception $e) {
            Log::error('Error al obtener reservas para el paciente: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudieron obtener las reservas del paciente.'], 500);
        }
    }
}
=======
<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Paciente;
use App\Models\Servicio;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $reservas = Reserva::with(['paciente', 'servicio', 'personal'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return view('reservas.index', compact('reservas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pacientes = Paciente::all();
        $servicios = Servicio::all();
        $personal = Personal::all();

        return view('reservas.create', compact('pacientes', 'servicios', 'personal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|exists:pacientes,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'personal_id' => 'nullable|exists:personal,id',
            'fecha_reserva' => 'required|date',
            'estado_pago' => 'required|in:Pagado,Pendiente',
            'asistencia' => 'nullable|in:Asistió,No asistió,Cancelado,Pendiente',
            'precio' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            Reserva::create($request->all());
            return redirect()->route('reservas.index')->with('success', 'Reserva creada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear la reserva: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al crear la reserva.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $reserva = Reserva::with(['paciente', 'servicio', 'personal'])->findOrFail($id);
        $pacientes = Paciente::all();
        $servicios = Servicio::all();
        $personal = Personal::all();

        return view('reservas.edit', compact('reserva', 'pacientes', 'servicios', 'personal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'paciente_id' => 'required|exists:pacientes,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'personal_id' => 'nullable|exists:personal,id',
            'fecha_reserva' => 'required|date',
            'estado_pago' => 'required|in:Pagado,Pendiente',
            'asistencia' => 'nullable|in:Asistió,No asistió,Cancelado,Pendiente',
            'precio' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $reserva = Reserva::findOrFail($id);
            $reserva->update($request->all());
            return redirect()->route('reservas.index')->with('success', 'Reserva actualizada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar la reserva: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al actualizar la reserva.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $reserva = Reserva::findOrFail($id);
            $reserva->delete();
            return redirect()->route('reservas.index')->with('success', 'Reserva eliminada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar la reserva: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al eliminar la reserva.');
        }
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        try {
            $reserva = Reserva::withTrashed()->findOrFail($id);
            $reserva->restore();
            return redirect()->route('reservas.index')->with('success', 'Reserva restaurada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al restaurar la reserva: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al restaurar la reserva.');
        }
    }
    public function createqr()
    {


        return view('reservas.createqr');
    }
    
    public function reservasPorPaciente($pacienteId)
    {
        try {
            // Validar que el paciente exista
            $paciente = Paciente::findOrFail($pacienteId);
    
            // Obtener las reservas del paciente, incluyendo los servicios y el personal asociado
            $reservas = Reserva::with(['servicio', 'personal'])
                ->where('paciente_id', $pacienteId)
                ->get();
    
            return response()->json($reservas);
        } catch (\Exception $e) {
            Log::error('Error al obtener reservas para el paciente: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudieron obtener las reservas del paciente.'], 500);
        }
    }
}
>>>>>>> f54984645166dd5ed8a43c1a794037308fcf7b95
