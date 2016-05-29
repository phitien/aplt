<?php $__env->startSection('title', 'EZSell - Error'); ?>

<?php $__env->startSection('bottomscripts'); ?>
@parent
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
@parent
	<div class="content">
		<div class="title">Lỗi rồi :( !! : <?php echo e($exception->getMessage()); ?></div>
		<div class="trace"><ul>
		<?php foreach($lines as $i => $line): ?>
		    <li><?php echo e($line); ?></li>
		<?php endforeach; ?>
		</ul></div>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>