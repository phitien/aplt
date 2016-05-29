<?php

$showBanner = false;

?>

<?php $__env->startSection('title', 'EZSell - Want to sell something'); ?>

<?php $__env->startSection('variables'); ?>
@parent
		sessionManager.set('page', 'SellItemPage');
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>