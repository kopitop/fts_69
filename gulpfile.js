const elixir = require('laravel-elixir');

elixir(function (mix) {
    mix.copy('resources/assets/js/admin/master.js', 'public/js/admin/master.js');
    mix.copy('resources/assets/js/user/master.js', 'public/js/user/master.js');
    mix.copy('resources/assets/js/user/suggestion.js', 'public/js/user/suggestion.js');
    mix.copy('resources/assets/sass/admin/master.scss', 'public/css/admin/master.css');
    mix.copy('resources/assets/sass/account/master.scss', 'public/css/account/master.css');
    mix.copy('resources/assets/sass/user/master.scss', 'public/css/user/master.css');
});
