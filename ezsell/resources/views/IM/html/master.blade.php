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
        <div class="container" id="container">
            <br/>
	    	<br/>
	    	<div>EZSell</div>
	    	<div>www.ezsell.com</div>
	    	<div>info@ezsell.com</div>
            <div>(+65) 9772 8266</div>
        </div>
@yield('content')
    </body>
</html>