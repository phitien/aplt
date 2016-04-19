<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8">
        <title>@yield('title')</title>
        <base href="/" target="_self">
@section('css')
	{{ Html::style('css/im.css') }} @show @section('script')
	{{ Html::script('js/im.js') }}
@show
    </head>
    <body>
@section('sidebar') @show
        <div class="container" id="container"></div>
@yield('content')
    </body>
</html>