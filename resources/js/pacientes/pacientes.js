document.addEventListener('DOMContentLoaded', () => {
    const tablaBody = document.querySelector('.tabla-dinamica tbody');
    const rowsPerPageSelect = document.getElementById('rows-per-page');
    const paginationControls = document.querySelector('.tabla-navegacion');
    const filtrosForm = document.querySelector('.pacientes-filtro form');

    const ciudadSelect = document.getElementById('ciudad');

    const modalNavButtons = document.querySelectorAll('.modal-nav .nav-btn'); // Botones de navegación del modal
    const modalSections = document.querySelectorAll('.modal-body .modal-section'); // Secciones del modal

    const modalDetallePaciente = document.getElementById('modal-detalle-paciente');
    const modalEditarPaciente = document.getElementById('modal-editar-paciente');
    const modalEliminarPaciente = document.getElementById('modal-eliminar-paciente');
    const btnEditarPaciente = document.getElementById('btn-editar-paciente');
    const confirmarEliminarBtn = document.getElementById('confirmar-eliminar');


    let pacientesData = []; // Array dinámico de pacientes
    let currentPage = 1; // Página actual
    let pacienteSeleccionado = null; // Paciente seleccionado para edición

    modalNavButtons.forEach((button) => {
        button.addEventListener('click', (e) => {
            const sectionId = button.getAttribute('data-section'); // Obtener la sección objetivo
            cambiarSeccion(sectionId);
        });
    });

    /**
     * Función para cambiar la sección activa del modal
     */
    function cambiarSeccion(sectionId) {
        // Cambiar clase activa en los botones
        modalNavButtons.forEach((btn) => btn.classList.remove('active'));
        const activeButton = document.querySelector(`[data-section="${sectionId}"]`);
        if (activeButton) activeButton.classList.add('active');

        // Mostrar la sección correspondiente
        modalSections.forEach((section) => {
            if (section.id === sectionId) {
                section.style.display = 'block'; // Mostrar sección activa
                section.classList.add('active');
            } else {
                section.style.display = 'none'; // Ocultar otras secciones
                section.classList.remove('active');
            }
        });

        // Ajustar la altura del modal
        recalcularAlturaModal();
    }

    function recalcularAlturaModal() {
        const modalContent = document.querySelector('.modal-content');
        const modalBody = document.querySelector('.modal-body');
        const modalFooter = document.querySelector('.modal-footer');
    
        if (modalContent && modalBody && modalFooter) {
            // Reinicia la altura a 'auto' para calcular correctamente
            modalContent.style.height = 'auto';
    
            // Garantizar que la altura no exceda el máximo definido en CSS
            const maxHeight = window.innerHeight * 0.9; // Respeta el 90vh definido en CSS
            const rect = modalContent.getBoundingClientRect();
    
            if (rect.height > maxHeight) {
                modalContent.style.height = `${maxHeight}px`; // Ajustar al máximo permitido
                modalContent.style.overflowY = 'auto'; // Habilitar scroll si es necesario
            }
        }
    }

    // Función para obtener los valores de los filtros actuales en el formulario
    function obtenerFiltros() {
        const formData = new FormData(filtrosForm);
        const params = new URLSearchParams();
        formData.forEach((value, key) => {
            if (value) {
                params.append(key, value);
            }
        });
        return params.toString();
    }

    if (ciudadSelect) {
        ciudadSelect.addEventListener('change', () => {
            actualizarTabla(rowsPerPageSelect.value, 1);
        });
    }

    // Función para actualizar la tabla con datos desde el servidor
    function actualizarTabla(perPage = 10, pagina = 1) {
        const filtros = obtenerFiltros();
        const url = `/pacientes?page=${pagina}&per_page=${perPage}&${filtros}`;
        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        })
            .then((response) => response.json())
            .then((data) => {
                pacientesData = data.data; // Actualizar datos de pacientes
                currentPage = data.current_page; // Actualizar página actual

                // Limpiar el cuerpo de la tabla
                tablaBody.innerHTML = '';

                // Agregar nuevas filas
                pacientesData.forEach((paciente) => {
                    const row = document.createElement('tr');
                    row.setAttribute('data-paciente-id', paciente.id);
                    row.setAttribute('data-has-modal', 'true');
                    row.innerHTML = `

                        <td>${paciente.id}</td>
                        <td>${paciente.nombres || 'N/A'}</td>
                        <td>${paciente.apellidos || 'N/A'}</td>
                        <td>${paciente.telefono || 'Sin Teléfono'}</td>
                        <td>
                            <span class="badge ${paciente.estado_info === 'verificado' ? 'badge-success' : 'badge-warning'}">
                                ${paciente.estado_info.charAt(0).toUpperCase() + paciente.estado_info.slice(1)}
                            </span>
                        </td>
                        <td>${new Date(paciente.created_at).toISOString().split('T')[0]}</td>
                    `;
                    tablaBody.appendChild(row);
                });

                // Actualizar controles de navegación
                actualizarControlesPaginacion(data);
            })
            .catch((error) => console.error('Error al actualizar la tabla:', error));
    }

    // Función para actualizar controles de paginación
    function actualizarControlesPaginacion(data) {
        const filtros = obtenerFiltros();
        paginationControls.innerHTML = `
            ${data.prev_page_url
                ? `<button class="btn btn-primary" data-page="${data.current_page - 1}" data-filtros="${filtros}">Anterior</button>`
                : `<button class="btn" disabled>Anterior</button>`}
            <span>Página ${data.current_page} de ${data.last_page}</span>
            ${data.next_page_url
                ? `<button class="btn btn-primary" data-page="${data.current_page + 1}" data-filtros="${filtros}">Siguiente</button>`
                : `<button class="btn" disabled>Siguiente</button>`}
        `;

        // Añadir eventos a los botones de paginación
        paginationControls.querySelectorAll('button[data-page]').forEach((button) => {
            button.addEventListener('click', () => {
                const page = button.getAttribute('data-page');
                actualizarTabla(rowsPerPageSelect.value, page);
            });
        });
    }

    // Escuchar el cambio en filas por página
    if (rowsPerPageSelect) {
        rowsPerPageSelect.addEventListener('change', () => {
            const perPage = rowsPerPageSelect.value;
            actualizarTabla(perPage, 1); // Reiniciar a la primera página
        });
    }

    // Evento para aplicar los filtros
    if (filtrosForm) {
        filtrosForm.addEventListener('submit', (e) => {
            e.preventDefault();
            actualizarTabla(rowsPerPageSelect.value, 1); // Reiniciar a la primera página al filtrar
        });
    }

    // Delegar eventos para abrir el modal desde las filas de la tabla
    if (tablaBody) {
        tablaBody.addEventListener('click', (e) => {
            const row = e.target.closest('tr[data-has-modal="true"]');
            if (row) {
                const pacienteId = row.getAttribute('data-paciente-id');
                abrirModalPaciente(pacienteId);
            }
        });
    }

    // Función para abrir el modal del paciente
    function abrirModalPaciente(pacienteId) {
        pacienteSeleccionado = pacientesData.find((p) => p.id == pacienteId);
        if (pacienteSeleccionado) {
            rellenarModal(pacienteSeleccionado);
            mostrarModal('modal-detalle-paciente');
            cargarReservasDePaciente(pacienteSeleccionado.id);
            cargarGiftcardsDePaciente(pacienteSeleccionado.id);
            cargarFichasMedicas(pacienteSeleccionado.id);
            cargarResumenPaciente(pacienteSeleccionado.id);
        } else {
            console.error('Paciente no encontrado:', pacienteId);
        }
    }
