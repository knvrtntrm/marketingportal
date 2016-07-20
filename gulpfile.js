var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */



elixir(function(mix) {
    mix.scripts([
       'vendor/angular.min.js',
        'vendor/angular-animate.min.js',
        'vendor/angular-route.min.js',
        'vendor/bootstrap-datepicker.min.js',
        'vendor/semantic.min.js',
        'vendor/html2canvas.js',
        'vendor/canvas2svg.js',
        'vendor/canvas2image.js',
        'vendor/base64.min.js',
        'vendor/angular-sanitize.js',
        'vendor/ngToast.min.js'
    ], 'public/js/vendor.js');
    mix.styles([
        'vendor/semantic.min.css',
        'vendor/animate.css',
        'vendor/ngToast-animations.min.css',
        'vendor/ngToast.min.css'
    ]);
    mix.sass('app.scss');
    mix.browserify('app.js','public/js/main.js');
});

