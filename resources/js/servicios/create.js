document.getElementById('form-crear-servicio').addEventListener('submit', (event) => {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
    })
        .then((response) => {
            if (!response.ok) {
                return response.json().then((errorData) => {
                    throw new Error(errorData.message || 'Error al crear el servicio');
                });
            }
            return response.json();
        })
        .then((data) => {
            alert(data.message || 'Servicio creado exitosamente.');
            window.location.href = '/servicios';
        })
        .catch((error) => {
            console.error('Error al crear el servicio:', error.message);
            alert(`Error: ${error.message}`);
        });
});