// -----------------------------SECCION DE MOSTRAR MODAL----------------------------------------------------
    function mostrarModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.visibility = 'visible';
            modal.classList.add('show');
        } else {
            console.warn(`El modal con id '${modalId}' no se encontró en el DOM.`);
        }
    }
// --------------------------------SECCION DE CIERRE MODAL--------------------------------------------------
    function cerrarModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('show');
            modal.style.visibility = 'hidden';
        }
    }
// -----------------------------SECCION DE INFORMACION GENERAL---------------------------------------------
    function rellenarModal(paciente) {
        const mostrarValorConAdvertencia = (valor, mensajeVacio) => {
            if (!valor) {
                return `<span class="campo-vacio-importante">${mensajeVacio} 
                        <i class="bi bi-exclamation-circle-fill text-danger" title="¡Este dato es importante!"></i>
                        </span>`;
            }
            return `<span class="campo-completo">${valor}</span>`;
        };

        const mostrarValor = (valor, mensajeVacio) => {
            if (!valor || valor === '0000-00-00') {
                return `<span class="campo-vacio">${mensajeVacio}</span>`;
            }
            return `<span class="campo-completo">${valor}</span>`;
        };

        // Concatenar nombres y apellidos, mostrando sólo los existentes
        const nombreCompleto = [paciente?.nombres, paciente?.apellidos]
            .filter(Boolean) // Elimina valores falsy (null, undefined, '')
            .join(' '); // Une los valores con un espacio

        const nombreCompletoMostrar = nombreCompleto.trim()
            ? nombreCompleto
            : 'Nombre no registrado';

        // Ajustar la clase dinámica del estado
        const estado = paciente?.estado_info || 'Pendiente';
        const estadoColor = estado === 'verificado' ? 'text-success' : 'text-warning';

        const elementos = [
            { id: 'detalle-id', valor: mostrarValor(paciente?.id, 'ID no disponible') },
            { id: 'detalle-rut', valor: mostrarValorConAdvertencia(paciente?.rut, 'RUT no registrado') },
            { id: 'detalle-nombre-completo', valor: mostrarValorConAdvertencia(nombreCompleto, 'Nombre no registrado') },
            { id: 'detalle-email', valor: mostrarValor(paciente?.email, 'Ninguno') },
            { id: 'detalle-telefono', valor: mostrarValor(paciente?.telefono, 'Ninguno') },
            { id: 'detalle-direccion', valor: mostrarValor(paciente?.direccion, 'No registrada') },
            { id: 'detalle-ciudad', valor: mostrarValor(paciente?.ciudad?.nombre, 'No especificado') },
            { id: 'detalle-fecha-nacimiento', valor: mostrarValor(paciente?.fecha_nacimiento, 'No especificado') },
            { id: 'detalle-genero', valor: mostrarValor(paciente?.genero, 'No especificado') },
            { 
                id: 'detalle-estado', 
                valor: `<span class="estado-badge ${estadoColor}">${estado.charAt(0).toUpperCase() + estado.slice(1)}</span>`
            },
            { 
                id: 'detalle-fecha-registro', 
                valor: mostrarValor(formatDate(paciente?.created_at), 'Fecha de registro no disponible') 
            },
            { id: 'detalle-comentario-adicional', valor: mostrarValor(paciente?.comentario_adicional, 'Ninguno') }
        ];

        elementos.forEach(({ id, valor }) => {
            const elemento = document.getElementById(id);
            if (elemento) {
                elemento.innerHTML = valor;
            }
        });
    }

