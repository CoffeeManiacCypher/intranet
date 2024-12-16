@extends('layouts.module')

@section('title', 'Módulo de Giftcards')

@vite(['resources/js/global/utilidades.js'])
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
<div id="alert-container"></div>

<div class="container">
    <h1>Crear Giftcard</h1>
    <form action="{{ route('giftcard.store') }}" method="POST" id="form-crear-giftcard">
        @csrf

        <div class="form-group">
            <label for="comprado_por">Comprado por:</label>
            <select id="comprado_por" name="comprado_por" class="form-control select2">
                <option value="">Seleccione un comprador</option>
            </select>
        </div>

        <div class="form-group">
            <label for="beneficiador_id">Beneficiario:</label>
            <select id="beneficiador_id" name="beneficiador_id" class="form-control select2">
                <option value="">Seleccione un beneficiario</option>
            </select>
        </div>

        <div class="form-group">
            <label for="trabajador_id">Vendido por (Trabajador):</label>
            <select id="trabajador_id" name="trabajador_id" class="form-control select2">
                <option value="">Seleccione un trabajador</option>
            </select>
        </div>

        <div class="form-group">
            <label for="promocion_id">Promoción:</label>
            <select id="promocion_id" name="promocion_id" class="form-control select2">
                <option value="">Seleccione una promoción</option>
            </select>
        </div>

        <div class="form-group">
            <label for="valor">Valor:</label>
            <input type="number" id="valor" name="valor" class="form-control" required min="0" placeholder="Ingrese el valor">
        </div>

        <div class="form-group">
            <label for="mensaje_personalizado">Mensaje Personalizado:</label>
            <textarea id="mensaje_personalizado" name="mensaje_personalizado" class="form-control" placeholder="Ingrese un mensaje opcional"></textarea>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-address-card fa-bounce"></i> Crear Giftcard</button>
    </form>
</div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Inicializar select2
        $('.select2').select2({
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: '100%', // Esto adapta el ancho del select al contenedor
        });

        // Cargar opciones dinámicamente
        function cargarOpciones(url, selectId) {
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById(selectId);
                    select.innerHTML = '<option value="">Seleccione una opción</option>';
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = `${item.nombres || ''} ${item.apellidos || item.nombre || ''}`.trim();
                        select.appendChild(option);
                    });
                    $(`#${selectId}`).trigger('change'); // Actualizar select2
                })
                .catch(error => console.error(`Error al cargar opciones para ${selectId}:`, error));
        }

        // Cargar datos para los select
        cargarOpciones("{{ route('giftcard.api.pacientes') }}", 'comprado_por');
        cargarOpciones("{{ route('giftcard.api.pacientes') }}", 'beneficiador_id');
        cargarOpciones("{{ route('giftcard.api.personal') }}", 'trabajador_id');
        cargarOpciones("{{ route('giftcard.api.promociones') }}", 'promocion_id');

        // Manejar el envío del formulario
        const form = document.getElementById("form-crear-giftcard");

        form.addEventListener("submit", function (event) {
            event.preventDefault(); // Evita que el formulario se envíe de forma tradicional

            const formData = new FormData(form); // Obtiene los datos del formulario

            // Envía la solicitud POST al servidor
            fetch("{{ route('giftcard.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json", // Asegura que Laravel devuelva JSON
                },
                body: formData,
            })
                .then((response) => {
                    if (!response.ok) {
                        // Si la respuesta no es OK, lanza un error
                        return response.json().then((data) => {
                            throw new Error(data.message || "Error al crear la giftcard");
                        });
                    }
                    return response.json(); // Procesa la respuesta si es exitosa
                })
                .then((data) => {
                    // Muestra el alert de éxito
                    mostrarAlert("success", "Giftcard creada exitosamente.", 3000);

                    // Redirecciona después de 3 segundos
                    setTimeout(() => {
                        window.location.href = "{{ route('giftcard.index') }}";
                    }, 3000);
                })
                .catch((error) => {
                    // Muestra el alert de error
                    mostrarAlert("error", error.message || "Error al crear la giftcard.", 5000);
                });
        });

        // Función para mostrar alertas dinámicamente
        function mostrarAlert(tipo, mensaje, duracion) {
            const alertContainer = document.getElementById("alert-container");

            const alert = document.createElement("div");
            alert.className = `alert alert-${tipo}`;
            alert.innerHTML = `
                <i class="${tipo === 'success' ? 'bi bi-check-circle-fill' : 'bi bi-exclamation-triangle-fill'}"></i> ${mensaje}
            `;

            alertContainer.appendChild(alert);

            // Remover alerta después de la duración
            setTimeout(() => {
                alert.remove();
            }, duracion);
        }
    });
