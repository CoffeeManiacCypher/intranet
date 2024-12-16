const mix = require('laravel-mix');

mix.css('resources/css/root.css', 'public/css')
   .css('resources/css/botones.css', 'public/css');

   // Compilar archivos JS y CSS
mix.js('resources/js/app.js', 'public/js')
.sass('resources/sass/app.scss', 'public/css');

// Copiar otros activos automáticamente
mix.copyDirectory('resources/img/icons', 'public/img/icons');