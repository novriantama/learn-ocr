const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */


mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);

mix;

mix.styles([
    'public/dist/css/style.css',
    'public/dist/css/components.css',
    'public/dist/css/jquery.selectareas.css'
], 'public/css/app.css');

mix.scripts([
    'public/dist/js/stisla.js',
    'public/dist/js/scripts.js',
    'public/dist/js/custom.js',
], 'public/js/app-plugin.js');