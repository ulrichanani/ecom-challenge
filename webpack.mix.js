const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .sass('resources/sass/app.scss', 'public/css/app.css')
    .sass('resources/admin/sass/app.scss', 'public/administration/css/admin.css')
    .copyDirectory('resources/admin/imgs', 'public/administration/imgs')
    .js('resources/js/app.js', 'public/js/app.js')
    .js('resources/admin/js/app.js', 'public/administration/js/admin.js')
