@extends('layouts.module')

@section('title', 'Añadir Servicio')
@vite(['resources/css/servicios/create.css', 'resources/js/servicios/create.js'])
@section('sidebar')
    <button class="sidebar-content" onclick="window.location='{{ route('servicios.index') }}'">
        <i class="fa-regular fa-list-alt"></i> Registro de Servicios
    </button>
    <button class="sidebar-content" onclick="window.location='{{ route('servicios.create') }}'">
        <i class="fa-regular fa-plus-square"></i> Añadir Servicio
    </button>

@endsection
@section('content')
<div class="formulario-container">
    <h2>Añadir Nuevo Servicio</h2>
    <form id="form-crear-servicio" method="POST" action="{{ route('servicios.store') }}">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre del servicio" required>
        </div>

        <div class="form-group">
            <label for="categoria_id">Categoría:</label>
            <select name="categoria_servicio_id" required>
                <option value="">Seleccione una categoría</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>

        </div>

        <div class="form-group">
            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" class="form-control" placeholder="Precio en CLP" required>
        </div>

        <div class="form-group">
            <label for="duracion">Duración (minutos):</label>
            <input type="number" id="duracion" name="duracion" class="form-control" placeholder="Duración en minutos">
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" class="form-control" placeholder="Descripción del servicio"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Servicio</button>
        <a href="{{ route('servicios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
