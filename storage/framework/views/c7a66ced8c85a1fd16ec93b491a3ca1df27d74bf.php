<?php

$showBanner = false;
// $leftCols = 0;
// $rightCols = 0;

?>

<?php $__env->startSection('title', 'EZSell - Details'); ?>

<?php $__env->startSection('variables'); ?>
@parent
		sessionManager.set('page', 'ItemDetailsPage');
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>