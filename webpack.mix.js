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


// mix.js('resources/js/app.js', 'public/js/app.js')
//     .sass('resources/sass/dashboard/skin_blue.scss', 'public/css/dashboard')
//     .sass('resources/sass/dashboard/dashcore.scss', 'public/css/dashboard')
//     .sass('resources/sass/app.scss', 'public/css/bootstrap.css');

mix.sass('resources/sass/app.scss','public/css/app.css')
    .js('resources/js/app.js', 'public/js/app.js');