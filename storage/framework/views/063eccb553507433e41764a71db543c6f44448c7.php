<?php
use App\Platform\View\Html\Menu\Menu;
use App\Platform\View\Html\Menu\MenuItem;

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
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<meta name="keywords" content="<?php echo e($keywords); ?>">
<meta name="description" content="<?php echo e($description); ?>">
<title<?php echo e($title); ?></title>
<base href="/" target="_self">
<!-- CSS -->
<?php echo e(Html::style('css/jquery-ui/themes/base/jquery.ui.all.css')); ?> <?php echo e(Html::style('css/jquery-ui/themes/'.$theme.'/jquery-ui.min.css')); ?> <?php echo e(Html::style('css/jquery-ui/themes/'.$theme.'/jquery.ui.theme.css')); ?> <?php echo e(Html::style('css/app.css')); ?> <?php echo $__env->yieldContent('css'); ?>
<!-- JS -->
<?php echo e(Html::script('js/libraries.js', ['type' => 'text/javascript'])); ?>

<?php echo e(Html::script('js/socket.io-1.3.4.js', ['type' => 'text/javascript'])); ?> <?php echo e(Html::script('js/bootstrap.min.js', ['type' => 'text/javascript'])); ?> <?php echo e(Html::script('js/common.js', ['type' => 'text/javascript'])); ?>

<script type="text/javascript">
		//localization
		const localization = <?php echo $localization; ?>;
		//some basic variables
		appManager.showBanner(<?php echo $showBanner; ?>);
		appManager.showLeft(<?php echo $showLeft; ?>);
		appManager.showRight(<?php echo $showRight; ?>);
		//user
		appManager.user('<?php echo $user; ?>');
		appManager.isGuest(<?php echo $isGuest; ?>);
		appManager.socketUri('http://localhost:8890');
		//some extra variables
<?php echo $__env->yieldContent('variables'); ?>
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
<?php echo $__env->yieldContent('scripts'); ?>
</head>
<body>
	<div id='viewport'></div>
</body>
<?php echo e(Html::script('js/app.js', ['type' => 'text/javascript'])); ?>

</html>