var elixir = require('laravel-elixir');

elixir(function(mix) {

	mix.sass([ 'app.scss' ], 'public/css/app.css')

	.browserify('jsx/libraries.jsx', 'public/js')
	
	.browserify('jsx/common.jsx', 'public/js')
	
	.browserify('jsx/app.jsx', 'public/js')

	.browserify('jsx/pages/index.jsx', 'public/js/pages')

	.browserify('jsx/pages/register.jsx', 'public/js/pages')

	.browserify('jsx/pages/login.jsx', 'public/js/pages')

	.browserify('jsx/pages/code.jsx', 'public/js/pages')

	.browserify('jsx/pages/deactivate.jsx', 'public/js/pages')

	.browserify('jsx/pages/password.jsx', 'public/js/pages')

	.browserify('jsx/pages/email.jsx', 'public/js/pages')

	.browserify('jsx/pages/account.jsx', 'public/js/pages')
	
	.browserify('jsx/pages/location.jsx', 'public/js/pages')
	
	.browserify('jsx/pages/newitem.jsx', 'public/js/pages')

	.copy('node_modules/jquery-ui/themes', 'public/css/jquery-ui/themes')
	
	.copy('resources/assets/js/socket.io-1.3.4.js', 'public/js')
	
	.copy('resources/assets/js/jquery-migrate-1.2.1.min.js', 'public/js');
	
});