// -----------------------------SECCION DE CARGA DE GIFTCARD POR PACIENTE-------------------------------------
    async function cargarGiftcardsDePaciente(pacienteId) {
        try {
            const response = await fetch(`/giftcards/paciente/${pacienteId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });

            if (!response.ok) {
                throw new Error('Error al obtener las Giftcards del paciente.');
            }

            const giftcards = await response.json();

            // Limpiar la tabla de Giftcards
            const tablaGiftcardsBody = document.querySelector('#giftcards .tabla-dinamica tbody');
            tablaGiftcardsBody.innerHTML = '';

            if (giftcards.length === 0) {
                tablaGiftcardsBody.innerHTML = `
                    <tr>
                        <td colspan="8" style="text-align: center;">No se encontraron Giftcards para este paciente.</td>
                    </tr>
                `;
            } else {
                giftcards.forEach((giftcard) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${giftcard.id}</td>
                        <td>${giftcard.fecha_compra ? new Date(giftcard.fecha_compra).toLocaleDateString() : 'No registrada'}</td>
                        <td>${giftcard.beneficiador_nombre}</td>
                        <td>${giftcard.promocion_nombre}</td>
                        <td>${formatCurrency(giftcard.valor)}</td>
                        <td>${giftcard.estatus_giftcard}</td>
                        <td>${giftcard.fecha_vencimiento ? new Date(giftcard.fecha_vencimiento).toLocaleDateString() : 'No registrada'}</td>
                        <td>${giftcard.trabajador_nombre}</td>
                    `;
                    tablaGiftcardsBody.appendChild(row);
                });
            }
        } catch (error) {
            console.error('Error al cargar las Giftcards del paciente:', error);
            alert('Hubo un error al cargar las Giftcards. Por favor, intente nuevamente.');
        }
    }
