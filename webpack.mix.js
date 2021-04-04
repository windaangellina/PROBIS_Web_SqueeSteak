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

mix
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/konfirmasi.js', 'public/js')
    .js('resources/js/menu/ajax-list.js', 'public/js/menu')
    .js('resources/js/menu/ajax-list-basic.js', 'public/js/menu')
    .js('resources/js/food_order/ajax-list.js', 'public/js/food_order')
    .js('resources/js/customer_order/ajax-list.js', 'public/js/customer_order')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);

// file yg masuk ke storage lgsg dicopy ke public
mix.copyDirectory('storage/app/public', 'public/resources');
