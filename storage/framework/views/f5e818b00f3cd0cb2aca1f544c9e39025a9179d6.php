<?php

$showBanner = false;
$rightCols = 0;

?>

<?php $__env->startSection('title', 'EZSell - User item list'); ?>

<?php $__env->startSection('variables'); ?>
@parent
		sessionManager.set('page', 'UserItemsPage');
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>