<?php $__env->startSection('title', 'EZSell - Register'); ?>

<?php $__env->startSection('top'); ?>
@parent
	<div>
		Hỏng rồi, không đăng ký được, lý do vì <?php echo e($data['message']); ?>. Thử lại phát đi.
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottomscripts'); ?>
@parent
	<script type="text/javascript" src="js/pages/register.js"></script> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>