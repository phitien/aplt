<?php $__env->startSection('title', 'EZSell - Login'); ?>

<?php $__env->startSection('variables'); ?>
@parent
		sessionManager.set('page', 'LoginPage');
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>