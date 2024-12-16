document.addEventListener('DOMContentLoaded', () => {
    // Referencias principales
    const modalNavButtons = document.querySelectorAll('.modal-nav .nav-btn'); // Botones de navegación del modal
    const modalSections = document.querySelectorAll('.modal-body .modal-section'); // Secciones del modal
    const modalDetalleGiftcard = document.getElementById('modal-detalle-giftcard'); // Modal principal
    const modalCobrar = document.getElementById('modal-cobrar-giftcard');
    const btnConfirmarCobrar = document.getElementById('confirmar-cobrar-giftcard');
    let giftcardSeleccionada = null; // Variable para almacenar la giftcard seleccionada
    let modalAbierto = false; // Estado del modal para evitar conflictos


    /**
     * Función para cambiar entre secciones del modal
     */
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

    /**
     * Función para abrir el modal y rellenar datos
     */
    function abrirModalGiftcard(giftcardId) {
        if (modalAbierto) return; // Evita conflictos si ya está abierto

        giftcardSeleccionada = giftcardsData.find((g) => g.id == giftcardId);
        if (giftcardSeleccionada) {
            rellenarModal(giftcardSeleccionada);
            mostrarModal(modalDetalleGiftcard);
            modalAbierto = true; // Marcar como abierto
        } else {
            alert('Giftcard no encontrada.');
        }
    }
    
    function mostrarModal(modal) {
        if (!modal || modal.classList.contains('show')) return;
        modal.style.visibility = 'visible';
        modal.classList.add('show');
        cambiarSeccion('informacion-general');
    }
    
    function cerrarModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.visibility = 'hidden';
            modal.classList.remove('show');
            resetearEstadoModal(modalId);
            modalAbierto = false; // Marcar como cerrado
        }
    }

    /**
     * Función para resetear el estado del modal
     */
    function resetearEstadoModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
    
        modalNavButtons.forEach((btn) => btn.classList.remove('active'));
        modalNavButtons[0].classList.add('active');
    
        modalSections.forEach((section) => {
            section.style.display = section.id === 'informacion-general' ? 'block' : 'none';
            section.classList.toggle('active', section.id === 'informacion-general');
        });
        // Solo limpiar datos si realmente es necesario
    }
    

    /**
     * Recalcular la altura del modal
     */
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
    
    

    /**
     * Función auxiliar para capitalizar cadenas
     */
    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    /**
     * Función auxiliar para formatear números como moneda
     */
    function formatCurrency(valor) {
        return `$${valor.toLocaleString('es-CL')}`;
    }

    
});


