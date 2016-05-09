<?php echo e($php); ?>


namespace <?php echo e($namespace); ?>;
<?php if(isset($usingclasses)): ?> <?php foreach($usingclasses as $class): ?>
use <?php echo e($class); ?>;
<?php endforeach; ?> <?php endif; ?>

class <?php echo e($classname); ?> {
	/**
	 * Constants
	 */
<?php if(isset($constants)): ?> <?php foreach($constants as $key => $value): ?>
	const <?php echo e($key); ?> = <?php echo e($value); ?>;
<?php endforeach; ?> <?php endif; ?>
	/**
	 * Private static variables
	 */
<?php if(isset($private_static_vars)): ?> <?php foreach($private_static_vars as $key => $value): ?>
	private static $__<?php echo e($key); ?> = <?php echo e($value); ?>;
<?php endforeach; ?> <?php endif; ?>
	/**
	 * Protected static variables
	 */
<?php if(isset($protected_static_vars)): ?> <?php foreach($protected_static_vars as $key => $value): ?>
	protected static $_<?php echo e($key); ?> = <?php echo e($value); ?>;
<?php endforeach; ?> <?php endif; ?>
	/**
	 * Public static variables
	 */
<?php if(isset($public_static_vars)): ?> <?php foreach($public_static_vars as $key => $value): ?>
	public static $<?php echo e($key); ?> = <?php echo e($value); ?>;
<?php endforeach; ?> <?php endif; ?>
	/**
	 * Private variables
	 */
<?php if(isset($private_vars)): ?> <?php foreach($private_vars as $key => $value): ?>
	private $__<?php echo e($key); ?> = <?php echo e($value); ?>;
<?php endforeach; ?> <?php endif; ?>
	/**
	 * Protected variables
	 */
<?php if(isset($protected_vars)): ?> <?php foreach($protected_vars as $key => $value): ?>
	protected $_<?php echo e($key); ?> = <?php echo e($value); ?>;
<?php endforeach; ?> <?php endif; ?>
	/**
	 * Public variables
	 */
<?php if(isset($public_vars)): ?> <?php foreach($public_vars as $key => $value): ?>
	public $<?php echo e($key); ?> = <?php echo e($value); ?>;
<?php endforeach; ?> <?php endif; ?>
	/**
	 * Others (Functions...)
	 */
<?php $__env->startSection('functions'); ?>
<?php echo $__env->yieldSection(); ?>
}