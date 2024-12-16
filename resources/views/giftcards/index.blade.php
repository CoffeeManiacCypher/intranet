@extends('layouts.module')

@section('title', 'Módulo de Giftcards')

@vite(['resources/js/global/utilidades.js'])
@vite(['resources/js/global/paginacion.js'])

@vite(['resources/css/giftcard/giftcard.css', 'resources/js/giftcard/giftcard.js'])
@vite(['resources/js/giftcard/giftcard-modal.js'])


@section('sidebar')
    <button class="sidebar-content" onclick="window.location='{{ route('giftcard.index') }}'">
        <i class="fa-regular fa-address-card"></i>
         Registro de Giftcards
    </button>
    <button class="sidebar-content" onclick="window.location='{{ route('giftcard.create') }}'">
        <i class="fa-regular fa-square-plus"></i>
        Añadir Giftcard
    </button>
@endsection

@section('content')
<div class="giftcards-container">

    <!-- Acciones generales -->
    <div class="giftcards-acciones">

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
            {{ $giftcards->links() }}
        </div>

    </div>

    <!-- Tabla de Giftcards -->
    <div class="giftcards-tabla">

        <div class="tabla-scroll">
            <table class="tabla-dinamica">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Comprador</th>
                        
                        <th>Promoción</th>
                        <th>Valor</th>
                        <th>Vence en</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($giftcards as $giftcard)
                    <tr data-giftcard-id="{{ $giftcard->id }}" data-has-modal="true">
                        <td>{{ $giftcard->id }}</td>
                        <td>{{ $giftcard->comprador->nombre_completo ?? 'Sin comprador' }}</td>
                        
                        <td>{{ $giftcard->promocion->nombre ?? 'Sin promoción' }}</td>
                        <td>${{ '$' . number_format($giftcard->valor, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($giftcard->fecha_expiracion)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $giftcard->estatus_giftcard === 'activa' ? 'success' : ($giftcard->estatus_giftcard === 'vencida' ? 'danger' : 'warning') }}">
                                {{ ucfirst($giftcard->estatus_giftcard) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <button id="boton-filtro">
        <i class="fa-solid fa-filter"></i> <!-- Icono de filtro -->
    </button>
    
    <div class="filtro-contenedor" id="filtros-contenedor">
        <h3>Filtros</h3>
        <form id="filtros-form">
            <label for="estatus_giftcard">Estatus:</label>
            <select id="estatus_giftcard" name="estatus_giftcard">
                <option value="">Todos</option>
                <option value="activa">Activa</option>
                <option value="cobrada">Cobrada</option>
                <option value="vencida">Vencida</option>
                <option value="por_expirar">Por Expirar</option>
            </select>

            <label for="fecha_inicio">Fecha Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio">

            <label for="fecha_fin">Fecha Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin">

            <label for="valor_min">Valor Mínimo:</label>
            <input type="number" id="valor_min" name="valor_min">

            <label for="valor_max">Valor Máximo:</label>
            <input type="number" id="valor_max" name="valor_max">

            <button type="button" class="btn btn-primary" onclick="actualizarTabla()">Aplicar Filtros</button>
        </form>


    </div>


</div>

<!-- --------------------------------------------Modals ------------------------------------->

<div id="modal-detalle-giftcard" class="modal">
    <div class="modal-content">
        <!-- Head -->
        <div class="modal-head">
            <button class="btn-close" onclick="cerrarModal('modal-detalle-giftcard')">
                <i class="bi bi-x-circle-fill"></i>
            </button>
            <p><strong>ID:</strong> <span id="detalle-id"></span></p>
            <h2>Detalles de la Giftcard</h2>
            <p><strong>Estatus:</strong> <span id="detalle-estatus"></span></p>
            
            <div class="modal-nav">
                <button data-section="informacion-general" class="nav-btn active">Información General</button>
                <button data-section="diseno" class="nav-btn">Diseño</button>
            </div>
        </div>

        <!-- Body -->
        <div class="modal-body">
            <!-- Sección de Información General -->
            <div id="informacion-general" class="modal-section active">
                
                <p><strong>Comprado por:</strong> <span id="detalle-comprador"></span></p>
                <p><strong>Beneficiario:</strong> <span id="detalle-beneficiario"></span></p>
                <p><strong>Vendido por:</strong> <span id="detalle-trabajador"></span></p>
                <p><strong>Promoción:</strong> <span id="detalle-promocion"></span></p>
                <p><strong>Valor:</strong> <span id="detalle-valor"></span></p>
                <p><strong>Fecha Compra:</strong> <span id="detalle-fecha-compra"></span></p>
                <p><strong>Fecha Expiración:</strong> <span id="detalle-fecha-expiracion"></span></p>
                
                <p><strong>Mensaje Personalizado:</strong> <span id="detalle-mensaje"></span></p>
            </div>

            <!-- Sección Diseño -->
            <div id="diseno" class="modal-section" style="display: none;">


                <div class="giftcard-preview">

                    <div class="giftcard-container">

                        <h3 class="giftcard-title">Giftcard</h3>

                        <p><strong>Para:</strong> <span id="diseno-beneficiario"></span></p>
                        <p><strong>Servicio:</strong> <span id="diseno-promocion"></span></p>
                        <p><strong>Expira:</strong> <span id="diseno-fecha-expiracion"></span></p>
                        <p class="giftcard-recipient"><em id="diseno-mensaje"></em></p>


                    </div>
                </div>

            
            </div>


        </div>

        <!-- Footer -->
        <div class="modal-footer">

            <button class="primario" 
                id="btn-cobrar-giftcard" 
                onclick="abrirModalCobrar()">
                <i class="fas fa-check-circle"></i>
                <span>Cobrar</span>
            </button>

            <button class="editar" 
                id="btn-editar-giftcard" 
                onclick="abrirModalEditar()">
                <i class="fa-solid fa-pen"></i>
                <span>Editar</span>
            </button>

            <button class="eliminar" 
            onclick="abrirModalAdvertenciaEliminar()">Eliminar</button>

        </div>

    </div>
</div>
<!-- --------------------------------------------Modals ------------------------------------->
<div id="modal-cobrar-giftcard" class="modal">
    <div class="modal-content">
        <button class="btn-close" onclick="cerrarModal('modal-cobrar-giftcard')">
            <i class="bi bi-x-circle-fill"></i>
        </button>
        <h2>Cobrar Giftcard</h2>
        <div class="modal-body">
            <p>Antes de cobrar la giftcard, verifica que los datos corresponden a la giftcard que te entregó el cliente.</p>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill" style="margin-right: 8px; color: #721c24;"></i>
                    <strong>¡Atención!</strong> Esta acción no se puede revertir luego de marcar la giftcard como cobrada. ¿Estás seguro de cobrarla?
                </div>

            <div class="modal-actions">
                <button class="btn btn-primary" id="confirmar-cobrar-giftcard">Cobrar Giftcard</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal de Advertencia -->
<div id="modal-advertencia-eliminar" class="modal">
    <div class="modal-content">
        <button class="btn-close" onclick="cerrarModal('modal-advertencia-eliminar')">
            <i class="bi bi-x-circle-fill"></i>
        </button>
        <h2>¿Estás seguro de que deseas eliminar esta Giftcard?</h2>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill" style="margin-right: 8px; color: #721c24;"></i>
                <strong>¡Atención!</strong> Esta acción no se puede revertir luego de marcar la giftcard como eliminada. ¿Estás seguro de Eliminar la giftcard?
            </div>
        <div class="modal-actions">
            <button class="btn btn-danger" onclick="abrirModalConfirmarEliminar()">Eliminar Giftcard</button>
        </div>
    </div>
</div>

<!-- Modal de Confirmación Final -->
<div id="modal-confirmar-eliminar" class="modal">
    <div class="modal-content">

        <button class="btn-close" onclick="cerrarModal('modal-confirmar-eliminar')">
            <i class="bi bi-x-circle-fill"></i>
        </button>

        <h2>Confirmar Eliminación</h2>
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill" style="margin-right: 8px; color: #721c24;"></i>
            <strong>¡Atención!</strong> Esta acción ES INRREVERSIBLE. ¿Estás seguro de REALMENTE Eliminar la giftcard?
            <i class="bi bi-exclamation-triangle-fill" style="margin-right: 8px; color: #721c24;"></i>
        </div>

        <div class="modal-actions">
            <button class="btn btn-danger" id="btn-confirmar-eliminar">Eliminar Giftcard</button>
        </div>

    </div>
</div>


<div id="modal-editar-giftcard" class="modal">
    <div class="modal-content">
        <button class="btn-close" onclick="cerrarModal('modal-editar-giftcard')">
            <i class="bi bi-x-circle-fill"></i>
        </button>
        <h2>Editar Giftcard</h2>
        <form id="form-editar-giftcard">
            <div class="modal-body">
                <!-- Comprador -->
                <div class="form-group">
                    <label for="editar-comprador">Comprado por:</label>
                    <select id="editar-comprador" class="form-control select2" name="comprado_por"></select>
                </div>

                <!-- Beneficiario -->
                <div class="form-group">
                    <label for="editar-beneficiador">Beneficiario:</label>
                    <select id="editar-beneficiador" class="form-control select2" name="beneficiador_id"></select>
                </div>

                <!-- Trabajador -->
                <div class="form-group">
                    <label for="editar-trabajador">Vendido por (Trabajador):</label>
                    <select id="editar-trabajador" class="form-control select2" name="trabajador_id"></select>
                </div>

                <!-- Promoción -->
                <div class="form-group">
                    <label for="editar-promocion">Promoción:</label>
                    <select id="editar-promocion" class="form-control select2" name="promocion_id"></select>
                </div>

                <!-- Valor -->
                <div class="form-group">
                    <label for="editar-valor">Valor:</label>
                    <input id="editar-valor" type="number" class="form-control" name="valor" required />
                </div>

                <!-- Mensaje personalizado -->
                <div class="form-group">
                    <label for="editar-mensaje">Mensaje Personalizado:</label>
                    <textarea id="editar-mensaje" class="form-control" name="mensaje_personalizado"></textarea>
                </div>

                <!-- Fechas -->
                <div class="form-group">
                    <label for="editar-fecha-compra">Fecha de Compra:</label>
                    <input id="editar-fecha-compra" type="date" class="form-control" name="fecha_compra" required />
                </div>

                <div class="form-group">
                    <label for="editar-fecha-expiracion">Fecha de Expiración:</label>
                    <input id="editar-fecha-expiracion" type="date" class="form-control" name="fecha_expiracion" required />
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>



<script>
    const giftcardsData = @json($giftcards);
</script>

@endsection
@if(session('success'))
    <div class="alert alert-success" >
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
    </div>
@endif
