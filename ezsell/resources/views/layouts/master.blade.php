<?php
// use App\Platform\View\Html\Menu\Menu;
// use App\Platform\View\Html\Menu\MenuItem;

// $menu = (new Menu ())->setClassName ( 'nav' );
// if ($isGuest) {
// 	$menu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.login' ) )->setAttribute ( 'onClick', 'showLoginForm(this)' ) );
// 	$menu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.register' ) )->setAttribute ( 'onClick', 'showRegistrationForm(this)' ) );
// 	$menu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.location' ) )->setAttribute ( 'onClick', 'showLocationForm(this)' ) );
// 	// $menu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.code' ) )->setHref ( '/code' ) );
// } else {
// 	$menu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.buy' ) )->setClassName ( 'btn-buy' )->setHref ( '/buyitem' ) );
// 	$menu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.sell' ) )->setClassName ( 'btn-sell' )->setHref ( '/sellitem' ) );
// 	$moreMenuItem = (new MenuItem ())->setText ( trans ( 'messages.words.more' ) )->setClassName ( 'btn-more' )->setAttribute ( 'onClick', 'expandMenu(this)' );
// 	$menu->addChild ( $moreMenuItem );
// 	$moreMenu = (new Menu ())->setClassName ( 'sensitive more-nav' );
// 	$moreMenu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.password' ) )->setHref ( '/password' ) );
// 	$moreMenu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.profile' ) )->setHref ( '/profile' ) );
// 	$moreMenu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.email' ) )->setHref ( '/email' ) );
// 	$moreMenu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.account' ) )->setHref ( '/account' ) );
// 	// $moreMenu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.deactivate' ) )->setHref ( '/deactivate' ) );
// 	// $moreMenu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.location' ) )->setAttribute ( 'onClick', 'showLocationForm(this)' ) );
// 	$moreMenu->addChild ( (new MenuItem ())->setText ( trans ( 'messages.words.logout' ) )->setHref ( '/logout' ) );
// 	$moreMenuItem->addChild ( $moreMenu );
// }
?>
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
Html::style('css/jquery-ui/themes/' . $configurations['theme'] . '/jquery-ui.min.css') }} {{
Html::style('css/jquery-ui/themes/' . $configurations['theme'] . '/jquery.ui.theme.css') }} {{
Html::style('css/app.css') }} @yield('css')
<!-- JS -->
{{ Html::script('js/libraries.js', ['type' => 'text/javascript']) }}
{{Html::script('js/socket.io-1.3.4.js', ['type' => 'text/javascript'])
}} {{Html::script('js/bootstrap.min.js', ['type' => 'text/javascript'])
}} {{ Html::script('js/common.js', ['type' => 'text/javascript']) }}
<script type="text/javascript">
		//localization
		var configurations = {!! json_encode($configurations) !!};
		appManager.configurations(configurations);
		//some basic variables
@yield('variables')
		//start socket connection
		const socket = io.connect(appManager.socketUri());
		socket.on('connect', function () {
			if (appManager.isLogged()) {
				socket.emit('join', appManager.clientKey());
			}
		});
		socket.on('accepted', function (socket_id) {
			appManager.socketId(socket_id);
		});
		socket.on('message', function (data) {
			appStore.addMessage(JSON.parse(data));
		});
		socket.on('notification', function (data) {
			appStore.addNotification(JSON.parse(data));
		});
		socket.on('disconnect', function () {
			console.log('disconnected');
		});
	</script>
@yield('scripts')
</head>
<body>
	<div id='viewport'></div>
</body>
{{ Html::script('js/app.js', ['type' => 'text/javascript']) }}
</html>