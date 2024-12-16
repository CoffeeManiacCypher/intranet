@extends('layouts.module')

@section('title', 'Módulo de Categorías de Servicios')

@vite(['resources/js/global/utilidades.js', 'resources/js/global/paginacion.js'])
@vite(['resources/css/categoria_servicios/categoria_servicios.css', 'resources/js/categoria_servicios/categoria_servicios.js'])

@section('sidebar')
    <button class="sidebar-content" onclick="window.location='{{ route('servicios.index') }}'">
        Registro de Servicios
    </button>
    <button class="sidebar-content" onclick="window.location='{{ route('servicios.create') }}'">
        Añadir Servicio
    </button>

@endsection

@section('content')
<div class="categorias-container">
    <!-- Acciones generales -->
    <div class="categorias-acciones">
        <button class="btn btn-primary" data-modal-target=".modal-import">
            <i class="bi bi-file-earmark-arrow-down"></i> Importar Categorías
        </button>
        <button class="btn btn-secondary" data-modal-target=".modal-export">
            <i class="bi bi-file-earmark-arrow-up"></i> Exportar Categorías
        </button>
    </div>

    <!-- Tabla de Categorías -->
    <div class="categorias-tabla">
        <!-- Controles de Paginación -->
        <div class="tabla-controles">
            <label for="rows-per-page">Mostrar:</label>
            <select id="rows-per-page" onchange="window.location='{{ url()->current() }}?per_page=' + this.value">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
            </select>
        </div>

        <div class="tabla-scroll">
            <table class="tabla-dinamica">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->id }}</td>
                            <td>{{ $categoria->nombre }}</td>
                            <td>{{ $categoria->descripcion ?? 'Sin descripción' }}</td>
                            <td>
                                <a href="{{ route('categoria_servicios.edit', $categoria->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                <form action="{{ route('categoria_servicios.destroy', $categoria->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Navegación de la tabla -->
        <div class="tabla-navegacion">
            {{ $categorias->links() }}
        </div>
    </div>
</div>
@endsection
