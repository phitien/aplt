<?php $__env->startSection('title'); ?><?php echo e($title); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="content">
    	<div class="title"><?php echo e($title); ?></div>
    	<br/>
    	<br/>
    	<div>Please active your account by clicking <a href="<?php echo e($url); ?>">here</a> and start enjoy shopping.</div>
    	<br/>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('IM.email.html_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>