// -----------------------------SECCION DE CARGA DE RESERVA POR PACIENTE----------------------------------
    async function cargarReservasDePaciente(pacienteId) {
        try {
            const response = await fetch(`/reservas/paciente/${pacienteId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });

            if (!response.ok) {
                throw new Error('Error al obtener las reservas del paciente.');
            }

            const reservas = await response.json();

            // Limpiar la tabla de servicios adquiridos
            const tablaReservasBody = document.querySelector('#servicios .tabla-dinamica tbody');
            tablaReservasBody.innerHTML = '';

            if (reservas.length === 0) {
                tablaReservasBody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center;">No se encontraron reservas para este paciente.</td>
                    </tr>
                `;
            } else {
                reservas.forEach((reserva) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${reserva.id}</td>
                        <td>${new Date(reserva.fecha_reserva).toLocaleDateString()}</td>
                        <td>${reserva.servicio?.nombre || 'Sin servicio'}</td>
                        <td>${formatCurrency(reserva.precio)}</td>
                        <td>${reserva.asistencia || 'Pendiente'}</td>
                        <td>${reserva.estado_pago}</td>
                        
                    `;
                    tablaReservasBody.appendChild(row);
                });
            }
        } catch (error) {
            console.error('Error al cargar las reservas del paciente:', error);
            alert('Hubo un error al cargar las reservas. Por favor, intente nuevamente.');
        }
    }
// -----------------------------SECCION DE CARGA DE FICHA POR PACIENTE----------------------------------
    async function cargarFichasMedicas(pacienteId) {
        const cargaFichas = document.getElementById('carga-fichas');
        cargaFichas.style.display = 'block'; // Mostrar indicador de carga

        try {
            const response = await fetch(`/fichas/api?paciente_id=${pacienteId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!response.ok) {
                throw new Error(`Error al obtener las fichas médicas: ${response.statusText}`);
            }

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.message || 'No se pudo cargar la información de las fichas médicas.');
            }

            const fichas = data.data; // Extraer las fichas desde la respuesta
            const tablaBody = document.querySelector('#tabla-fichas-medicas tbody');
            tablaBody.innerHTML = ''; // Limpiar contenido previo

            if (fichas.length === 0) {
                // Si no hay fichas médicas, mostrar una fila indicando esto
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td colspan="5" style="text-align: center;">No se encontraron fichas médicas para este paciente.</td>
                `;
                tablaBody.appendChild(row);
            } else {
                // Si hay fichas, agregarlas a la tabla
                fichas.forEach(ficha => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${ficha.id}</td>
                        <td>${new Date(ficha.created_at).toLocaleDateString()}</td>
                        <td>${ficha.servicio?.nombre || 'Sin servicio'}</td>
                        <td>${ficha.trabajador ? `${ficha.trabajador.nombres} ${ficha.trabajador.apellidos}` : 'Sin trabajador'}</td>
                        <td>
                            <a href="/fichas/descargar/${ficha.id}" class="btn btn-primary">
                                Descargar
                            </a>
                        </td>
                    `;
                    tablaBody.appendChild(row);
                });
            }
        } catch (error) {
            console.error('Error al cargar las fichas médicas:', error);
            alert('Ocurrió un error al cargar las fichas médicas. Por favor, intenta nuevamente.');
        } finally {
            cargaFichas.style.display = 'none'; // Ocultar indicador de carga
        }
    }
