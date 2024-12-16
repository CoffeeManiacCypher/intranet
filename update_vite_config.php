<?php

$jsFiles = glob('resources/js/**/*.js');
$cssFiles = glob('resources/css/**/*.css');

// Formatear rutas para Vite
$viteEntries = array_merge(
    array_map(fn($file) => "'" . str_replace('\\', '/', $file) . "'", $jsFiles),
    array_map(fn($file) => "'" . str_replace('\\', '/', $file) . "'", $cssFiles)
);

$configTemplate = <<<EOT
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
            {entries}
        ]),
    ],
});
EOT;

$configContent = str_replace('{entries}', implode(",\n            ", $viteEntries), $configTemplate);

file_put_contents('vite.config.js', $configContent);
echo "vite.config.js actualizado con éxito.\n";
