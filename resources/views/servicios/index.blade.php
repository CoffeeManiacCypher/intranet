@extends('layouts.module')

@section('title', 'Módulo de Servicios')

@vite(['resources/js/global/utilidades.js', 'resources/js/global/paginacion.js'])
@vite(['resources/css/servicios/servicios.css', 'resources/js/servicios/servicios.js'])

@section('sidebar')
    <button class="sidebar-content" onclick="window.location='{{ route('servicios.index') }}'">
        <i class="fa-regular fa-list-alt"></i> Registro de Servicios
    </button>
    <button class="sidebar-content" onclick="window.location='{{ route('servicios.create') }}'">
        <i class="fa-regular fa-plus-square"></i> Añadir Servicio
    </button>

@endsection

@section('content')
<div class="servicios-container">
    <!-- Acciones generales -->
    <div class="servicios-acciones">

    </div>
    <div class="tabla-controles-container">

        <div class="tabla-controles">
            <label for="rows-per-page">Mostrar:</label>
            <select id="rows-per-page" onchange="window.location='{{ url()->current() }}?per_page=' + this.value">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
            </select>
        </div>

        <div class="tabla-navegacion">
            {{ $servicios->links() }}
        </div>

    </div>

    <!-- Botón para abrir filtros -->
    <button id="boton-filtro">
        <i class="fa-solid fa-filter"></i>
    </button>
    <div class="filtro-contenedor" id="filtros-contenedor">
        <h3>Filtros</h3>
        <form id="filtros-form">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" placeholder="Buscar por nombre">

            <label for="categoria_id">Categoría:</label>
            <select id="categoria_id" name="categoria_id">
                <option value="">Todas</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>

            <label for="precio_min">Precio Mínimo:</label>
            <input type="number" id="precio_min" name="precio_min">

            <label for="precio_max">Precio Máximo:</label>
            <input type="number" id="precio_max" name="precio_max">

            <button type="button" class="btn btn-primary" onclick="actualizarTabla()">Aplicar Filtros</button>
        </form>
    </div>

    <!-- Tabla de Servicios -->
    <div class="servicios-tabla">
        <div class="tabla-scroll">
            <table class="tabla-dinamica">
                <thead>
                    <tr>

                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                 
                    </tr>
                </thead>

                <tbody>
                    @foreach ($servicios as $servicio)
                        <tr data-servicio-id="{{ $servicio->id }}" data-has-modal="true">

                            <td>{{ $servicio->id }}</td>
                            <td>{{ $servicio->nombre }}</td>
                            <td>{{ $servicio->categoria->nombre ?? 'Sin Categoría' }}</td>

                            <td>{{ '$' . number_format($servicio->precio, 0, ',', '.') }}</td>
            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- Modales -->
<!-- Modal de Información del Servicio -->
<div id="modal-informacion-servicio" class="modal">
    <div class="modal-content">
        <button class="btn-close" onclick="cerrarModal('modal-informacion-servicio')">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <h2>Información del Servicio</h2>
        <div id="detalle-servicio">
            <p><strong>ID:</strong> <span id="detalle-id"></span></p>
            <p><strong>Nombre:</strong> <span id="detalle-nombre"></span></p>
            <p><strong>Categoría:</strong> <span id="detalle-categoria"></span></p>
            <p><strong>Precio:</strong> <span id="detalle-precio"></span></p>
            <p><strong>Duración:</strong> <span id="detalle-duracion"></span></p>
            <p><strong>Descripción:</strong> <span id="detalle-descripcion"></span></p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-sm btn-primary" onclick="abrirModalEditar()">
                <i class="fa-solid fa-pen"></i> Editar
            </button>
            <button class="btn btn-sm btn-danger" onclick="abrirModalEliminar()">
                <i class="fa-solid fa-trash"></i> Eliminar
            </button>
        </div>
    </div>
</div>
<div id="modal-editar-servicio" class="modal">
    <div class="modal-content">
        <button class="btn-close" onclick="cerrarModal('modal-editar-servicio')">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <h2>Editar Servicio</h2>
        <form id="form-editar-servicio" method="POST" action="/servicios/{{ $servicio->id }}">
            @csrf
            @method('PUT') <!-- Necesario para que Laravel trate esto como una solicitud PUT -->
            <div class="form-group">
                <label for="editar-nombre">Nombre:</label>
                <input type="text" id="editar-nombre" name="nombre" class="form-control">
            </div>

            <div class="form-group">
                <label for="editar-categoria_id">Categoría:</label>
                <select id="editar-categoria_id" name="categoria_id" class="form-control select2">
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="editar-precio">Precio:</label>
                <input type="number" id="editar-precio" name="precio" class="form-control">
            </div>

            <div class="form-group">
                <label for="editar-duracion">Duración (minutos):</label>
                <input type="number" id="editar-duracion" name="duracion" class="form-control">
            </div>

            <div class="form-group">
                <label for="editar-descripcion">Descripción:</label>
                <textarea id="editar-descripcion" name="descripcion" class="form-control"></textarea>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-eliminar-servicio" class="modal">
    <div class="modal-content">
        <button class="btn-close" onclick="cerrarModal('modal-eliminar-servicio')">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <h2>Confirmar Eliminación</h2>
        <p>¿Estás seguro de que deseas eliminar este servicio? Esta acción no se puede deshacer.</p>
        <div class="modal-footer">
            <button class="btn btn-danger" id="confirmar-eliminar-servicio">Eliminar</button>
        </div>
    </div>
</div>
@endsection
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
