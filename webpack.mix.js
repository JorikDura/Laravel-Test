const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css',
        []);

//подрубаем jQuery
mix.autoload({
    jquery: ['$', 'window.$', 'window.jQuery']
});

mix
    .css('resources/css/list_styles.css', 'public/css')
    .css('resources/css/auth_styles.css', 'public/css')
    .js('resources/js/create_list.js', 'public/js')
    .js('resources/js/bootstrap-inputs.js', 'public/js')
