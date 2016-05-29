<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<meta name="keywords" content="<?php echo e($configurations['keywords']); ?>">
<meta name="description" content="<?php echo e($configurations['description']); ?>">
<title<?php echo e($configurations['title']); ?></title>
<base href="/" target="_self">
<!-- CSS -->
<?php echo e(Html::style('css/jquery-ui/themes/base/jquery.ui.all.css')); ?> <?php echo e(Html::style('css/jquery-ui/themes/' . $configurations['theme'] .
'/jquery-ui.min.css')); ?> <?php echo e(Html::style('css/jquery-ui/themes/' .
$configurations['theme'] . '/jquery.ui.theme.css')); ?><?php echo e(Html::style('wait-me/waitMe.min.css')); ?> <?php echo e(Html::style('jemotion/css/style.css')); ?> <?php echo e(Html::style('css/app.css')); ?> <?php echo $__env->yieldContent('css'); ?>
<!-- JS -->
<?php echo e(Html::script('js/libraries.js', ['type' => 'text/javascript'])); ?>

<?php echo e(Html::script('js/socket.io-1.3.4.js', ['type' => 'text/javascript'])); ?> <?php echo e(Html::script('js/bootstrap.min.js', ['type' => 'text/javascript'])); ?> <?php echo e(Html::script('jemotion/jemotion.js', ['type' => 'text/javascript'])); ?> <?php echo e(Html::script('wait-me/waitMe.min.js', ['type' =>
'text/javascript'])); ?> <?php echo e(Html::script('js/common.js', ['type' =>
'text/javascript'])); ?>

<script type="text/javascript">
		//configurations
		var configurations = <?php echo json_encode($configurations); ?>;
	</script>
<?php echo $__env->yieldContent('scripts'); ?>
</head>
<body>
	<div id='viewport'></div>
</body>
<?php echo e(Html::script('js/app.js', ['type' => 'text/javascript'])); ?>

</html>