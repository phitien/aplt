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
@show
@section('script')
	{{ Html::script('js/browser.min.js', ['type' => 'text/javascript']) }}
	{{ Html::script('js/libraries.js', ['type' => 'text/javascript']) }}
	{{ Html::script('js/app.js', ['type' => 'text/javascript']) }}
	<script type="text/javascript">
@if (!$isGuest)
		var user = {!! $user !!};
@endif
		var appMessage = '{{ $appMessage }}';
		var cats = {!! $cats !!};
	</script>
@show
    </head>
    <body>
@section('top')
		<div class="container clearfix" id="navigation">
			<div id="leftmenu">
				<ul>
					<li><a href="/"><span>Home</span></a></li>
					<li id="catmenu"></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div class="" id="rightmenu">
				{!! $menu !!}
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="container clearfix" id="banner">
			<div class="clearfix"></div>
		</div>
@show
        <div class="container clearfix" id="container">
@yield('content')
			<div class="clearfix"></div>
        </div>
@section('bottomscripts')
@show
		<div class="clearfix"></div>
    </body>
</html>