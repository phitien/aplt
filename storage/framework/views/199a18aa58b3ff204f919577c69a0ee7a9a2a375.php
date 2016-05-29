<?php $__env->startSection('title', 'EZSell - Activate'); ?>

<?php $__env->startSection('scripts'); ?>
@parent
<?php $__env->stopSection(); ?>

<?php $__env->startSection('left'); ?>
@parent
<?php $__env->stopSection(); ?>

<?php $__env->startSection('center'); ?>
@parent
<?php $__env->stopSection(); ?>

<?php $__env->startSection('right'); ?>
@parent
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>