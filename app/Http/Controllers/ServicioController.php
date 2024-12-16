<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\CategoriaServicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $nombre = $request->get('nombre');
        $categoria = $request->get('categoria_id');
        $precioMin = $request->get('precio_min');
        $precioMax = $request->get('precio_max');

        $servicios = Servicio::with(['categoria' => function ($query) {
            $query->select('id', 'nombre');
        }])
        
        ->when($nombre, function ($query, $nombre) {
            $query->where('nombre', 'like', "%$nombre%");
        })
        ->when($categoria, function ($query, $categoria) {
            $query->where('categoria_servicio_id', $categoria);
        })
        
        ->when($precioMin, function ($query, $precioMin) {
            $query->where('precio', '>=', $precioMin);
        })
        ->when($precioMax, function ($query, $precioMax) {
            $query->where('precio', '<=', $precioMax);
        })
        ->paginate($perPage);

        if ($request->ajax()) {
            return response()->json($servicios);
        }

        $categorias = CategoriaServicio::select('id', 'nombre')->get();

        return view('servicios.index', compact('servicios', 'categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_servicio_id' => 'required|exists:categoria_servicios,id', // Cambiar a categoria_servicio_id
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'duracion' => 'nullable|integer|min:0',
        ]);
        
        try {
            Servicio::create($request->all());
            return response()->json(['message' => 'Servicio creado exitosamente.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al crear el servicio', 'error' => $e->getMessage()], 500);
        }
        
    }
    
    public function apiGetServicios()
    {
        try {
            $servicios = Servicio::select('id', 'nombre', 'precio')->get();
            return response()->json($servicios, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los servicios'], 500);
        }
    }
    public function apiGetServicio($id)
    {
        try {
            $servicio = Servicio::with('categoria:id,nombre')
                ->select('id', 'nombre', 'precio', 'descripcion', 'categoria_id')
                ->findOrFail($id);
            return response()->json($servicio, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Servicio no encontrado'], 404);
        }
    }
    public function apiCrearOrden(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:servicios,id',
            'amount' => 'required|numeric|min:0',
        ]);
    
        try {
            $servicio = Servicio::findOrFail($validated['id']);
            $paypalService = new PayPalService(); // Instancia de un servicio personalizado para manejar PayPal
            $orderUrl = $paypalService->crearOrden($validated['amount']);
            
            return response()->json(['approve_url' => $orderUrl], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la orden de pago'], 500);
        }
    }
            
    


    public function edit($id)
    {
        try {
            $servicio = Servicio::with('categoria')->findOrFail($id);
    
            return response()->json([
                'id' => $servicio->id,
                'nombre' => $servicio->nombre,
                'categoria_servicio_id' => $servicio->categoria_servicio_id,
                'categoria_nombre' => $servicio->categoria->nombre ?? null,
                'precio' => $servicio->precio,
                'duracion' => $servicio->duracion,
                'descripcion' => $servicio->descripcion,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al cargar el servicio.', 'error' => $e->getMessage()], 500);
        }
    }
    
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categoria_servicios,id',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'duracion' => 'nullable|integer|min:0',
        ]);
    
        $servicio = Servicio::findOrFail($id);
        $servicio->update($request->all());
    
        return response()->json(['message' => 'Servicio actualizado exitosamente.']);
    }
    public function create()
    {
        $categorias = CategoriaServicio::select('id', 'nombre')->get();
    
        return view('servicios.create', compact('categorias'));
    }
    


    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();

        return response()->json(['message' => 'Servicio eliminado exitosamente.']);
    }

    public function restore($id)
    {
        $servicio = Servicio::onlyTrashed()->findOrFail($id);
        $servicio->restore();

        return response()->json(['message' => 'Servicio restaurado exitosamente.']);
    }
}