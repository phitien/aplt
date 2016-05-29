<?php $__env->startSection('title', 'EZSell - Details'); ?>

<?php $__env->startSection('scripts'); ?>
@parent
	<script type="text/javascript">
		var item = <?php echo $item ? $item : null; ?>;
		var cat = <?php echo $item ? $item->cat : null; ?>;
	</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottomscripts'); ?>
@parent
	<script type="text/javascript" src="js/pages/item.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>