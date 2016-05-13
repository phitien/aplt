<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    	<meta name="csrf-token" content="{{ csrf_token() }}">
    	<meta name="keywords" content="">
    	<meta name="description" content="">
        <title>@yield('title')</title>
        <base href="/" target="_self">
        
@yield('css')

@yield('scripts')

    </head>
    <body>
		<div class="container-fluid clearfix" id="navigation-replacement"></div>
@yield('banner')
        <div class="container clearfix" id="container">
        	<div class="row">
	        	<div class="col-xs-6 col-md-3" id="left">
	        	</div>
				<div class="col-xs-12 col-sm-6 col-md-9" id="content">
@yield('content')
	        	</div>
        	</div>
			<div class="clearfix"></div>
        </div>
		<div class="container clearfix" id="footer">
			<div class="clearfix"></div>
		</div>
		
@section('top')
		<div class="container-fluid clearfix" id="navigation">
			<div class="container clearfix">
				<div id="leftmenu">
					<div class="clearfix"></div>
				</div>
				<div id="rightmenu">
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
@show

@section('bottomscripts')
@show
		<div class="clearfix"></div>
    </body>
</html>