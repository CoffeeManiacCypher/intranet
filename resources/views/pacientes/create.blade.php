@extends('layouts.module')

@vite(['resources/css/pacientes/create.css', 'resources/js/pacientes/create.js'])
@vite(['resources/css/pacientes/pacientes.css'])

@section('title', 'Añadir Paciente')

@section('sidebar')
    <button class="sidebar-content" data-url="{{ route('pacientes.index') }}">
        Registro de Pacientes
    </button>
    <button class="sidebar-content" data-url="{{ route('pacientes.create') }}">
        Añadir Paciente
    </button>

@endsection

@section('content')
<div class="pacientes-create-form">

    <!-- Mostrar errores de validación -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Mostrar mensaje de éxito -->
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('pacientes.store') }}" id="form-paciente">
        @csrf

        <!-- RUT -->
        <div class="input-container @error('rut') error @enderror">
            <div class="input-group">
                <input type="text" id="rut" name="rut" class="input" placeholder=" " 
                       pattern="\d{1,2}\.\d{3}\.\d{3}-[0-9Kk]" title="Ingrese un RUT válido" 
                       value="{{ old('rut') }}">
                <label for="rut" class="label">RUT</label>
            </div>
            @error('rut')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Nombres -->
        <div class="input-container @error('nombres') error @enderror">
            <div class="input-group">
                <input type="text" id="nombres" name="nombres" class="input" placeholder=" " value="{{ old('nombres') }}" required>
                <label for="nombres" class="label">Nombres</label>
            </div>
            @error('nombres')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Apellidos -->
        <div class="input-container @error('apellidos') error @enderror">
            <div class="input-group">
                <input type="text" id="apellidos" name="apellidos" class="input" placeholder=" " value="{{ old('apellidos') }}" required>
                <label for="apellidos" class="label">Apellidos</label>
            </div>
            @error('apellidos')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email -->
        <div class="input-container @error('email') error @enderror">
            <div class="input-group">
                <input type="email" id="email" name="email" class="input" placeholder=" " value="{{ old('email') }}">
                <label for="email" class="label">Email</label>
            </div>
            @error('email')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Teléfono -->
        <div class="input-container @error('telefono') error @enderror">
            <div class="input-group">
                <input type="text" id="telefono" name="telefono" class="input" placeholder=" " 
                       pattern="\+?56[0-9]{9}" title="Ingrese un teléfono válido (ejemplo: +56912345678)" 
                       value="{{ old('telefono') }}">
                <label for="telefono" class="label">Teléfono</label>
            </div>
            @error('telefono')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Dirección -->
        <div class="input-container">
            <div class="input-group">
                <input type="text" id="direccion" name="direccion" class="input" placeholder=" " value="{{ old('direccion') }}">
                <label for="direccion" class="label">Dirección</label>
            </div>
        </div>

        <!-- Ciudad -->
        <div class="input-container @error('ciudad_id') error @enderror">
            <div class="input-group">
                <select id="ciudad_id" name="ciudad_id" class="input">
                    <option value="" selected>Seleccione una ciudad</option>
                    @foreach ($ciudades as $ciudad)
                        <option value="{{ $ciudad->id }}" {{ old('ciudad_id') == $ciudad->id ? 'selected' : '' }}>
                            {{ $ciudad->nombre }}
                        </option>
                    @endforeach
                </select>
                <label for="ciudad_id" class="label">Ciudad</label>
            </div>
            @error('ciudad_id')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Fecha de Nacimiento -->
        <div class="input-container @error('fecha_nacimiento') error @enderror">
            <div class="input-group">
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="input" value="{{ old('fecha_nacimiento') }}" required>
                <label for="fecha_nacimiento" class="label">Fecha de Nacimiento</label>
            </div>
            @error('fecha_nacimiento')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Género -->
        <div class="input-container @error('genero') error @enderror">
            <div class="input-group">
                <select id="genero" name="genero" class="input" required>
                    <option value="">Seleccione un género</option>
                    <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                    <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                </select>
                <label for="genero" class="label">Género</label>
            </div>
            @error('genero')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Comentario Adicional -->
        <div class="input-container">
            <div class="input-group">
                <input type="text" id="comentario_adicional" name="comentario_adicional" class="input" placeholder=" " value="{{ old('comentario_adicional') }}">
                <label for="comentario_adicional" class="label">Comentario adicional</label>
            </div>
        </div>

        <!-- Botón de Guardar -->
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>

<!-- Modal de confirmación -->
<div id="unsaved-changes-modal" class="modal">
    <div class="modal-content">
        <h2>Cambios sin guardar</h2>
        <p>Tienes cambios sin guardar. ¿Qué deseas hacer?</p>
        <div class="modal-actions">
            <button id="discard-changes" class="btn btn-danger">Descartar cambios</button>
            <button id="continue-editing" class="btn btn-secondary">Continuar editando</button>
        </div>
    </div>
</div>
@endsection