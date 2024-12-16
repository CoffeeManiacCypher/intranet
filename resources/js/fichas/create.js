document.addEventListener('DOMContentLoaded', () => {
    const pacienteSelect = $('#paciente_id');
    const servicioSelect = $('#servicio_id');
    const trabajadorSelect = $('#trabajador_id');

    // Inicializar Select2
    pacienteSelect.select2({
        placeholder: 'Seleccione un paciente',
        ajax: {
            url: '/fichas/api/pacientes',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data.map(paciente => ({
                        id: paciente.id,
                        text: `${paciente.nombres} ${paciente.apellidos}`,
                    })),
                };
            },
        },
    });

    servicioSelect.select2({
        placeholder: 'Seleccione un servicio',
        ajax: {
            url: '/fichas/api/servicios',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data.map(servicio => ({
                        id: servicio.id,
                        text: servicio.nombre,
                    })),
                };
            },
        },
    });

    trabajadorSelect.select2({
        placeholder: 'Seleccione un trabajador',
        ajax: {
            url: '/fichas/api/trabajadores',
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data.map(trabajador => ({
                        id: trabajador.id,
                        text: `${trabajador.nombres} ${trabajador.apellidos}`,
                    })),
                };
            },
        },
    });
});
