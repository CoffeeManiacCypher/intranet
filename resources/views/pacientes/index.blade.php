@extends('layouts.module')

@section('title', 'Módulo de Pacientes')

@section('head')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endsection

@vite(['resources/js/global/utilidades.js'])
@vite(['resources/js/global/paginacion.js'])

@vite(['resources/css/pacientes/pacientes.css', 'resources/js/pacientes/pacientes.js'])
@vite(['resources/css/pacientes/filtro.css', 'resources/js/pacientes/filtro.js'])
@section('sidebar')
    <button class="sidebar-content" onclick="window.location='{{ route('pacientes.index') }}'">
        Registro de Pacientes
    </button>
    <button class="sidebar-content" onclick="window.location='{{ route('pacientes.create') }}'">
        Añadir Paciente
    </button>
@endsection

@section('content')
<!-- ---------------------------------------DASHBOARD ------------------------------------->
<div class="pacientes-container">

    <!-- Acciones generales -->
    <div class="pacientes-acciones">
        <button class="btn btn-secondary" data-modal-target=".modal-export">
            <i class="bi bi-file-earmark-arrow-up"></i> Exportar Pacientes
        </button>
    </div>

    <!-- Tabla de Pacientes -->
    <div class="pacientes-tabla" id="paciente">
        <!-- Controles de Paginación -->
        <div class="tabla-controles">
            <label for="rows-per-page">Mostrar:</label>
            <select id="rows-per-page" onchange="window.location='{{ url()->current() }}?per_page=' + this.value">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
            </select>

            <div class="tabla-navegacion">
                @if ($pacientes->onFirstPage())
                    <button disabled>Anterior</button>
                @else
                    <a href="{{ $pacientes->previousPageUrl() }}&per_page={{ request('per_page', 10) }}" class="btn btn-primary">Anterior</a>
                @endif

                <span>Página {{ $pacientes->currentPage() }} de {{ $pacientes->lastPage() }}</span>

                @if ($pacientes->hasMorePages())
                    <a href="{{ $pacientes->nextPageUrl() }}&per_page={{ request('per_page', 10) }}" class="btn btn-primary">Siguiente</a>
                @else
                    <button disabled>Siguiente</button>
                @endif
            </div>
        </div>

