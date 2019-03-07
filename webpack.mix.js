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
    .sass('resources/sass/app.scss', 'public/css/app.css')
    .js('resources/js/app.js', 'public/js/app.js')

    // Admin pannel assets
    .js('resources/admin-assets/js/app.js', 'public/admin-assets/js/admin.js')
    .sass('resources/admin-assets/sass/app.scss', 'public/admin-assets/css/admin.css')
    .copyDirectory('resources/admin-assets/imgs', 'public/admin-assets/imgs')

    // Shop front assets
    .scripts([
        // Bootstrap
        'resources/front-assets/js/jquery-3.2.1.min.js',
        'resources/front-assets/js/popper.min.js',
        'resources/front-assets/js/bootstrap.min.js',

        // Rev slider js
        'resources/front-assets/vendors/revolution/js/jquery.themepunch.tools.min.js',
        'resources/front-assets/vendors/revolution/js/jquery.themepunch.revolution.min.js',
        'resources/front-assets/vendors/revolution/js/extensions/revolution.extension.actions.min.js',
        'resources/front-assets/vendors/revolution/js/extensions/revolution.extension.video.min.js',
        'resources/front-assets/vendors/revolution/js/extensions/revolution.extension.slideanims.min.js',
        'resources/front-assets/vendors/revolution/js/extensions/revolution.extension.layeranimation.min.js',
        'resources/front-assets/vendors/revolution/js/extensions/revolution.extension.navigation.min.js',

        // Extra plugin js
        'resources/front-assets/vendors/counterup/jquery.waypoints.min.js',
        'resources/front-assets/vendors/counterup/jquery.counterup.min.js',
        'resources/front-assets/vendors/owl-carousel/owl.carousel.min.js',
        'resources/front-assets/vendors/bootstrap-selector/js/bootstrap-select.min.js',
        'resources/front-assets/vendors/image-dropdown/jquery.dd.min.js',
        'resources/front-assets/js/smoothscroll.js',
        'resources/front-assets/vendors/isotope/imagesloaded.pkgd.min.js',
        'resources/front-assets/vendors/isotope/isotope.pkgd.min.js',
        'resources/front-assets/vendors/magnify-popup/jquery.magnific-popup.min.js',
        'resources/front-assets/vendors/vertical-slider/js/jQuery.verticalCarousel.js',
        'resources/front-assets/vendors/jquery-ui/jquery-ui.js',
        'resources/front-assets/js/theme.js'
    ], 'public/js/front-vendor.js')
    .js('resources/front-assets/js/app.js', 'public/js/front.js')
    .sass('resources/front-assets/sass/app.scss', 'public/css/front.css')
    .copyDirectory('resources/front-assets/img', 'public/img')
