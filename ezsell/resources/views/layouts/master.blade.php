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
	{{ Html::script('js/browser.min.js', ['type' => 'text/javascript']) }}
	{{ Html::script('js/libraries.js', ['type' => 'text/javascript']) }}
@show
    </head>
    <body>
@section('top')
@if ($isGuest)
	<a href="/login">Login</a>
	<a href="/register">Register</a>
	<a href="/code">Code</a>
@else
	<a href="/logout">Logout</a>
	<a href="/profile">Profile</a>
	<a href="/deactivate">Deactivate</a>
	<script type="text/javascript">
	var user = {!! $user !!};
	</script>
@endif
@show
        <div class="container" id="container">
@yield('content')
        </div>
@section('bottom')
@show
    </body>
</html>