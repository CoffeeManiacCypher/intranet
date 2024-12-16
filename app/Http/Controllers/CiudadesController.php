<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use Illuminate\Http\Request;

class CiudadesController extends Controller
{
    /**
     * Muestra la lista de ciudades.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $ciudades = Ciudad::paginate($perPage);

        // Retornar JSON si es una solicitud AJAX
        if ($request->ajax()) {
            return response()->json($ciudades);
        }

        return view('ciudades.index', compact('ciudades'));
    }

    /**
     * Muestra el formulario para añadir una nueva ciudad.
     */
    public function create()
    {
        return view('ciudades.create');
    }

    /**
     * Almacena una nueva ciudad.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:ciudades,nombre',
        ]);

        Ciudad::create($validatedData);

        return redirect()->route('ciudades.index')->with('success', 'Ciudad creada correctamente.');
    }

    /**
     * Muestra el formulario para editar una ciudad existente.
     */
    public function edit($id)
    {
        $ciudad = Ciudad::findOrFail($id);
        return view('ciudades.edit', compact('ciudad'));
    }

    /**
     * Actualiza los datos de una ciudad existente.
     */
    public function update(Request $request, $id)
    {
        $ciudad = Ciudad::findOrFail($id);

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:ciudades,nombre,' . $ciudad->id,
        ]);

        $ciudad->update($validatedData);

        return redirect()->route('ciudades.index')->with('success', 'Ciudad actualizada correctamente.');
    }

    /**
     * Elimina lógicamente una ciudad.
     */
    public function destroy($id)
    {
        $ciudad = Ciudad::findOrFail($id);
        $ciudad->delete(); // Soft delete
        return redirect()->route('ciudades.index')->with('success', 'Ciudad eliminada correctamente.');
    }

    /**
     * Restaura una ciudad eliminada lógicamente.
     */
    public function restore($id)
    {
        $ciudad = Ciudad::withTrashed()->findOrFail($id);
        $ciudad->restore();
        return redirect()->route('ciudades.index')->with('success', 'Ciudad restaurada correctamente.');
    }
}