<!-- ---------------------------------------TABLA GENERAL ------------------------------------->
        <div class="tabla-contenedor" id="paciente">
            <div class="tabla-scroll">
                <table class="tabla-dinamica">
                    <thead>
                        <tr>
                            <th class="sortable" data-column="0">ID <i class="sort-icon bi bi-chevron-expand"></i></th>
                            <th class="sortable" data-column="1">Nombres <i class="sort-icon bi bi-chevron-expand"></i></th>
                            <th class="sortable" data-column="2">Apellidos <i class="sort-icon bi bi-chevron-expand"></i></th>
                            <th class="sortable" data-column="3">Teléfono <i class="sort-icon bi bi-chevron-expand"></i></th>
                            <th class="sortable" data-column="4">Estado <i class="sort-icon bi bi-chevron-expand"></i></th>
                            <th class="sortable" data-column="5">Fecha Registro <i class="sort-icon bi bi-chevron-expand"></i></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($pacientes as $paciente)
                        <tr data-paciente-id="{{ $paciente->id }}" data-has-modal="true">
                            <td>{{ $paciente->id }}</td>
                            <td>{{ $paciente->nombres ?? 'N/A' }}</td>
                            <td>{{ $paciente->apellidos ?? 'N/A' }}</td>
                            <td>{{ $paciente->telefono ?? 'Sin Teléfono' }}</td>
                            <td>
                                <span class="badge {{ $paciente->estado_info === 'verificado' ? 'badge-success' : 'badge-warning' }}">
                                    {{ ucfirst($paciente->estado_info) }}
                                </span>
                            </td>
                            <td>{{ $paciente->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="pacientes-filtro">
        <form method="GET" action="{{ route('pacientes.index') }}">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" value="{{ request('nombre') }}">
            </div>

            <div>
                <label for="rut">RUT:</label>
                <input type="text" name="rut" id="rut" value="{{ request('rut') }}">
            </div>

            <div>
                <label for="correo">Correo Electrónico:</label>
                <input type="email" name="correo" id="correo" value="{{ request('correo') }}">
            </div>

            <div>
                <label for="estado_info">Estado de Verificación:</label>
                <select name="estado_info" id="estado_info">
                    <option value="">Todos</option>
                    <option value="verificado" {{ request('estado_info') == 'verificado' ? 'selected' : '' }}>Verificados</option>
                    <option value="pendiente" {{ request('estado_info') == 'pendiente' ? 'selected' : '' }}>Pendientes</option>
                </select>
            </div>

            <div>
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" id="telefono" value="{{ request('telefono') }}">
            </div>

            <div>
                <label for="fecha_registro">Fecha de Registro:</label>
                <input type="date" name="created_at" id="fecha_registro" value="{{ request('created_at') }}">
            </div>

            <div>
                <label for="ciudad">Ciudad:</label>
                <select name="ciudad" id="ciudad">
                    <option value="">Todas</option>
                    @foreach ($ciudades as $ciudad)
                        <option value="{{ $ciudad->id }}" {{ request('ciudad') == $ciudad->id ? 'selected' : '' }}>{{ $ciudad->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit">Filtrar</button>
        </form>
    </div>
</div>

<!-- ---------------------------------------Modal IMPORTAR ------------------------------------->
<div class="modal modal-import">
     <div class="modal-content">
        <button class="btn-close" onclick="closeModal('.modal-import')">
            <i class="bi bi-x-circle-fill"></i>
        </button>
        <h2>Importar Pacientes</h2>
        <div class="modal-body">
            <p>Funcionalidad no implementada actualmente</p>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('.modal-import')">Cerrar</button>
            </div>
        </div>
     </div>
</div>

<!-- ---------------------------------------Modal EXPORTAR -------------------------------------> 
    <div class="modal modal-export">
        <div class="modal-content">

            <button class="btn-close" onclick="closeModal('.modal-export')">
                <i class="bi bi-x-circle-fill"></i>
            </button>

            <h2>Exportar Pacientes</h2>
            <div class="modal-body">
                

                <div class="modal-actions">
                 <button class="primario" onclick="exportTableToCSV()"> Exportar como CSV</button>
                </div>
            </div>
        </div>
    </div>

<!-- ---------------------------------------Modal INFO MEJORADO------------------------------------->
<div id="modal-detalle-paciente" class="modal">

    <div class="modal-content">
<!-- ---------------------------------------Modal HEADER------------------------------------->
        <div class="modal-head">

            <button class="btn-close" 
                onclick="cerrarModal('#modal-detalle-paciente')">
                <i class="bi bi-x-circle-fill"></i>
            </button>

            <p class="detalle-info detalle-id">#ID <span id="detalle-id"></span></p>
            <p class="detalle-info detalle-nombre"><span id="detalle-nombre-completo"></span></p>
            <p class="detalle-info detalle-rut">RUT: <span id="detalle-rut"></span></p>
            <p class="detalle-info detalle-estado"><span id="detalle-estado" class="estado-badge"></span></p>

<!-- ---------------------------------------Modal SECCIONES------------------------------------->
            <div class="modal-nav">
                <button data-section="informacion-general" class="nav-btn active">Información del paciente</button>
                <button data-section="servicios" class="nav-btn">Servicios Adquiridos</button>
                <button data-section="giftcards" class="nav-btn">Giftcards compradas</button>
                <button data-section="fichas-medicas" class="nav-btn">Fichas Médicas</button>
                <button data-section="resumen" class="nav-btn">Resumen general</button>
            </div>

        </div>
<!-- ---------------------------------------Modal BODY------------------------------------->
        <div class="modal-body">
<!-- ---------------------------------------SECCION INFORMATIVO------------------------------------->
            <div id="informacion-general" class="modal-section active">
                
                <p><strong>Email:</strong> <span id="detalle-email"></span></p>
                <p><strong>Teléfono:</strong> <span id="detalle-telefono"></span></p>
                <p><strong>Dirección:</strong> <span id="detalle-direccion"></span></p>
                <p><strong>Ciudad:</strong> <span id="detalle-ciudad"></span></p>
                <p><strong>Fecha de Nacimiento:</strong> <span id="detalle-fecha-nacimiento"></span></p>
                <p><strong>Género:</strong> <span id="detalle-genero"></span></p>
                <p><strong>Fecha de Registro:</strong> <span id="detalle-fecha-registro"></span></p>
                <p><strong>Comentario adicional:</strong> <span id="detalle-comentario-adicional"></span></p>

            </div>
<!-- ---------------------------------------SECCION SERVICIOS ADQUIRIDOS------------------------------------->
            <div id="servicios" class="modal-section" style="display: none;">

                <table class="tabla-dinamica">

                    <thead>
                        <tr>
                            <th class="sortable" data-column="0">ID</th>
                            <th class="sortable" data-column="2">Fecha Registro</th>
                            <th class="sortable" data-column="1">Servicio</th>
                            <th class="sortable" data-column="5">Valor</th>
                            <th class="sortable" data-column="4">Asistencia</th>
                            <th class="sortable" data-column="3">Estado del Pago</th>
                        </tr>
                    </thead>

                    <tbody>
                         <!-- ¡El contenido se rellena por el JS! -->
                    </tbody>

                </table>

            </div>
<!-- ------------------------------------SECCION GIFTCARDS COMPRADAS------------------------------------->
            <div id="giftcards" class="modal-section" style="display: none;">

                <table class="tabla-dinamica">

                    <thead>
                        <tr>
                            <th class="sortable" data-column="0">ID</th>
                            <th class="sortable" data-column="1">Fecha de Compra</th>
                            <th class="sortable" data-column="2">Beneficiador</th>
                            <th class="sortable" data-column="3">Promoción</th>
                            <th class="sortable" data-column="4">Valor</th>
                            <th class="sortable" data-column="5">Estatus</th>
                            <th class="sortable" data-column="6">Fecha de Vencimiento</th>
                            <th class="sortable" data-column="7">Vendido por:</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!-- ¡El contenido se rellena por el JS! -->
                    </tbody>

                </table>

            </div>
<!-- ------------------------------------SECCION FICHAS MEDICAS------------------------------------->
            <div id="fichas-medicas" class="modal-section" style="display: none;">
                <table class="tabla-dinamica" id="tabla-fichas-medicas">
                    <thead>
                        <tr>
                            <th class="sortable" data-column="0">ID</th>
                            <th class="sortable" data-column="3">Fecha de subida</th>
                            <th class="sortable" data-column="1">Servicio</th>
                            <th class="sortable" data-column="2">Trabajador</th>
                            <th class="sortable" data-column="4">Archivo</th>
                        </tr>
                    </thead>
                    <div id="carga-fichas" style="display: none;">Cargando fichas médicas...</div>

                    <tbody>
                        <!-- Las filas serán generadas dinámicamente por JS -->
                    </tbody>
                </table>
            </div>
<!-- ------------------------------------SECCION RESUMEN FINANCIERO------------------------------------->
            <div id="resumen" class="modal-section" style="display: none;">
                <!-- Indicador de carga -->
                <div id="carga-resumen" style="display: none; text-align: center; margin: 20px 0;">
                    <p>Cargando resumen...</p>
                </div>

                <!-- Contenedor del resumen -->
                <div id="resumen-container" style="padding: 10px;">
                    <!-- Contenido dinámico generado por JS -->
                </div>
            </div>
<!-- -----------------------------------FIN DE LAS SECCIONES------------------------------------->
        </div>
<!-- ---------------------------------------Modal FOOTER------------------------------------->
        <div class="modal-footer">

            <button class="editar" 
                id="btn-editar-paciente">
                <i class="fa-solid fa-pen"></i>
                <span>Editar</span>
            </button>

            <button class="eliminar" 
                onclick="abrirModalEliminar()">
                <i class="fa-solid fa-trash"></i>
                <span>Eliminar</span>
            </button>

        </div>

    </div>
</div>
<!-- ---------------------------------------Modal DELETE ------------------------------------->
    <div id="modal-eliminar-paciente" class="modal">
        <div class="modal-content">
            <button class="btn-close" onclick="cerrarModal('#modal-eliminar-paciente')">
                <i class="bi bi-x-circle-fill"></i>
            </button>
            <h2>Confirmar Eliminación</h2>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este paciente? Esta acción se puede revertir.</p>
                <div class="modal-actions">
                    <button id="confirmar-eliminar" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
<!-- ---------------------------------------Modal EDITAR ------------------------------------->
    <div id="modal-editar-paciente" class="modal">
        <div class="modal-content">
            <button class="btn-close" onclick="cerrarModal('modal-editar-paciente')">
                <i class="bi bi-x-circle-fill"></i>
            </button>
            <h2>Editar Paciente</h2>
            <form id="form-editar-paciente">
                <div class="modal-body">
                    <!-- RUT -->
                    <div class="input-container">
                        <label for="editar-rut">RUT:</label>
                        <input type="text" id="editar-rut" name="rut" class="input" placeholder="Ingrese el RUT"
                            pattern="\d{1,2}\.\d{3}\.\d{3}-[0-9Kk]" title="Ingrese un RUT válido" required>
                    </div>

                    <!-- Nombres -->
                    <div class="input-container">
                        <label for="editar-nombre">Nombres:</label>
                        <input type="text" id="editar-nombre" name="nombres" class="input" placeholder="Ingrese los nombres"
                            required>
                    </div>

                    <!-- Apellidos -->
                    <div class="input-container">
                        <label for="editar-apellido">Apellidos:</label>
                        <input type="text" id="editar-apellido" name="apellidos" class="input"
                            placeholder="Ingrese los apellidos" required>
                    </div>

                    <!-- Email -->
                    <div class="input-container">
                        <label for="editar-email">Email:</label>
                        <input type="email" id="editar-email" name="email" class="input"
                            placeholder="Ingrese el email del paciente">
                    </div>

                    <!-- Teléfono -->
                    <div class="input-container">
                        <label for="editar-telefono">Teléfono:</label>
                        <input type="text" id="editar-telefono" name="telefono" class="input"
                            placeholder="Ingrese el teléfono (ejemplo: +56912345678)"
                            pattern="\+?56[0-9]{9}" title="Ingrese un teléfono válido">
                    </div>

                    <!-- Dirección -->
                    <div class="input-container">
                        <label for="editar-direccion">Dirección:</label>
                        <input type="text" id="editar-direccion" name="direccion" class="input"
                            placeholder="Ingrese la dirección del paciente">
                    </div>

                    <!-- Ciudad -->
                    <div class="input-container">
                        <label for="editar-ciudad">Ciudad:</label>
                        <select id="editar-ciudad" name="ciudad_id" class="input" required>
                            <option value="">Seleccione una ciudad</option>
                            <!-- Las ciudades se llenarán dinámicamente -->
                        </select>
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div class="input-container">
                        <label for="editar-fecha-nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" id="editar-fecha-nacimiento" name="fecha_nacimiento" class="input"
                            placeholder="Ingrese la fecha de nacimiento">
                    </div>

                    <!-- Género -->
                    <div class="input-container">
                        <label for="editar-genero">Género:</label>
                        <select id="editar-genero" name="genero" class="input" required>
                            <option value="">Seleccione un género</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <!-- Comentario Adicional -->
                    <div class="input-container">
                        <label for="editar-comentario-adicional">Comentario Adicional:</label>
                        <input type="text" id="editar-comentario-adicional" name="comentario_adicional" class="input"
                            placeholder="Ingrese un comentario adicional">
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModal('modal-editar-paciente')">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

@endsection
<script>

    function exportTableToCSV() {
        const table = document.getElementById('paciente');
        const rows = table.querySelectorAll('tr');
        let csvContent = "";

        rows.forEach(row => {
            const cells = row.querySelectorAll('th, td');
            const rowContent = Array.from(cells).map(cell => {
                const text = cell.innerText;
                return `"${text.replace(/"/g, '""')}"`;
            }).join(";");
            csvContent += rowContent + "\n";
        });

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'empleos.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    function importCSV() {
        Swal.fire({
            title: 'Cargar archivo CSV',
            html: `
                <input type="file" id="csvFileInput" accept=".csv" class="swal2-input">
                <input type="number" id="startCol" class="swal2-input" placeholder="Inicio columna (1)">
                <input type="number" id="startRow" class="swal2-input" placeholder="Inicio fila (1)">
                <input type="number" id="endCol" class="swal2-input" placeholder="Fin columna">
                <input type="number" id="endRow" class="swal2-input" placeholder="Fin fila">
            `,
            showCancelButton: true,
            confirmButtonText: 'Cargar',
            preConfirm: () => {
                const csvFile = document.getElementById('csvFileInput').files[0];
                const startCol = parseInt(document.getElementById('startCol').value) - 1 || 0;
                const startRow = parseInt(document.getElementById('startRow').value) - 1 || 0;
                const endCol = parseInt(document.getElementById('endCol').value) - 1;
                const endRow = parseInt(document.getElementById('endRow').value) - 1;

                if (!csvFile) {
                    Swal.showValidationMessage('Debe seleccionar un archivo CSV');
                }

                return { csvFile, startCol, startRow, endCol, endRow };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const { csvFile, startCol, startRow, endCol, endRow } = result.value;
                const reader = new FileReader();

                reader.onload = function(e) {
                    const csvContent = e.target.result;
                    const rows = csvContent.split('\n');
                    const tableBody = document.querySelector('#empleosTable tbody');

                    rows.forEach((row, rowIndex) => {
                        if (rowIndex < startRow || (endRow !== -1 && rowIndex > endRow)) return;

                        const cells = row.split(';').map(cell => cell.replace(/"/g, '').trim()); 
                        const tr = document.createElement('tr');
                        cells.forEach((cell, cellIndex) => {
                            if (cellIndex < startCol || (endCol !== -1 && cellIndex > endCol)) return;

                            const td = document.createElement('td');
                            td.textContent = cell;
                            tr.appendChild(td);
                        });
                        tableBody.appendChild(tr);
                    });
                };

                reader.readAsText(csvFile);
            }
        });
    }
</script>