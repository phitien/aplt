<?php 

$showBanner = true;

?>

<?php $__env->startSection('title', 'EZSell - Home page'); ?>

<?php $__env->startSection('variables'); ?>
@parent
		manager.set('page', 'HomePage');
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>