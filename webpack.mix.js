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
mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/index.js', 'public/js')
//    .js('resources/js/result.js', 'public/js')
   .js('resources/js/detail.js', 'public/js')
   .js('resources/js/user.js', 'public/js')
   .js('resources/js/userList.js', 'public/js')
   .js('resources/js/newBook.js', 'public/js')
//    .js('resources/js/ranking.js', 'public/js')
   .js('resources/js/slick.min.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
