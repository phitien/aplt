<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8">
        <title>@yield('title')</title>
        <base href="/" target="_self">
@section('css')
	{{ Html::style('css/app.css') }}
@show
@section('script')
	{{ Html::script('js/libraries.js') }}
@show
    </head>
    <body>
@yield('top')
        <div class="container" id="container">
@yield('content')
        </div>
@yield('bottom')
    </body>
</html>