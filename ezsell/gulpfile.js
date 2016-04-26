var gulp       = require('gulp');
var browserify = require('browserify');
var source     = require('vinyl-source-stream');
var reactify   = require('reactify');


var Elixir = require('laravel-elixir');
var bundle;
var $ = Elixir.Plugins;
var config = Elixir.config;

Elixir.extend('reactify', function(src, output, baseDir) {
	var paths = new Elixir.GulpPaths()
    .src(src, baseDir || config.get('assets.js.folder'))
    .output(output || config.get('public.js.outputFolder'));

	new Elixir.Task('reactify', function() {
        this.log(paths.src, paths.output);

        var stream = browserify();
        stream.transform(reactify);
        
        return (
    		stream.bundle()
            .pipe(source(paths.src))
            .pipe(gulp.dest(paths.output))
        );
    })
    .watch();
});

//// Create a new command for Laravel Elixir that will browserify and Reactify
//elixir.extend('reactifyBrowserifyElixir', function(inputFile, inputFileName, outputDirectory) {
//    gulp.task('browserify_and_reactify', function() {
//        var b = browserify();
//        b.transform(reactify); 
//        b.add(inputFile);
//        return b.bundle()
//            .pipe(source(inputFileName))
//            .pipe(gulp.dest(outputDirectory));
//    });
//    return this.register('browserify_and_reactify');
//});

var elixir = require('laravel-elixir');

elixir(function(mix) {

	mix.reactify('jsx/register.jsx', 'public/js/react')

	mix.sass([ 'app.scss' ], 'public/css/app.css')

	.browserify('libraries.js');

// .copy(__dirname + '/resources/assets/js/pages',
// __dirname + '/public/js/pages');

});
