<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8">
    	<meta name="csrf-token" content="{{ csrf_token() }}">
    	<meta name="keywords" content="">
    	<meta name="description" content="">
        <title>@yield('title')</title>
        <base href="/" target="_self">
@section('css')
	{{ Html::style('css/jquery-ui/themes/base/jquery.ui.all.css') }}
@if (isset($theme))
    {{ Html::style('css/jquery-ui/themes/'.$theme.'/jquery-ui.min.css') }}
    {{ Html::style('css/jquery-ui/themes/'.$theme.'/jquery.ui.theme.css') }}
@endif	
	{{ Html::style('css/app.css') }}
	{{ Html::style('css/theme.css') }}
@show
@section('script')
	{{ Html::script('js/browser.min.js', ['type' => 'text/javascript']) }}
	{{ Html::script('js/libraries.js', ['type' => 'text/javascript']) }}
	{{ Html::script('js/common.js', ['type' => 'text/javascript']) }}
	{{ Html::script('js/app.js', ['type' => 'text/javascript']) }}
	{{ Html::script('js/jquery-migrate-1.2.1.min.js', ['type' => 'text/javascript']) }}
	{{ Html::script('js/socket.io-1.3.4.js', ['type' => 'text/javascript']) }}

	<script type="text/javascript">
@if (!$isGuest)
		var user = {!! $user !!};
@endif
		var appMessage = '{{ $appMessage }}';
		var cats = {!! $cats !!};
		var currentLocation = {!! $location ? json_encode($location) : '{}' !!};
	</script>
@show
    </head>
    <body>
@section('top')
		<div class="container-fluid clearfix" id="navigation">
			<div class="container clearfix">
				<div id="leftmenu">
					<ul class="nav">
						<li><a href="/"><span>Home</span></a></li>
						<li id="catmenu"></li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div id="rightmenu">
					{!! $menu !!}
					<div class="menu-toggle" id="form-container"></div>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="container clearfix" id="banner">
			<div class="clearfix"></div>
		</div>
@show
        <div class="container clearfix" id="container">
@yield('content')
			<div class="clearfix"></div>
        </div>
		<div class="container clearfix" id="footer">
			<div id="messages"></div>
			<div id="sendmessages">
				<input type="text" name="message" onkeypress="javascript:if (event.keyCode==13) {$(this).next('input').click();}" />
				<input type="button" value="send" onclick="sendMessage(this)"/>
			</div>
		</div>
@section('bottomscripts')
	<script type="text/javascript">
		var socket = io.connect('http://localhost:8890');
		socket.on('message', function (data) {
			$( "#messages" ).append( "<p>"+data+"</p>" );
		});
	</script>
@show
		<div class="clearfix"></div>
    </body>
</html>