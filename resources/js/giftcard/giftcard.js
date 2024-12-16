document.addEventListener('DOMContentLoaded', () => {
    const tablaBody = document.querySelector('.tabla-dinamica tbody');
    const rowsPerPageSelect = document.getElementById('rows-per-page');
    const paginationControls = document.querySelector('.tabla-navegacion');
    const modalDetalleGiftcard = document.getElementById('modal-detalle-giftcard');
    const modalAdvertenciaEliminar = document.getElementById('modal-advertencia-eliminar');
    const modalConfirmarEliminar = document.getElementById('modal-confirmar-eliminar');
    const btnConfirmarEliminar = document.getElementById('btn-confirmar-eliminar');
    const modalCobrar = document.getElementById('modal-cobrar-giftcard');
    const btnConfirmarCobrar = document.getElementById('confirmar-cobrar-giftcard');
    const modalEditar = document.getElementById('modal-editar-giftcard');
    const formEditar = document.getElementById('form-editar-giftcard');
    const modales = document.querySelectorAll('.modal');
    const botonFiltro = document.getElementById('boton-filtro');
    const filtrosContenedor = document.getElementById('filtros-contenedor');


    let giftcardsData = []; // Datos dinámicos de giftcards
    let currentPage = 1; // Página actual
    let giftcardSeleccionada = null; // Giftcard seleccionada para acciones

    $('.select2').select2({
        placeholder: 'Selecciona una opción',
        allowClear: true,
        width: '100%',
    });
    function verificarModalesCerrados() {
        const hayModalAbierto = Array.from(modales).some(modal => {
            return modal.classList.contains('show') && modal.style.visibility === 'visible';
        });

        if (!hayModalAbierto) {
            console.log('No hay modales abiertos. Recargando página...');
            window.location.reload();
        }
    }
    botonFiltro.addEventListener('click', () => {
        if (filtrosContenedor.classList.contains('visible')) {
            // Si está visible, lo oculta
            filtrosContenedor.classList.remove('visible');
        } else {
            // Si está oculto, lo muestra
            filtrosContenedor.classList.add('visible');
        }
    });
    /**
     * Evento para cerrar modal y verificar si debe recargar la página.
     */
    modales.forEach(modal => {
        const closeButton = modal.querySelector('.btn-close');
        if (closeButton) {
            closeButton.addEventListener('click', () => {
                modal.classList.remove('show');
                modal.style.visibility = 'hidden';

                // Verificar si recargar la página
                verificarModalesCerrados();
            });
        }
    });


    // Función para actualizar la tabla con datos del servidor
    window.actualizarTabla = function (perPage = 10, pagina = 1) {
        // Construir la URL base con la paginación
        const url = `/giftcard?page=${pagina}&per_page=${perPage}`;
        
        // Obtener los datos del formulario de filtros
        const formData = new FormData(document.getElementById('filtros-form'));
        const params = new URLSearchParams();
    
        for (let [key, value] of formData.entries()) {
            if (value) { // Añadir únicamente parámetros con valores no vacíos
                params.append(key, value);
            }
        }
    
        // Generar la URL completa con los parámetros del filtro
        const fullUrl = `${url}&${params.toString()}`;
    
        // Realizar la solicitud AJAX
        fetch(fullUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        })
        .then((response) => {
            // Verificar si la respuesta del servidor es válida
            if (!response.ok) {
                throw new Error(`Error en la respuesta del servidor: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            // Validar la estructura de los datos recibidos
            if (!data || !data.data || !data.current_page || !data.last_page) {
                throw new Error('Los datos recibidos no son válidos o están incompletos.');
            }
    
            // Actualizar las variables globales con los datos obtenidos
            giftcardsData = data.data;
            currentPage = data.current_page;
    
            // Limpiar el contenido de la tabla antes de actualizarla
            tablaBody.innerHTML = '';
    
            if (giftcardsData.length === 0) {
                // Si no hay registros, mostrar un mensaje indicativo
                tablaBody.innerHTML = `
                    <tr>
                        <td colspan="9" style="text-align: center;">No se encontraron registros</td>
                    </tr>
                `;
            } else {
                // Si hay registros, recorrer los datos y crear las filas
                giftcardsData.forEach((giftcard) => {
                    const comprador = giftcard.comprador 
                        ? `${giftcard.comprador.nombres ?? ''} ${giftcard.comprador.apellidos ?? ''}`.trim()
                        : 'Sin comprador';
    
                    const row = document.createElement('tr');
                    row.setAttribute('data-giftcard-id', giftcard.id);
                    row.setAttribute('data-has-modal', 'true');
    
                    row.innerHTML = `
                        <td>${giftcard.id}</td>
                        <td>${comprador}</td>
                        <td>${giftcard.promocion?.nombre || 'Sin promoción'}</td>
                        <td>${formatCurrency(giftcard.valor)}</td>
                        <td>${formatDateToDMY(giftcard.fecha_expiracion) || 'No disponible'}</td>
                        <td>
                            <span class="badge ${getBadgeClass(giftcard.estatus_giftcard)}">
                                ${capitalize(giftcard.estatus_giftcard)}
                            </span>
                        </td>
                    `;
                    tablaBody.appendChild(row);
                });
            }
    
            // Actualizar los controles de paginación
            actualizarControlesPaginacion(data);
    
            // Asignar eventos a las filas
            agregarEventosFilas();
        })
        .catch((error) => {
            // Manejo de errores: Mostrar mensaje de error en la tabla
            console.error('Error al actualizar la tabla:', error);
            tablaBody.innerHTML = `
                <tr>
                    <td colspan="9" style="text-align: center; color: red;">Error al cargar los datos</td>
                </tr>
            `;
        });
    };

    function formatCurrency(valor) {
        const valorRedondeado = Math.round(valor); // Redondea el valor al entero más cercano
        return `$${valorRedondeado.toLocaleString('es-CL')}`; // Formatea el número como moneda
    }
    function formatDateToDMY(fecha) {
        const date = new Date(fecha);
        const dia = String(date.getDate()).padStart(2, '0');
        const mes = String(date.getMonth() + 1).padStart(2, '0'); // Los meses comienzan en 0
        const anio = date.getFullYear();
        return `${dia}/${mes}/${anio}`;
    }
    function actualizarTablaBody(giftcards) {
        const tablaBody = document.querySelector('.tabla-dinamica tbody');
        tablaBody.innerHTML = '';
    
        if (giftcards.length === 0) {
            tablaBody.innerHTML = `
                <tr>
                    <td colspan="9" style="text-align: center;">No se encontraron registros</td>
                </tr>
            `;
            return;
        }
    
        giftcards.forEach((giftcard) => {
            const comprador = giftcard.comprador
                ? `${giftcard.comprador.nombres || ''} ${giftcard.comprador.apellidos || ''}`.trim()
                : 'Sin comprador';
    
            const row = `
                <tr>
                    <td>${giftcard.id}</td>
                    <td>${comprador}</td>
                    <td>${giftcard.promocion?.nombre || 'Sin promoción'}</td>
                    <td>${giftcard.valor || 'No disponible'}</td>
                    <td>${giftcard.fecha_expiracion || 'No disponible'}</td>
                    <td><span class="badge ${getBadgeClass(giftcard.estatus_giftcard)}">${capitalize(giftcard.estatus_giftcard)}</span></td>
                </tr>
            `;
            tablaBody.innerHTML += row;
        });
    }
    
    
    
    // Función para actualizar controles de paginación
    function actualizarControlesPaginacion(data) {
        const paginationControls = document.querySelector('.tabla-navegacion');
        paginationControls.innerHTML = `
            ${data.prev_page_url
                ? `<button class="btn btn-primary" data-page="${data.current_page - 1}">Anterior</button>`
                : `<button class="btn" disabled>Anterior</button>`}
            <span>Página ${data.current_page} de ${data.last_page}</span>
            ${data.next_page_url
                ? `<button class="btn btn-primary" data-page="${data.current_page + 1}">Siguiente</button>`
                : `<button class="btn" disabled>Siguiente</button>`}
        `;
    
        paginationControls.querySelectorAll('button[data-page]').forEach((button) => {
            button.addEventListener('click', () => {
                const page = button.getAttribute('data-page');
                actualizarTabla(10, page);
            });
        });
    }
    

    // Manejador global para abrir modal desde fila
    function abrirModalFila(event) {
        const giftcardId = event.currentTarget.getAttribute('data-giftcard-id');
        abrirModalGiftcard(giftcardId);
    }
    
    // Actualiza los eventos de las filas de la tabla
    function agregarEventosFilas() {
        tablaBody.querySelectorAll('tr[data-has-modal="true"]').forEach((row) => {
            row.removeEventListener('click', abrirModalFila); // Elimina manejadores duplicados
            row.addEventListener('click', abrirModalFila); // Asigna evento
        });
    }

    
    
    

    // Función para abrir modal de detalles
    function abrirModalGiftcard(giftcardId) {
        giftcardSeleccionada = giftcardsData.find((g) => g.id == giftcardId);
        if (giftcardSeleccionada) {
            rellenarModal(giftcardSeleccionada);
            mostrarModal(modalDetalleGiftcard);
        } else {
            alert('No se pudo encontrar la giftcard seleccionada.');
        }
    }

    // Función para rellenar el modal de detalles
    function rellenarModal(giftcard) {
        document.getElementById('detalle-id').textContent = giftcard.id;
        document.getElementById('detalle-comprador').textContent = giftcard.comprador?.nombres || 'Sin comprador';
        document.getElementById('detalle-beneficiario').textContent = giftcard.beneficiador?.nombres || 'Sin beneficiario';
        document.getElementById('detalle-trabajador').textContent = giftcard.trabajador?.nombres || 'Sin trabajador';
        document.getElementById('detalle-promocion').textContent = giftcard.promocion?.nombre || 'Sin promoción';
        document.getElementById('detalle-valor').textContent = formatCurrency(giftcard.valor);
        document.getElementById('detalle-fecha-compra').textContent = giftcard.fecha_compra || 'No disponible';
        document.getElementById('detalle-fecha-expiracion').textContent = giftcard.fecha_expiracion || 'No disponible';
        document.getElementById('detalle-estatus').textContent = capitalize(giftcard.estatus_giftcard);
        document.getElementById('detalle-mensaje').textContent = giftcard.mensaje_personalizado || 'Sin mensaje';
        // Sección "Diseño"

        const beneficiario = `${giftcard.beneficiador?.nombres || 'Sin beneficiario'} ${giftcard.beneficiador?.apellidos || ''}`.trim();
        document.getElementById('diseno-beneficiario').textContent = beneficiario;
        document.getElementById('diseno-promocion').textContent = giftcard.promocion?.nombre || 'Sin promoción';
        document.getElementById('diseno-fecha-expiracion').textContent =
            giftcard.fecha_expiracion ? new Date(giftcard.fecha_expiracion).toLocaleDateString('es-CL') : 'No disponible';
        document.getElementById('diseno-mensaje').textContent = giftcard.mensaje_personalizado || '';

        // Debugging adicional para elementos de la sección "Diseño"
        console.log('Beneficiario:', beneficiario);
        console.log('Promoción:', giftcard.promocion?.nombre || 'Sin promoción');
        console.log('Fecha de Expiración:', document.getElementById('diseno-fecha-expiracion').textContent);
    }

    // Función para mostrar el modal
    function mostrarModal(modal) {
        modal.style.visibility = 'visible';
        modal.classList.add('show');
    }

function cerrarModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
        modal.style.visibility = 'hidden';
        limpiarEventosFilas(); // Eliminar eventos antiguos
        agregarEventosFilas(); // Reasignar eventos
    }
}

    
    function inicializarEventos() {
        agregarEventosFilas();
    }

    // Función para formatear números como moneda


    // Función para capitalizar cadenas
    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    // Función para obtener clase de badge según estatus
    function getBadgeClass(status) {
        switch (status) {
            case 'activa':
                return 'badge-success';
            case 'vencida':
                return 'badge-danger';
            case 'por_expirar':
                return 'badge-warning';
            case 'cobrada':
                return 'badge-info';
            default:
                return 'badge-secondary';
        }
    }

    // Inicializar tabla
    actualizarTabla(rowsPerPageSelect.value, 1);

    window.abrirModalCobrar = function () {
        console.log('Giftcard seleccionada para cobrar:', giftcardSeleccionada);
        if (giftcardSeleccionada) {
            mostrarModal(modalCobrar);
        } else {
            alert('No se ha seleccionado ninguna giftcard para cobrar.');
        }
    };
    

    // Confirmar la acción de cobrar
    btnConfirmarCobrar.addEventListener('click', () => {
        if (giftcardSeleccionada) {
            fetch(`/giftcard/cobrar/${giftcardSeleccionada.id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
                .then((response) => {
                    if (response.ok) {
                        alert('La giftcard ha sido cobrada con éxito.');
                        giftcardSeleccionada.estatus_giftcard = 'cobrada';
                        cerrarModal('modal-cobrar-giftcard');
                        window.location.reload(); // Recargar para reflejar cambios
                    } else {
                        alert('Hubo un problema al cobrar la giftcard. Inténtalo de nuevo.');
                    }
                })
                .catch((error) => {
                    console.error('Error al cobrar la giftcard:', error);
                });
        }
    });
    // Abrir modal de edición
    window.abrirModalEditar = function () {
        if (!giftcardSeleccionada) {
            alert('No se ha seleccionado ninguna giftcard para editar.');
            return;
        }
        cerrarModal('modal-detalle-giftcard'); // Cierra el modal de detalles
        rellenarFormularioEdicion(giftcardSeleccionada);
        mostrarModal(modalEditar);
    };

    // Rellenar el formulario con los datos de la giftcard
    function rellenarFormularioEdicion(giftcard) {
        // Cargar opciones en los selects dinámicamente
        cargarOpcionesSelect('editar-comprador', '/giftcard/api/pacientes', giftcard.comprado_por);
        cargarOpcionesSelect('editar-beneficiador', '/giftcard/api/pacientes', giftcard.beneficiador_id);        
        cargarOpcionesSelect('editar-promocion', '/giftcard/api/promociones', giftcard.promocion_id);
        cargarOpcionesSelect('editar-trabajador', '/giftcard/api/personal', giftcard.trabajador_id);
    
        // Otros campos
        document.getElementById('editar-valor').value = giftcard.valor || '';
        document.getElementById('editar-mensaje').value = giftcard.mensaje_personalizado || '';
        document.getElementById('editar-fecha-compra').value = giftcard.fecha_compra || '';
        document.getElementById('editar-fecha-expiracion').value = giftcard.fecha_expiracion || '';
    }

    // Función para cargar opciones en un <select>
function cargarOpcionesSelect(selectId, url, selectedId) {
    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            const select = document.getElementById(selectId);
            select.innerHTML = ''; // Limpiar opciones existentes

            // Depuración: mostrar el select y el data cargado
            console.log(`Cargando datos para ${selectId} desde ${url}`, data);

            data.forEach((item) => {
                const option = new Option(
                    `${item.nombres || ''} ${item.apellidos || item.nombre || ''}`.trim(),
                    item.id,
                    false,
                    item.id == selectedId
                );
                select.appendChild(option);
            });

            $(select).trigger('change'); // Refrescar Select2
        })
        .catch((error) => console.error(`Error al cargar opciones para ${selectId}:`, error));
}


    // Enviar cambios al servidor
    formEditar.addEventListener('submit', (event) => {
        event.preventDefault();
        if (!giftcardSeleccionada) {
            alert('No hay una giftcard seleccionada para editar.');
            return;
        }

        const datosActualizados = {
            comprado_por: document.getElementById('editar-comprador').value,
            beneficiador_id: document.getElementById('editar-beneficiador').value,
            promocion_id: document.getElementById('editar-promocion').value,
            trabajador_id: document.getElementById('editar-trabajador').value,
            valor: document.getElementById('editar-valor').value,
            mensaje_personalizado: document.getElementById('editar-mensaje').value,
            fecha_compra: document.getElementById('editar-fecha-compra').value,
            fecha_expiracion: document.getElementById('editar-fecha-expiracion').value,
        };

        fetch(`/giftcard/${giftcardSeleccionada.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(datosActualizados),
        })
            .then((response) => {
                if (response.ok) {
                    showAlert("success", "Cambios guardados correctamente.", 3000);
                    
                    // Esperar 3 segundos (duración del alert) y cerrar todos los modales
                    setTimeout(() => {
                        cerrarTodosLosModales();
                        actualizarTabla(rowsPerPageSelect.value, currentPage); // Actualizar la tabla
                    }, 3000);
                } else {
                    showAlert("error", "Error al guardar los cambios. Inténtalo de nuevo.", 5000);
                }
            })
            .catch((error) => {
                console.error("Error al guardar los cambios:", error);
                showAlert("error", "Ocurrió un error inesperado. Por favor, intenta nuevamente.", 5000);
            });
    });
    // Seleccionar una giftcard
    function seleccionarGiftcard(giftcardId) {
        giftcardSeleccionada = giftcardsData.find((g) => g.id == giftcardId);
        console.log('Giftcard seleccionada:', giftcardSeleccionada);
        if (!giftcardSeleccionada) {
            alert('No se pudo encontrar la giftcard seleccionada.');
        }
    }
    function limpiarEventosFilas() {
        tablaBody.querySelectorAll('tr[data-has-modal="true"]').forEach((row) => {
            row.replaceWith(row.cloneNode(true)); // Elimina todos los listeners
        });
    }
    

        // Mostrar modal
    function mostrarModal(modal) {
        modal.style.display = 'block';
        modal.classList.add('show');
    }

// ------------------------------------------------FUNCIONES DE ELIMINAR---------------------------------------------

    // Función para abrir el modal de advertencia
    window.abrirModalAdvertenciaEliminar = function () {
        if (!giftcardSeleccionada) {
            alert('No se ha seleccionado ninguna giftcard para eliminar.');
            return;
        }
        mostrarModal(modalAdvertenciaEliminar);
    };

    // Función para abrir el modal de confirmación
    window.abrirModalConfirmarEliminar = function () {
        cerrarModal('modal-advertencia-eliminar');
        mostrarModal(modalConfirmarEliminar);
    };

    // Función para confirmar eliminación
    btnConfirmarEliminar.addEventListener('click', () => {
        if (!giftcardSeleccionada) {
            alert('No se ha seleccionado ninguna giftcard para eliminar.');
            return;
        }

        // Realizar petición al servidor para SoftDelete
        fetch(`/giftcard/${giftcardSeleccionada.id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
            .then((response) => {
                if (response.ok) {
                    showAlert("success", "Giftcard eliminada correctamente.", 3000);
                    
                    // Esperar 3 segundos (duración del alert) y cerrar todos los modales
                    setTimeout(() => {
                        cerrarTodosLosModales();
                        actualizarTabla(rowsPerPageSelect.value, currentPage);
                    }, 3000);
                } else {
                    showAlert("error", "Error al eliminar la giftcard. Inténtalo de nuevo.", 5000);
                }
            })
            .catch((error) => {
                console.error("Error al eliminar la giftcard:", error);
                showAlert("error", "Ocurrió un error inesperado. Por favor, intenta nuevamente.", 5000);
            });
    });
    function cerrarTodosLosModales() {
        const modales = document.querySelectorAll('.modal.show');
        modales.forEach((modal) => {
            modal.classList.remove('show');
            modal.style.visibility = 'hidden';
        });
    }

    // Inicializar tabla
    actualizarTabla();
});