// --------------------------SECCION DE CARGA DE RESUMEN FINANCIERO POR PACIENTE-------------------------
    async function cargarResumenPaciente(pacienteId) {
        const cargaResumen = document.getElementById('carga-resumen');
        const resumenContainer = document.getElementById('resumen-container');

        cargaResumen.style.display = 'block';
        resumenContainer.innerHTML = ''; // Limpiar contenido previo

        try {
            const response = await fetch(`/pacientes/${pacienteId}/resumen`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!response.ok) {
                throw new Error(`Error al obtener el resumen del paciente: ${response.statusText}`);
            }

            const data = await response.json();

            // Verificar si hay reservas
            const totalReservas = data.total_reservas;

            if (totalReservas === 0) {
                // Mostrar mensaje si no hay reservas
                resumenContainer.innerHTML = `
                    <div class="mensaje-sin-reservas">
                        <p>Aún no hay registros de reservas de este paciente.</p>
                    </div>
                `;
            } else {
                // Crear tarjetas de resumen
                let asistenciaColor = '';
                if (data.porcentaje_asistencia >= 80) {
                    asistenciaColor = 'bg-success'; // Verde
                } else if (data.porcentaje_asistencia > 50) {
                    asistenciaColor = 'bg-warning'; // Naranjo
                } else {
                    asistenciaColor = 'bg-danger'; // Rojo
                }

                const tarjetasResumen = `
                    <div class="tarjeta-resumen-row">

                        <div class="tarjeta-resumen">
                            <h4>Valor Total de Servicios</h4>
                            <p>${data.valor_total_servicios.toLocaleString('es-CL', { style: 'currency', currency: 'CLP' })}</p>
                        </div>

                        <div class="tarjeta-resumen">
                            <h4>Total de Servicios</h4>
                            <p>${data.total_reservas}</p>
                        </div>

                        <div class="tarjeta-resumen ${asistenciaColor}">
                            <h4>Porcentaje de Asistencia</h4>
                            <p>${data.porcentaje_asistencia.toFixed(2)}%</p>
                        </div>

                    </div>
                `;

                resumenContainer.innerHTML += tarjetasResumen;

                // Renderizar gráfico de asistencias
                const chartContainer = document.createElement('div');
                chartContainer.id = 'estado-asistencias-chart';
                resumenContainer.appendChild(chartContainer);

                const asistenciasChart = new ApexCharts(chartContainer, {
                    chart: { type: 'pie' },
                    series: Object.values(data.estado_asistencias),
                    labels: Object.keys(data.estado_asistencias),
                    colors: ['#72CBC9', '#FF6E6E', '#6c788c', '#FFC178'],
                    title: {
                        text: 'Distribución de Asistencias',
                        align: 'center',
                        style: {
                            fontSize: '16px',
                            fontWeight: 'bold',
                            fontFamily: 'Poppins, sans-serif',
                            color: '#333',
                        }
                    },
                    legend: {
                        position: 'left',
                        fontFamily: 'Poppins, sans-serif',
                    },
                    dataLabels: {
                        style: {
                            fontSize: '14px',
                            fontFamily: 'Poppins, sans-serif',
                            colors: ['#E9ECF1'],
                        }
                    }
                });
                asistenciasChart.render();
            }

        } catch (error) {
            console.error('Error al cargar el resumen:', error);
            alert('Ocurrió un error al cargar el resumen del paciente. Por favor, intenta nuevamente.');
        } finally {
            cargaResumen.style.display = 'none';
        }
    }

// -----------------------------DEPURADORES DE INFORMACION----------------------------------
    function formatCurrency(valor) {
        const valorRedondeado = Math.round(valor); // Redondea el valor al entero más cercano
        return `$${valorRedondeado.toLocaleString('es-CL')}`; // Formatea el número como moneda
    }

    function formatDate(dateString) {
        if (!dateString) return null; // Maneja valores nulos o indefinidos
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Meses van de 0 a 11
        const year = date.getFullYear();
        return `${day}/${month}/${year}`; // Formato DD/MM/YYYY
    }
