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
<!-- 	{{ Html::script('js/jquery-2.2.3.min.js') }} -->
<!-- 	{{ Html::script('js/react-15.0.1/build/react.js') }} -->
<!-- 	{{ Html::script('js/react-15.0.1/build/react-dom.js') }} -->
<!-- 	{{ Html::script('js/browser.min.js') }} -->
 
	{{ Html::script('js/libraries.js') }}
@show
    </head>
    <body>
@yield('top')
@section('sidebar') @show
        <div class="container" id="container"></div>
@yield('bottom')
    </body>
</html>