// Funciones utilitarias
function mostrarModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.visibility = 'visible';
        modal.classList.add('show');
    } else {
        console.warn(`El modal con id '${modalId}' no se encontró en el DOM.`);
    }
}

function cerrarModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        // Ocultar el modal
        modal.classList.remove('show');
        modal.style.visibility = 'hidden';
        modal.style.opacity = '0';

        // Asegurarse de limpiar eventos asociados
        modal.querySelectorAll('*').forEach((element) => {
            const clone = element.cloneNode(true); // Clona el nodo para eliminar eventos
            element.replaceWith(clone);
        });
    }
}


function obtenerFiltros(filtrosForm) {
    const formData = new FormData(filtrosForm);
    const params = new URLSearchParams();
    formData.forEach((value, key) => {
        if (value) {
            params.append(key, value);
        }
    });
    return params.toString();
}
