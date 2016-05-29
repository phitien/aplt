<?php $__env->startSection('title', 'EZSell - Details'); ?>

<?php $__env->startSection('scripts'); ?>
@parent
	<script type="text/javascript">
		var cat = <?php echo $cat; ?>;
		var items = <?php echo $items; ?>;
	</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottomscripts'); ?>
@parent
	<script type="text/javascript" src="js/pages/items.js"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>