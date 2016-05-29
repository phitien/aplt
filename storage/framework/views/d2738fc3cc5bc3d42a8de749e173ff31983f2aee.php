<?php echo e($php); ?>


namespace <?php echo $__env->yieldContent('namespace'); ?>;
 
<?php echo $__env->yieldContent('uses'); ?>

<?php echo $__env->yieldContent('type'); ?><?php echo $__env->yieldContent('name'); ?>{
<?php echo $__env->yieldContent('traits'); ?>
<?php if(isset($constants)): ?> <?php foreach($constants as $key => $value): ?>
	const <?php echo e($key); ?> = <?php echo e($value); ?>;
<?php endforeach; ?> <?php endif; ?>
<?php if(isset($private_static_vars)): ?> <?php foreach($private_static_vars as $key => $value): ?>
	private static $<?php echo e($key); ?> = <?php echo e($value); ?>;
<?php endforeach; ?> <?php endif; ?>
<?php if(isset($protected_static_vars)): ?> <?php foreach($protected_static_vars as $key => $value): ?>
	protected static $<?php echo e($key); ?> = <?php echo e($value); ?>;
<?php endforeach; ?> <?php endif; ?>
<?php if(isset($public_static_vars)): ?> <?php foreach($public_static_vars as $key => $value): ?>
	public static $<?php echo e($key); ?> = <?php echo e($value); ?>;
<?php endforeach; ?> <?php endif; ?>
<?php if(isset($private_vars)): ?> <?php foreach($private_vars as $key => $value): ?>
	private $<?php echo e($key); ?> = <?php echo e($value); ?>;
<?php endforeach; ?> <?php endif; ?>
<?php if(isset($protected_vars)): ?> <?php foreach($protected_vars as $key => $value): ?>
	protected $<?php echo e($key); ?> = <?php echo e($value); ?>;
<?php endforeach; ?> <?php endif; ?>
<?php if(isset($public_vars)): ?> <?php foreach($public_vars as $key => $value): ?>
	public $<?php echo e($key); ?> = <?php echo e($value); ?>;
<?php endforeach; ?> <?php endif; ?>
<?php $__env->startSection('functions'); ?>
<?php echo $__env->yieldSection(); ?>
}