<?php $__env->startSection('title', 'EZSell - New'); ?>

<?php $__env->startSection('bottomscripts'); ?>
@parent
	<script type="text/javascript" src="js/pages/newitem.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>