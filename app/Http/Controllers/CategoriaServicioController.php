<<<<<<< HEAD
<?php

namespace App\Http\Controllers;

use App\Models\CategoriaServicio;
use Illuminate\Http\Request;

class CategoriaServicioController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $categorias = CategoriaServicio::paginate($perPage);

        return view('categoriaservicio.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|string',
        ]);

        CategoriaServicio::create($validatedData);

        return response()->json(['message' => 'Categoría creada exitosamente.'], 201);
    }

    public function destroy($id)
    {
        $categoria = CategoriaServicio::findOrFail($id);
        $categoria->delete();

        return response()->json(['message' => 'Categoría eliminada exitosamente.']);
    }
=======
<?php

namespace App\Http\Controllers;

use App\Models\CategoriaServicio;
use Illuminate\Http\Request;

class CategoriaServicioController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $categorias = CategoriaServicio::paginate($perPage);

        return view('categoriaservicio.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|string',
        ]);

        CategoriaServicio::create($validatedData);

        return response()->json(['message' => 'Categoría creada exitosamente.'], 201);
    }

    public function destroy($id)
    {
        $categoria = CategoriaServicio::findOrFail($id);
        $categoria->delete();

        return response()->json(['message' => 'Categoría eliminada exitosamente.']);
    }
>>>>>>> f54984645166dd5ed8a43c1a794037308fcf7b95
}