// Función para actualizar controles de paginación
function actualizarControlesPaginacion(data, paginationControls, actualizarTabla, rowsPerPageSelect) {
    const filtros = obtenerFiltros(filtrosForm);
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
