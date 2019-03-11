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
    // Global Assets
    .scripts([
        'node_modules/toastr/toastr.js',
        '/node_modules/select2/dist/js/select2.js',
    ], 'public/js/app-vendor.js')

    // Admin pannel assets
    .js('resources/admin-assets/js/app.js', 'public/admin-assets/js/admin.js')
    .sass('resources/admin-assets/sass/app.scss', 'public/admin-assets/css/admin.css')
    .copyDirectory('resources/admin-assets/imgs', 'public/admin-assets/imgs')

    // Shop front assets
    .js('resources/front-assets/js/app.js', 'public/js/front.js')
    .sass('resources/front-assets/sass/app.scss', 'public/css/front.css')
    .copyDirectory('resources/front-assets/img', 'public/img')
