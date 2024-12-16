<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Menú Principal')</title>

    @vite(['resources/css/global/root.css'])
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://www.sandbox.paypal.com/sdk/js?client-id=AQcN0USsTc8UA0kuA3ffC_iPyfUJhkTKSwRjneoZQH_wOgEUoYJDufNNklysVmhmXfDT5ecHKYRdDcKO&currency=USD"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

</head>
<body>
    
    <div class="home-layout">

        <div class="animated-background"></div>

            <main>
                @yield('content') <!-- Sección de contenido dinámico -->
            </main>

    </div>

    <!-- Scripts generales -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
