document.addEventListener('DOMContentLoaded', () => {
    // Referencias principales
    const tablaBody = document.querySelector('.tabla-dinamica tbody');
    const rowsPerPageSelect = document.getElementById('rows-per-page') || { value: 10 }; // Fallback si no existe
    const modalEditar = document.getElementById('modal-editar-servicio');
    const modalEliminar = document.getElementById('modal-eliminar-servicio');
    const btnConfirmarEliminar = document.getElementById('confirmar-eliminar-servicio');
    const formEditar = document.getElementById('form-editar-servicio');
    const botonFiltro = document.getElementById('boton-filtro');
    const filtrosContenedor = document.getElementById('filtros-contenedor');
    const modalInformacion = document.getElementById('modal-informacion-servicio');
    let servicioSeleccionado = null;
    

    tablaBody.addEventListener('click', (event) => {
        const fila = event.target.closest('tr');
        if (fila && fila.hasAttribute('data-servicio-id')) {
            const servicioId = fila.getAttribute('data-servicio-id');
            cargarDetallesServicio(servicioId);
        }
    });
    // Cargar detalles del servicio en el modal
    function cargarDetallesServicio(servicioId) {
        fetch(`/servicios/${servicioId}/edit`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        })
            .then((response) => {
                if (!response.ok) throw new Error('Error al cargar el servicio');
                return response.json();
            })
            .then((data) => {
                servicioSeleccionado = data.id;
                document.getElementById('detalle-id').textContent = data.id;
                document.getElementById('detalle-nombre').textContent = data.nombre;
                document.getElementById('detalle-categoria').textContent = data.categoria_nombre || 'Sin Categoría';
                document.getElementById('detalle-precio').textContent = `$${Math.round(data.precio).toLocaleString('es-CL')}`;
                document.getElementById('detalle-duracion').textContent = formatDuration(data.duracion);
                document.getElementById('detalle-descripcion').textContent = data.descripcion || 'Sin descripción';
                mostrarModal(modalInformacion);
            })
            .catch((error) => {
                console.error('Error al cargar el servicio:', error);
            });
    }
    

    // Mostrar modal
    function mostrarModal(modal) {
        modal.style.visibility = 'visible';
        modal.classList.add('show');
    }
    window.actualizarTabla = function (perPage = 10, pagina = 1) {
        const url = new URL(`/servicios`, window.location.origin);
        url.searchParams.set('page', pagina);
        url.searchParams.set('per_page', perPage);

        const formData = new FormData(document.getElementById('filtros-form'));
        formData.forEach((value, key) => {
            if (value) url.searchParams.set(key, value);
        });

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then((response) => {
                if (!response.ok) throw new Error(`Error del servidor: ${response.status}`);
                return response.json();
            })
            .then((data) => {
                if (!data || !data.data) throw new Error('Datos inválidos o incompletos');
                actualizarTablaBody(data.data);
                actualizarControlesPaginacion(data);
            })
            .catch((error) => {
                console.error('Error al actualizar la tabla:', error);
                mostrarErrorTabla();
            });
    };

    /**
     * Actualizar el cuerpo de la tabla
     */
    function actualizarTablaBody(servicios) {
        tablaBody.innerHTML = '';
        if (servicios.length === 0) {
            tablaBody.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align: center;">No se encontraron registros</td>
                </tr>`;
            return;
        }
    
        servicios.forEach((servicio) => {
            const row = `
                <tr data-servicio-id="${servicio.id}">
                    <td>${servicio.id}</td>
                    <td>${servicio.nombre}</td>
                    <td>${servicio.categoria?.nombre || 'Sin categoría'}</td> <!-- Verifica que esto esté actualizado -->
                    <td>${formatCurrency(servicio.precio)}</td>
                </tr>`;
            tablaBody.innerHTML += row;
        });
    }
    

    /**
     * Actualizar los controles de paginación
     */
    function actualizarControlesPaginacion(data) {
        const paginationControls = document.querySelector('.tabla-navegacion');
        paginationControls.innerHTML = `
            ${data.prev_page_url
                ? `<button class="btn btn-primary" onclick="actualizarTabla(${rowsPerPageSelect.value}, ${data.current_page - 1})">Anterior</button>`
                : `<button class="btn" disabled>Anterior</button>`}
            <span>Página ${data.current_page} de ${data.last_page}</span>
            ${data.next_page_url
                ? `<button class="btn btn-primary" onclick="actualizarTabla(${rowsPerPageSelect.value}, ${data.current_page + 1})">Siguiente</button>`
                : `<button class="btn" disabled>Siguiente</button>`}`;
    }

    botonFiltro.addEventListener('click', () => {
        filtrosContenedor.classList.toggle('visible');
        filtrosContenedor.style.transition = 'transform 0.3s ease';
    });

    /**
     * Mostrar error en la tabla
     */
    function mostrarErrorTabla() {
        tablaBody.innerHTML = `
            <tr>
                <td colspan="6" style="text-align: center; color: red;">Error al cargar los datos</td>
            </tr>`;
    }

    /**
     * Abrir modal de edición
     */
    window.abrirModalEditar = function (servicioId = servicioSeleccionado) {
        if (!servicioId) return;
    
        // Cerrar el modal de información antes de abrir el de edición
        cerrarModal('modal-informacion-servicio');
    
        fetch(`/servicios/${servicioId}/edit`)
            .then((response) => {
                if (!response.ok) throw new Error('Error al cargar el servicio');
                return response.json();
            })
            .then((data) => {
                rellenarFormularioEdicion(data);
                mostrarModal(modalEditar);
            })
            .catch((error) => {
                console.error('Error al cargar el servicio:', error);
            });
    };

    /**
     * Rellenar formulario de edición
     */
    function rellenarFormularioEdicion(servicio) {
        document.getElementById('editar-nombre').value = servicio.nombre;
        document.getElementById('editar-categoria_id').value = servicio.categoria_servicio_id;
        document.getElementById('editar-precio').value = servicio.precio;
        document.getElementById('editar-duracion').value = servicio.duracion;
        document.getElementById('editar-descripcion').value = servicio.descripcion;
    }
    // Manejar envío del formulario de edición
    formEditar.addEventListener('submit', (event) => {
        event.preventDefault();
        if (!servicioSeleccionado) return;
    
        const formData = new FormData(formEditar);
    
        // Convertir FormData a JSON
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });
    
        fetch(`/servicios/${servicioSeleccionado}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(data), // Enviar como JSON
        })
            .then((response) => {
                if (!response.ok) throw new Error('Error al actualizar el servicio');
                return response.json();
            })
            .then(() => {
                // Mostrar alert de éxito
                showAlert('success', 'Los cambios se han guardado correctamente.');
    
                // Actualizar la tabla
                actualizarTabla(rowsPerPageSelect.value, 1);
    
                // Cerrar ambos modales después de 3 segundos
                setTimeout(() => {
                    cerrarModal('modal-editar-servicio');
                    cerrarModal('modal-informacion-servicio');
                }, 3000);
            })
            .catch((error) => {
                console.error('Error al actualizar el servicio:', error);
                // Mostrar alert de error
                showAlert('error', 'Hubo un problema al guardar los cambios. Intente nuevamente.');
            });
    });
    

    function showAlert(type, message) {
        const alertContainer = document.createElement('div');
        alertContainer.className = `alert alert-${type}`;
        alertContainer.textContent = message;
    
        document.body.appendChild(alertContainer);
    
        setTimeout(() => {
            alertContainer.remove();
        }, 3000); // Eliminar el alert después de 3 segundos
    }
    
    /**
     * Abrir modal de eliminación
     */
    window.abrirModalEliminar = function (servicioId) {
        servicioSeleccionado = servicioId;
        mostrarModal(modalEliminar);
    };

    /**
     * Confirmar eliminación
     */
    btnConfirmarEliminar.addEventListener('click', () => {
        if (!servicioSeleccionado) return;

        fetch(`/servicios/${servicioSeleccionado}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        })
            .then((response) => {
                if (!response.ok) throw new Error('Error al eliminar el servicio');
                actualizarTabla(rowsPerPageSelect.value, 1);
                cerrarModal('modal-eliminar-servicio');
            })
            .catch((error) => {
                console.error('Error al eliminar el servicio:', error);
            });
    });

    /**
     * Mostrar un modal
     */
    function mostrarModal(modal) {
        modal.style.visibility = 'visible';
        modal.classList.add('show');
    }

    /**
     * Cerrar un modal
     */
    window.cerrarModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.visibility = 'hidden';
            modal.classList.remove('show');
        }
    };

    /**
     * Formatear precios como moneda
     */
    function formatCurrency(precio) {
        const valorRedondeado = Math.round(precio); // Redondea el valor al entero más cercano
        return `$${valorRedondeado.toLocaleString('es-CL')}`; // Formatea el número como moneda
    }

    /**
     * Formatear duración en horas y minutos
     */
    function formatDuration(duracion) {
        if (!duracion) return 'No especificada';
        const horas = Math.floor(duracion / 60);
        const minutos = duracion % 60;
        return `${horas > 0 ? `${horas} hora${horas > 1 ? 's' : ''}` : ''} ${minutos > 0 ? `${minutos} minuto${minutos > 1 ? 's' : ''}` : ''}`.trim();
    }

    // Inicializar la tabla
    actualizarTabla(rowsPerPageSelect.value, 1);

    // Manejar envío del formulario de edición
    formEditar.addEventListener('submit', (event) => {
        event.preventDefault();
        if (!servicioSeleccionado) return;

        const formData = new FormData(formEditar);
        fetch(`/servicios/${servicioSeleccionado}`, {
            method: 'PUT',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: formData,
        })
            .then((response) => {
                if (!response.ok) throw new Error('Error al actualizar el servicio');
                actualizarTabla(rowsPerPageSelect.value, 1);
                cerrarModal('modal-editar-servicio');
            })
            .catch((error) => {
                console.error('Error al actualizar el servicio:', error);
            });
    });
    actualizarTabla(rowsPerPageSelect.value, 1);
});
