@extends('layouts.module')

@section('title', 'Módulo de Reservas')

@vite(['resources/js/global/utilidades.js'])
@vite(['resources/js/global/paginacion.js'])

@vite(['resources/css/reservas/reservas.css', 'resources/js/reservas/reservas.js'])

@section('sidebar')
    <button class="sidebar-content" onclick="window.location='{{ route('reservas.index') }}'">
        Registro de Reservas
    </button>

    <button class="sidebar-content" onclick="window.location='{{ route('reservas.createqr') }}'">
        Crear Pago QR
    </button>
@endsection

@section('content')
<div class="reservas-container">

    <!-- Acciones generales -->
    <div class="reservas-acciones">
        <button class="btn btn-primary" data-modal-target=".modal-import">
            <i class="bi bi-file-earmark-arrow-down"></i> Importar Reservas
        </button>
        <button class="btn btn-secondary" data-modal-target=".modal-export">
            <i class="bi bi-file-earmark-arrow-up"></i> Exportar Reservas
        </button>
    </div>

    <!-- Tabla de Reservas -->
    <div class="reservas-tabla" id="reserva">
        <!-- Controles de Paginación -->
        <div class="tabla-controles">
            <label for="rows-per-page">Mostrar:</label>
            <select id="rows-per-page" onchange="window.location='{{ url()->current() }}?per_page=' + this.value">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
            </select>

            <div class="tabla-navegacion">
                @if ($reservas->onFirstPage())
                    <button disabled>Anterior</button>
                @else
                    <a href="{{ $reservas->previousPageUrl() }}&per_page={{ request('per_page', 10) }}" class="btn btn-primary">Anterior</a>
                @endif

                <span>Página {{ $reservas->currentPage() }} de {{ $reservas->lastPage() }}</span>

                @if ($reservas->hasMorePages())
                    <a href="{{ $reservas->nextPageUrl() }}&per_page={{ request('per_page', 10) }}" class="btn btn-primary">Siguiente</a>
                @else
                    <button disabled>Siguiente</button>
                @endif
            </div>
        </div>

        <!-- Tabla -->
        <div class="tabla-contenedor" id="reserva">
            <div class="tabla-scroll">
                <table class="tabla-dinamica">
                    <thead>
                        <tr>
                            <th>
                                <label class="checkbox-wrapper">
                                    <input type="checkbox" class="checkbox" id="select-all" />
                                    <span class="custom-checkbox"></span>
                                </label>
                            </th>
                            <th class="sortable" data-column="0">ID <i class="sort-icon bi bi-chevron-expand"></i></th>
                            <th class="sortable" data-column="1">Paciente <i class="sort-icon bi bi-chevron-expand"></i></th>
                            <th class="sortable" data-column="2">Servicio <i class="sort-icon bi bi-chevron-expand"></i></th>
                            <th class="sortable" data-column="3">Fecha de Reserva <i class="sort-icon bi bi-chevron-expand"></i></th>
                            <th class="sortable" data-column="4">Estado de Pago <i class="sort-icon bi bi-chevron-expand"></i></th>
                            <th class="sortable" data-column="5">Asistencia <i class="sort-icon bi bi-chevron-expand"></i></th>
                            <th class="sortable" data-column="6">Precio <i class="sort-icon bi bi-chevron-expand"></i></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($reservas as $reserva)
                        <tr data-reserva-id="{{ $reserva->id }}" data-has-modal="true">
                            <td>
                                <label class="checkbox-wrapper">
                                    <input type="checkbox" class="checkbox" />
                                    <span class="custom-checkbox"></span>
                                </label>
                            </td>
                            <td>{{ $reserva->id }}</td>
                            <td>{{ $reserva->paciente->nombres ?? 'N/A' }} {{ $reserva->paciente->apellidos ?? '' }}</td>
                            <td>{{ $reserva->servicio->nombre ?? 'N/A' }}</td>
                            <td>{{ $reserva->fecha_reserva }}</td>
                            <td>{{ $reserva->estado_pago }}</td>
                            <td>{{ $reserva->asistencia }}</td>
                            <td>{{ $reserva->precio }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="reservas-filtro">
        <form method="GET" action="{{ route('reservas.index') }}">
            <div>
                <label for="paciente">Paciente:</label>
                <input type="text" name="paciente" id="paciente" value="{{ request('paciente') }}">
            </div>

            <div>
                <label for="servicio">Servicio:</label>
                <input type="text" name="servicio" id="servicio" value="{{ request('servicio') }}">
            </div>

            <div>
                <label for="fecha_reserva">Fecha de Reserva:</label>
                <input type="date" name="fecha_reserva" id="fecha_reserva" value="{{ request('fecha_reserva') }}">
            </div>

            <div>
                <label for="estado_pago">Estado de Pago:</label>
                <select name="estado_pago" id="estado_pago">
                    <option value="">Todos</option>
                    <option value="Pagado" {{ request('estado_pago') == 'Pagado' ? 'selected' : '' }}>Pagado</option>
                    <option value="Pendiente" {{ request('estado_pago') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                </select>
            </div>

            <div>
                <label for="asistencia">Asistencia:</label>
                <select name="asistencia" id="asistencia">
                    <option value="">Todos</option>
                    <option value="Asistió" {{ request('asistencia') == 'Asistió' ? 'selected' : '' }}>Asistió</option>
                    <option value="No asistió" {{ request('asistencia') == 'No asistió' ? 'selected' : '' }}>No asistió</option>
                    <option value="Cancelado" {{ request('asistencia') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                    <option value="Pendiente" {{ request('asistencia') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                </select>
            </div>

            <button type="submit">Filtrar</button>
        </form>
    </div>

    <!-- Modales de Importar/Exportar -->
    <div class="modal modal-import">
        <div class="modal-content">
            <button class="btn-close" onclick="closeModal('.modal-import')">
                <i class="bi bi-x-circle-fill"></i>
            </button>
            <h2>Importar Reservas</h2>
            <div class="modal-body">
                <p>Funcionalidad no implementada actualmente</p>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('.modal-import')">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal modal-export">
        <div class="modal-content">
            <button class="btn-close" onclick="closeModal('.modal-export')">
                <i class="bi bi-x-circle-fill"></i>
            </button>
            <h2>Exportar Reservas</h2>
            <div class="modal-body">
                <div class="modal-actions">
                    <button class="btn btn-primary" onclick="exportTableToCSV()"> Exportar como CSV</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
