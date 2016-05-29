var elixir = require('laravel-elixir');

elixir(function(mix) {

	var bootstrapPath = 'node_modules/bootstrap-sass/assets';

	mix.sass([ 'app.scss' ], 'public/css/app.css')

	.copy(bootstrapPath + '/fonts', 'public/fonts')

	.copy(bootstrapPath + '/javascripts/bootstrap.min.js', 'public/js')

	.copy('resources/assets/images', 'public/images')

	.copy('node_modules/jquery-ui/themes', 'public/css/jquery-ui/themes')

	.copy('resources/assets/js/socket.io-1.3.4.js', 'public/js')

	.copy('resources/assets/jemotion', 'public/jemotion')
	
	.copy('resources/assets/wait-me', 'public/wait-me')

	.browserify('jsx/libraries.jsx', 'public/js')

	.browserify('jsx/common.jsx', 'public/js')

	.browserify('jsx/app.jsx', 'public/js');

});
