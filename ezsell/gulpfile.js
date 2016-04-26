var elixir = require('laravel-elixir');

elixir(function(mix) {

	mix.sass([ 'app.scss' ], 'public/css/app.css')

	.browserify('jsx/libraries.jsx', 'public/js')

	.browserify('jsx/pages/register.jsx', 'public/js/pages');

});
