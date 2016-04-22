var elixir = require('laravel-elixir');

/*
 * |-------------------------------------------------------------------------- |
 * Elixir Asset Management
 * |-------------------------------------------------------------------------- | |
 * Elixir provides a clean, fluent API for defining some basic Gulp tasks | for
 * your Laravel application. By default, we are compiling the Sass | file for
 * our application, as well as publishing vendor resources. |
 */

elixir(function(mix) {
	var src = 'resources/assets/jsx/*.jsx';
	var dest = 'public/react';
	
	mix.sass([ 'app.scss' ], 'public/css/app.css')

	.browserify('libraries.js')

	.copy(__dirname + '/resources/assets/js/pages',
			__dirname + '/public/js/pages');

});
