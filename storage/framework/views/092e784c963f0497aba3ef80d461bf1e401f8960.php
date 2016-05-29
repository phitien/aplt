<?php $__env->startSection('title', 'EZSell - Deactivate account'); ?>

<?php $__env->startSection('variables'); ?>
@parent
		sessionManager.set('page', 'DeactivatePage');
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>