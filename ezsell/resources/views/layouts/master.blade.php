<?php
use App\Ezsell\View\Html\Menu\Menu;
use App\Ezsell\View\Html\Menu\MenuItem;
use App\Ezsell\Models\Cat;
use App\Ezsell\Helper;
use App\Ezsell\Config;

$usecode = Config::USE_CODE;
$user = Helper::getUser ();
$isGuest = ( bool ) $user->isGuest ();
$cats = Cat::getHierarchy ();
$location = Helper::getLocation ();
$menu = (new Menu ())->setClassName ( 'nav' );
if ($isGuest) {
	$menu->addChild ( (new MenuItem ())->setText ( 'Login' )->setAttribute ( 'onClick', 'showLoginForm(this)' ) );
	$menu->addChild ( (new MenuItem ())->setText ( 'Register' )->setAttribute ( 'onClick', 'showRegistrationForm(this)' ) );
	$menu->addChild ( (new MenuItem ())->setText ( 'Location' )->setAttribute ( 'onClick', 'showLocationForm(this)' ) );
	// $menu->addChild ( (new MenuItem ())->setText ( 'Code' )->setHref ( '/code' ) );
} else {
	$menu->addChild ( (new MenuItem ())->setText ( 'Buy' )->setClassName ( 'btn-buy' )->setHref ( '/buyitem' ) );
	$menu->addChild ( (new MenuItem ())->setText ( 'Sell' )->setClassName ( 'btn-sell' )->setHref ( '/sellitem' ) );
	$moreMenuItem = (new MenuItem ())->setText ( 'More' )->setClassName ( 'btn-more' )->setAttribute ( 'onClick', 'expandMenu(this)' );
	$menu->addChild ( $moreMenuItem );
	$moreMenu = (new Menu ())->setClassName ( 'sensitive more-nav' );
	$moreMenu->addChild ( (new MenuItem ())->setText ( 'Password' )->setHref ( '/password' ) );
	$moreMenu->addChild ( (new MenuItem ())->setText ( 'Profile' )->setHref ( '/profile' ) );
	$moreMenu->addChild ( (new MenuItem ())->setText ( 'Email' )->setHref ( '/email' ) );
	$moreMenu->addChild ( (new MenuItem ())->setText ( 'Account' )->setHref ( '/account' ) );
	$moreMenu->addChild ( (new MenuItem ())->setText ( 'Deactivate' )->setHref ( '/deactivate' ) );
	$moreMenu->addChild ( (new MenuItem ())->setText ( 'Location' )->setAttribute ( 'onClick', 'showLocationForm(this)' ) );
	$moreMenu->addChild ( (new MenuItem ())->setText ( 'Logout' )->setHref ( '/logout' ) );
	$moreMenuItem->addChild ( $moreMenu );
}

$appMessage = isset ( $appMessage ) ? $appMessage : '';
$theme = isset ( $theme ) ? $theme : 'south-street';

$showBanner = isset ( $showBanner ) ? $showBanner : false;

$totalCols = 12;
$leftCols = isset ( $leftCols ) ? (int) $leftCols : 2;
$rightCols = isset ( $rightCols ) ? (int) $rightCols : 2;
$centerCols = $totalCols - $leftCols - $rightCols;

?><!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    	<meta name="csrf-token" content="{{ csrf_token() }}">
    	<meta name="keywords" content="@yield('meta-keywords')">
    	<meta name="description" content="@yield('meta-description')">
        <title>@yield('title')</title>
        <base href="/" target="_self">
	{{ Html::style('css/jquery-ui/themes/base/jquery.ui.all.css') }}
@if (isset($theme))
    {{ Html::style('css/jquery-ui/themes/'.$theme.'/jquery-ui.min.css') }}
    {{ Html::style('css/jquery-ui/themes/'.$theme.'/jquery.ui.theme.css') }}
@endif	
	{{ Html::style('css/app.css') }}
	{{ Html::style('css/theme.css') }}
@yield('css')
	{{ Html::script('js/libraries.js', ['type' => 'text/javascript']) }}
	{{ Html::script('js/bootstrap.min.js', ['type' => 'text/javascript']) }}
	{{ Html::script('js/jquery-migrate-1.2.1.min.js', ['type' => 'text/javascript']) }}
	{{ Html::script('js/jquery-dateFormat.min.js', ['type' => 'text/javascript']) }}
	{{ Html::script('js/socket.io-1.3.4.js', ['type' => 'text/javascript']) }}
	<script type="text/javascript">
		var navigationDivId = 'navigation';
		var containerDivId = 'container';
		var leftDivId = 'left';
		var centerDivId = 'center';
		var rightDivId = 'right';
		var footerDivId = 'footer';
		var formContainerDivId = 'form-container';
		var user = {!! $user !!};
		var appMessage = '{{ $appMessage }}';
		var cats = {!! $cats !!};
		var currentLocation = {!! $location ? json_encode($location) : '{}' !!};
		var usecode = {!! $usecode ? 'true' : 'false' !!};
		var showBanner = {!! $showBanner ? 'true' : 'false' !!};
		var showLeft = {!! $leftCols ? 'true' : 'false' !!};
		var showRight = {!! $rightCols ? 'true' : 'false' !!};
		var socket = io.connect('http://localhost:8890');
		socket.on('message', function (data) {
			$( "#messages" ).append( "<p>"+data+"</p>" );
		});
	</script>
	{{ Html::script('js/common.js', ['type' => 'text/javascript']) }}
	{{ Html::script('js/app.js', ['type' => 'text/javascript']) }}
@yield('scripts')
    </head>
    <body>
		<div class="container-fluid row clearfix" id="navigation-replacement">
		</div>
@if ($showBanner)
		<div class="container-fluid row clearfix" id="banner">
@yield('banner')
		</div>
@endif
        <div class="container-fluid row clearfix" id="container">
@if ($leftCols) 
			<div class="col-xs-12 col-sm-6 col-md-{{ $leftCols }}" id="left">
@yield('left') 
			</div>
@endif
			<div class="col-xs-12 col-sm-6 col-md-{{ $centerCols }}" id="center">
@yield('center')
			</div>
@if ($rightCols) 
			<div class="col-xs-12 col-sm-6 col-md-{{ $rightCols }}" id="right">
@yield('right') 
			</div>
@endif
        </div>
		<div class="container-fluid row clearfix" id="footer">
			<div id="messages"></div>
			<div id="sendmessages">
				<input type="text" name="message" onkeypress="javascript:if (event.keyCode==13) {$(this).next('input').click();}" />
				<input type="button" value="send" onclick="sendMessage(this)"/>
			</div>
		</div>
@section('navigation')
		<div class="container-fluid row clearfix" id="navigation">
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
					<div class="sensitive" id="form-container"></div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
@show
@yield('bottomscripts')
		<div class="clearfix"></div>
    </body>
</html>