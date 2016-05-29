<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="keywords" content="{{ $configurations['keywords'] }}">
<meta name="description" content="{{ $configurations['description'] }}">
<title{{ $configurations['title'] }}</title>
<base href="/" target="_self">
<!-- CSS -->
{{ Html::style('css/jquery-ui/themes/base/jquery.ui.all.css') }} {{
Html::style('css/jquery-ui/themes/' . $configurations['theme'] .
'/jquery-ui.min.css') }} {{ Html::style('css/jquery-ui/themes/' .
$configurations['theme'] . '/jquery.ui.theme.css') }}{{
Html::style('wait-me/waitMe.min.css') }} {{
Html::style('jemotion/css/style.css') }} {{ Html::style('css/app.css')
}} @yield('css')
<!-- JS -->
{{ Html::script('js/libraries.js', ['type' => 'text/javascript']) }}
{{Html::script('js/socket.io-1.3.4.js', ['type' => 'text/javascript'])
}} {{Html::script('js/bootstrap.min.js', ['type' => 'text/javascript'])
}} {{Html::script('jemotion/jemotion.js', ['type' => 'text/javascript'])
}} {{ Html::script('wait-me/waitMe.min.js', ['type' =>
'text/javascript']) }} {{ Html::script('js/common.js', ['type' =>
'text/javascript']) }}
<script type="text/javascript">
		//configurations
		var configurations = {!! json_encode($configurations) !!};
	</script>
@yield('scripts')
</head>
<body>
	<div id='viewport'></div>
</body>
{{ Html::script('js/app.js', ['type' => 'text/javascript']) }}
</html>