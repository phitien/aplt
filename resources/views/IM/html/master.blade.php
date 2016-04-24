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
	{{ Html::script('js/app.js') }}
@show
    </head>
    <body>
        <div class="container" id="container">
@yield('top')
@yield('content')
@yield('bottom')
        </div>
    </body>
</html>