</script>



<style>
/* Ajustar la altura de Select2 */
/* Estilo principal de Select2 para ajustar altura */
.select2-container .select2-selection--single {
    height: 50px; /* Ajusta la altura deseada */
    display: flex;
    align-items: center; /* Centra el texto verticalmente */
    padding: 0 10px; /* Ajusta el padding interno */
    border-radius: 8px; /* Bordes redondeados */
    font-size: 1rem;
    border: 1px solid #ccc; /* Borde predeterminado */
    transition: all 0.3s ease;
}

/* Ajustar el dropdown para coincidir con el diseño */
.select2-container .select2-dropdown {
    border-radius: 8px;
    font-size: 1rem;
}

/* Flecha del selector */
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 100%;
    display: flex;
    align-items: center; /* Centra la flecha verticalmente */
    right: 10px; /* Ajusta la posición */
}

/* Opciones del dropdown */
.select2-results__option {
    padding: 10px; /* Espaciado entre las opciones */
}

/* Opcional: Indicador de selección activa */
.select2-results__option--highlighted {
    background-color: #72CBC9;
    color: #fff;
}

/* Placeholder dinámico */
.select2-container .select2-selection__placeholder {
    color: #aaa;
    font-style: italic;
}

    /* Contenedor principal */
.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    animation: fadeIn 1s ease-in-out;
    background-color: #FAFCFF;
}

/* Animación de entrada */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Título del formulario */
.container h1 {
    font-size: 2rem;
    text-align: center;
    color: #333;
    margin-bottom: 20px;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

/* Estilos de los grupos del formulario */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: bold;
    color: #555;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

/* Estilo de los inputs */
.form-control {
    width: 100%;
    padding: 10px 12px;
    font-size: 1rem;
    color: #333;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 8px;
    transition: all 0.3s ease;
    max-width: 400px; /* O puedes especificar un tamaño máximo */
    min-width: 250px; /* Para evitar que sean demasiado pequeños */
}

.form-control:focus {
    outline: none;
    border-color: #72CBC9;
    box-shadow: 0 0 8px rgba(114, 203, 201, 0.5);
}


/* Botones */
button[type="submit"] {
    width: 100%;
    padding: 12px;
    font-size: 1.2rem;
    font-weight: bold;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

button[type="submit"]:hover {
    background: linear-gradient(135deg, #0D79AE, #72CBC9);
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
}

button[type="submit"]:active {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

/* Mensaje de error o éxito */
.alert {
    margin-top: 10px;
    padding: 12px;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: bold;
    text-align: center;
}

.alert-success {
    background: #D6EFD8;
    color: #2E7D32;
    border: 1px solid #AED581;
}

.alert-error {
    background: #FFCDD2;
    color: #C62828;
    border: 1px solid #E57373;
}

/* Placeholder dinámico */
.form-control::placeholder {
    color: #aaa;
    font-style: italic;
}

/* Validación personalizada */
input:invalid {
    border-color: #E57373;
    box-shadow: 0 0 8px rgba(229, 115, 115, 0.5);
}

input:valid {
    border-color: #AED581;
    box-shadow: 0 0 8px rgba(173, 229, 129, 0.5);
}

</style>
