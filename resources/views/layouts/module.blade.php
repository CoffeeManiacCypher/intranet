<!DOCTYPE html>
<html lang="es">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Módulo')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('head')
    
    @vite(['resources/css/global/app.css', 'resources/js/global/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

</head>

<body>

    <div class="layout-container">

        <!-- Es el menú de opciones donde iran todas las acciones o areas del modulo en si -->
        <aside class="layout-sidebar">
            @yield('sidebar')
        </aside>

        <!-- Esta es el area del contenido principal, donde iran los demas containers para mostrar mas info de la seccion, como el típico CRUD-->
        <main class="layout-content">
            <div class="content-wrapper">
                <div class="content-main">
                    @yield('content')
                </div>
            </div>
        </main>
        
    </div>

</body>
</html>