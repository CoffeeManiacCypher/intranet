@extends('layouts.module')

@section('title', 'Subir Ficha Médica')

@vite(['resources/js/global/utilidades.js', 'resources/js/fichas/create.js'])

@section('content')
<div class="container">
    <h1>Subir Nueva Ficha Médica</h1>
    <form action="{{ route('fichas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Selección del Paciente -->
        <div class="form-group">
            <label for="paciente_id">Paciente:</label>
            <select name="paciente_id" id="paciente_id" class="form-control select2" required>
                <option value="">Seleccione un paciente</option>
            </select>
        </div>

        <!-- Selección del Servicio -->
        <div class="form-group">
            <label for="servicio_id">Servicio:</label>
            <select name="servicio_id" id="servicio_id" class="form-control select2" required>
                <option value="">Seleccione un servicio</option>
            </select>
        </div>

        <!-- Selección del Trabajador -->
        <div class="form-group">
            <label for="trabajador_id">Trabajador:</label>
            <select name="trabajador_id" id="trabajador_id" class="form-control select2" required>
                <option value="">Seleccione un trabajador</option>
            </select>
        </div>

        <!-- Subir Archivo -->
        <div class="form-group">
            <label for="archivo">Archivo (PDF o DOCX):</label>
            <input type="file" name="archivo" id="archivo" class="form-control" accept=".pdf,.docx" required>
        </div>

        <!-- Botón de Envío -->
        <button type="submit" class="btn btn-primary">Subir Ficha Médica</button>
    </form>
</div>
@endsection
