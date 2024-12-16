@extends('layouts.module')

@section('title', 'Módulo de Finazas')
@section('head')
    <script src="https://www.sandbox.paypal.com/sdk/js?client-id=AQcN0USsTc8UA0kuA3ffC_iPyfUJhkTKSwRjneoZQH_wOgEUoYJDufNNklysVmhmXfDT5ecHKYRdDcKO&currency=USD"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
@endsection

@section('sidebar')

@endsection

@section('content')
<h1>Pago con QR - PayPal</h1>
    <div class="form-container">
        <div class="form-group">
            <label for="servicio-select">Selecciona un servicio:</label>
            <select id="servicio-select">
                <option value="">-- Selecciona un servicio --</option>
                <!-- Los servicios se llenarán dinámicamente desde el backend -->
            </select>
        </div>
        <div class="form-group">
            <label for="amount">Total a pagar (USD):</label>
            <input type="number" id="amount" placeholder="0.00" readonly>
        </div>
        <button id="generateQR" disabled>Generar QR</button>
    </div>
    <div id="qrcode"></div>
    <div id="paypal-button-container"></div>

    <script>
        const PAYPAL_CLIENT_ID = 'AQcN0USsTc8UA0kuA3ffC_iPyfUJhkTKSwRjneoZQH_wOgEUoYJDufNNklysVmhmXfDT5ecHKYRdDcKO';
        const PAYPAL_SECRET = 'EDEEtUbTWSuPCyCZgUI02abicSB8-w31hkfz3D3k4yboyuh7uenGE6bwlA0JPtHUe-9h7Fc4fMtO61EX';
        const PAYPAL_API = 'https://api-m.sandbox.paypal.com';
        const CLP_TO_USD_RATE = 850; // Tasa de cambio fija para convertir CLP a USD

        document.addEventListener('DOMContentLoaded', async () => {
            const servicioSelect = document.getElementById('servicio-select');
            const amountInput = document.getElementById('amount');
            const generateQRButton = document.getElementById('generateQR');
            const qrContainer = document.getElementById('qrcode');

            // Llenar el dropdown de servicios dinámicamente
            try {
                const response = await axios.get('/api/servicios');
                response.data.forEach(servicio => {
                    const option = document.createElement('option');
                    option.value = servicio.precio;
                    option.textContent = `${servicio.nombre} - $${parseFloat(servicio.precio).toFixed(0)} CLP`;
                    servicioSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error al cargar los servicios:', error);
                alert('Error al cargar los servicios.');
            }

            // Actualizar el valor al seleccionar un servicio
            servicioSelect.addEventListener('change', () => {
                const selectedValue = servicioSelect.value;
                if (selectedValue) {
                    const amountInUSD = (parseFloat(selectedValue) / CLP_TO_USD_RATE).toFixed(2);
                    amountInput.value = amountInUSD;
                    generateQRButton.disabled = false;
                } else {
                    amountInput.value = '';
                    generateQRButton.disabled = true;
                }
            });

            // Generar QR al hacer clic en el botón
            generateQRButton.addEventListener('click', async () => {
                try {
                    generateQRButton.disabled = true;
                    generateQRButton.textContent = 'Generando...';

                    // Paso 1: Obtener un token de acceso
                    const authResponse = await axios.post(`${PAYPAL_API}/v1/oauth2/token`, 
                        'grant_type=client_credentials', 
                        {
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            auth: {
                                username: PAYPAL_CLIENT_ID,
                                password: PAYPAL_SECRET,
                            },
                        }
                    );
                    const accessToken = authResponse.data.access_token;

                    // Paso 2: Crear una orden de pago
                    const orderResponse = await axios.post(`${PAYPAL_API}/v2/checkout/orders`, 
                        {
                            intent: 'CAPTURE',
                            purchase_units: [
                                {
                                    amount: {
                                        currency_code: 'USD',
                                        value: amountInput.value,
                                    },
                                },
                            ],
                        },
                        {
                            headers: {
                                'Content-Type': 'application/json',
                                Authorization: `Bearer ${accessToken}`,
                            },
                        }
                    );
                    const approveLink = orderResponse.data.links.find(link => link.rel === 'approve').href;

                    // Paso 3: Generar el QR del enlace de pago
                    qrContainer.innerHTML = ''; // Limpiar cualquier QR previo
                    QRCode.toCanvas(approveLink, { width: 300 }, (error, canvas) => {
                        if (error) {
                            console.error(error);
                            alert('Error al generar el QR');
                        } else {
                            qrContainer.appendChild(canvas);
                        }
                        generateQRButton.textContent = 'Generar QR';
                        generateQRButton.disabled = false;
                    });

                } catch (error) {
                    console.error(error);
                    alert('Error al generar el pago con QR');
                    generateQRButton.textContent = 'Generar QR';
                    generateQRButton.disabled = false;
                }
            });

            // Renderizar el botón de PayPal
            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: { value: amountInput.value || '0.00' }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        alert('Gracias por tu compra, ' + details.payer.name.given_name + '!');
                    });
                },
                onError: function(err) {
                    console.error('Error durante el pago:', err);
                    alert('Ocurrió un error durante el pago. Por favor, inténtalo de nuevo.');
                }
            }).render('#paypal-button-container');
        });
    </script>
@endsection
<style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        #qrcode {
            margin: 20px auto;
            padding: 10px;
            border: 1px solid #ddd;
            display: inline-block;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:disabled {
            background-color: #ccc;
        }
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            text-align: left;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group select, .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group select {
            height: 45px;
        }
</style>
<script src="https://www.sandbox.paypal.com/sdk/js?client-id=AQcN0USsTc8UA0kuA3ffC_iPyfUJhkTKSwRjneoZQH_wOgEUoYJDufNNklysVmhmXfDT5ecHKYRdDcKO&currency=USD"></script>