// ------------------------------------MODAL DE EDITAR------------------------------------------
    if (btnEditarPaciente) {
        btnEditarPaciente.addEventListener('click', () => {
            abrirModalEdicion();
        });
    }

    // Función para abrir el modal de edición
    function abrirModalEdicion() {
        if (!pacienteSeleccionado) {
            alert('No se ha seleccionado ningún paciente.');
            return;
        }
        // Precargar los datos del paciente en el formulario
        document.getElementById('editar-rut').value = pacienteSeleccionado.rut || '';
        document.getElementById('editar-nombre').value = pacienteSeleccionado.nombres || '';
        document.getElementById('editar-apellido').value = pacienteSeleccionado.apellidos || '';
        document.getElementById('editar-email').value = pacienteSeleccionado.email || '';
        document.getElementById('editar-telefono').value = pacienteSeleccionado.telefono || '';
        document.getElementById('editar-direccion').value = pacienteSeleccionado.direccion || '';
        document.getElementById('editar-ciudad').value = pacienteSeleccionado.ciudad?.nombre || '';
        document.getElementById('editar-fecha-nacimiento').value = pacienteSeleccionado.fecha_nacimiento || '';
        document.getElementById('editar-genero').value = pacienteSeleccionado.genero || '';

        cerrarModal('modal-detalle-paciente');
        mostrarModal('modal-editar-paciente');
    }

// ------------------------------------MODAL DE ELIMINAR------------------------------------------
    window.abrirModalEliminar = function () {
        if (!pacienteSeleccionado) {
            alert('No se ha seleccionado ningún paciente.');
            return;
        }
        mostrarModal('modal-eliminar-paciente');
    };

    // Evento para confirmar la eliminación
    if (confirmarEliminarBtn) {
        confirmarEliminarBtn.addEventListener('click', async () => {
            if (!pacienteSeleccionado) {
                console.error('No hay un paciente seleccionado para eliminar.');
                return;
            }

            try {
                const response = await fetch(`/pacientes/${pacienteSeleccionado.id}`, {
                    method: 'DELETE', // Usamos DELETE para soft delete
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    }
                });

                if (response.ok) {
                    alert('Paciente eliminado con éxito.');
                    cerrarModal('modal-eliminar-paciente');
                    actualizarTabla(rowsPerPageSelect.value, currentPage); // Refrescar la tabla después de la eliminación
                } else {
                    const errorData = await response.json();
                    alert('Error al eliminar el paciente: ' + (errorData.message || 'Desconocido.'));
                }
            } catch (error) {
                console.error('Error al eliminar:', error);
                alert('Ocurrió un error al eliminar el paciente. Por favor, intenta de nuevo.');
            }
        });
    }

// ------------------------------------ACTUALIZA LA TABLA EN TIEMPO REAL------------------------------------------
    actualizarTabla(rowsPerPageSelect.value, 1);


// Enviar el formulario de edición mediante AJAX
document.getElementById('form-editar-paciente').addEventListener('submit', async (e) => {
    e.preventDefault();

    if (!pacienteSeleccionado) {
        alert('No se ha seleccionado ningún paciente.');
        return;
    }

    // Obtener datos del formulario
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());

    try {
        const response = await fetch(`/pacientes/${pacienteSeleccionado.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(data),
        });

        if (response.ok) {
            alert('Paciente actualizado con éxito.');
            cerrarModal('modal-editar-paciente');
            actualizarTabla(rowsPerPageSelect.value, currentPage); // Refrescar la tabla
        } else {
            const errorData = await response.json();
            alert('Error al actualizar el paciente: ' + (errorData.message || 'Error desconocido.'));
        }
    } catch (error) {
        console.error('Error al actualizar:', error);
        alert('Ocurrió un error al actualizar el paciente. Por favor, intenta de nuevo.');
    }
});

});
