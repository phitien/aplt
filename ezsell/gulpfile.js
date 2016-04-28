var elixir = require('laravel-elixir');

elixir(function(mix) {

	mix.sass([ 'app.scss' ], 'public/css/app.css')

	.browserify('jsx/libraries.jsx', 'public/js')
	
	.browserify('jsx/pages/index.jsx', 'public/js/pages')

	.browserify('jsx/pages/register.jsx', 'public/js/pages')
	
	.browserify('jsx/pages/login.jsx', 'public/js/pages')
	
	.browserify('jsx/pages/code.jsx', 'public/js/pages')
	
	.browserify('jsx/pages/deactivate.jsx', 'public/js/pages')
	
	.browserify('jsx/pages/password.jsx', 'public/js/pages')
	
	.browserify('jsx/pages/email.jsx', 'public/js/pages')
	
	.browserify('jsx/pages/account.jsx', 'public/js/pages');

});
