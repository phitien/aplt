<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8">
        <title><?php echo $__env->yieldContent('title'); ?></title>
        <base href="/" target="_self">
<?php $__env->startSection('css'); ?>
	<?php echo e(Html::style('css/app.css')); ?>

<?php echo $__env->yieldSection(); ?>
<?php $__env->startSection('script'); ?>
	<?php echo e(Html::script('js/app.js')); ?>

<?php echo $__env->yieldSection(); ?>
    </head>
    <body>
        <div class="container" id="container">
<?php echo $__env->yieldContent('top'); ?>
<?php echo $__env->yieldContent('content'); ?>
<?php echo $__env->yieldContent('bottom'); ?>
        </div>
    </body>
</html>