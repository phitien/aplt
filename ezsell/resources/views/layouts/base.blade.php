<?php
use App\Ezsell\View\Html\Menu\Menu;
use App\Ezsell\View\Html\Menu\MenuItem;
use App\Ezsell\Helper;

$user = Helper::getUser ();
$isGuest = ( bool ) $user->isGuest ();
$menu = (new Menu ())->setClassName ( 'nav' );
if ($isGuest) {
	$menu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.login' ) )->setAttribute ( 'onClick', 'showLoginForm(this)' ) );
	$menu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.register' ) )->setAttribute ( 'onClick', 'showRegistrationForm(this)' ) );
	$menu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.location' ) )->setAttribute ( 'onClick', 'showLocationForm(this)' ) );
	// $menu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.code' ) )->setHref ( '/code' ) );
} else {
	$menu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.buy' ) )->setClassName ( 'btn-buy' )->setHref ( '/buyitem' ) );
	$menu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.sell' ) )->setClassName ( 'btn-sell' )->setHref ( '/sellitem' ) );
	$moreMenuItem = (new MenuItem ())->setText ( trans ( 'messages.words.more' ) )->setClassName ( 'btn-more' )->setAttribute ( 'onClick', 'expandMenu(this)' );
	$menu->addChild ( $moreMenuItem );
	$moreMenu = (new Menu ())->setClassName ( 'sensitive more-nav' );
	$moreMenu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.password' ) )->setHref ( '/password' ) );
	$moreMenu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.profile' ) )->setHref ( '/profile' ) );
	$moreMenu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.email' ) )->setHref ( '/email' ) );
	$moreMenu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.account' ) )->setHref ( '/account' ) );
	// $moreMenu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.deactivate' ) )->setHref ( '/deactivate' ) );
	// $moreMenu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.location' ) )->setAttribute ( 'onClick', 'showLocationForm(this)' ) );
	$moreMenu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.logout' ) )->setHref ( '/logout' ) );
	$moreMenuItem->addChild ( $moreMenu );
}

$theme = isset ( $theme ) ? $theme : 'south-street';
$showBanner = isset ( $showBanner ) ? $showBanner : false;
$totalCols = 12;
$leftCols = isset ( $leftCols ) ? ( int ) $leftCols : 2;
$rightCols = isset ( $rightCols ) ? ( int ) $rightCols : 2;
$centerCols = $totalCols - $leftCols - $rightCols;
$localization = json_encode ( trans ( 'messages.words' ) );
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="keywords" content="@yield('meta-keywords')">
<meta name="description" content="@yield('meta-description')">
<title>@yield('title')</title>
<base href="/" target="_self">
<!-- CSS -->
{{ Html::style('css/jquery-ui/themes/base/jquery.ui.all.css') }} {{
Html::style('css/jquery-ui/themes/'.$theme.'/jquery-ui.min.css') }} {{
Html::style('css/jquery-ui/themes/'.$theme.'/jquery.ui.theme.css') }} {{
Html::style('css/app.css') }} @yield('css')
<!-- JS -->
{{ Html::script('js/libraries.js', ['type' => 'text/javascript']) }}
{{Html::script('js/socket.io-1.3.4.js', ['type' => 'text/javascript'])
}} {{Html::script('js/bootstrap.min.js', ['type' => 'text/javascript'])
}} {{ Html::script('js/common.js', ['type' => 'text/javascript']) }}
<script type="text/javascript">
		//localization
		const localization = {!! $localization !!};
		//divs ids
		const navigationDivId = 'navigation';
		const containerDivId = 'container';
		const leftDivId = 'left';
		const centerDivId = 'center';
		const rightDivId = 'right';
		const footerDivId = 'footer';
		const formContainerDivId = 'form-container';
		const extraDivId = 'extra';
		const catmenuDivId = 'catmenu';
		const chatbarDivId = 'chatbar';
		//some basic variables
		sessionManager.set('showBanner', {!! $showBanner ? 'true' : 'false' !!});
		sessionManager.set('showLeft', {!! $leftCols ? 'true' : 'false' !!});
		sessionManager.set('showRight', {!! $rightCols ? 'true' : 'false' !!});
		//user
		sessionManager.set('user', '{!! base64_encode ( ( string ) $user) !!}');
		sessionManager.set('isGuest', {!! $isGuest ? 'true' : 'false' !!});
		sessionManager.set('socket_io_uri', 'http://localhost:8890');
		sessionManager.set('clientKey', '');
		sessionManager.set('socket_id', '');
		//some extra variables
@yield('variables')
		//start socket connection
		const socket = io.connect(sessionManager.get('socket_io_uri'));
		socket.on('connect', function () {
			if (sessionManager.isLogged()) {
				sessionManager.set('clientKey', sessionManager.user().id + '+' + location.hostname);
				socket.emit('join', sessionManager.get('clientKey'));
			}
		});
		socket.on('accepted', function (socket_id) {
			sessionManager.set('socket_id', socket_id);
		});
		socket.on('message', function (message) {
			Dispatcher.emit(Dispatcher.Events.RECEIVED_MESSAGE, JSON.parse(message));
		});
		socket.on('notification', function (data) {
			Dispatcher.emit(Dispatcher.Events.UPDATE_NO, data);
		});
		socket.on('disconnect', function () {
			console.log('disconnected');
		});
	</script>

{{ Html::script('js/app.js', ['type' => 'text/javascript']) }}
@yield('scripts')
</head>
<body class="{{ $isGuest ? 'guest' : 'user' }}" id='viewport'>
	<div class="container-fluid row clearfix" id="navigation-replacement">
	</div>
	@if ($showBanner)
	<div class="container-fluid row clearfix" id="banner">@yield('banner')
	</div>
	@endif
	<div class="container-fluid row clearfix" id="container">
		@if ($leftCols)
		<div class="col-xs-12 col-sm-6 col-md-{{ $leftCols }}" id="left">
			@yield('left')</div>
		@endif
		<div class="col-xs-12 col-sm-6 col-md-{{ $centerCols }}" id="center">
			@yield('center')</div>
		@if ($rightCols)
		<div class="col-xs-12 col-sm-6 col-md-{{ $rightCols }}" id="right">
			@yield('right')</div>
		@endif
	</div>
	<div class="container-fluid row clearfix" id="footer"></div>
	@section('navigation')
	<div class="container-fluid row clearfix" id="navigation">
		<div class="container clearfix">
			<div id="leftmenu">
				<ul class="nav">
					<li><a href="/"><span>{{ trans ( 'messages.words.home' ) }}</span></a></li>
					<li id="catmenu"></li>
					<li id="extra"></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div id="rightmenu">
				{!! $menu !!}
				<div class="sensitive" id="form-container"></div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<div class="container-fluid row clearfix" id="chatbar"></div>

	@show @yield('bottomscripts')
	<div class="clearfix"></div>
</body>
</html>