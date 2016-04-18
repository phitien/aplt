<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <base href="/" target="_self">
        @yield('css')
        @yield('script')
    </head>
    <body>
        @section('sidebar')
        @show
        <div class="container">
            @yield('content')
            
            <br/>
	    	<br/>
	    	<div>EZSell</div>
	    	<div>www.ezsell.com</div>
	    	<div>info@ezsell.com</div>
            <div>(+65) 9772 8266</div>
        </div>
    </body>
</html>