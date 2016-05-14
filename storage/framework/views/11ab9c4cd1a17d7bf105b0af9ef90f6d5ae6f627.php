<?php $__env->startSection('namespace'); ?>App\IM\Config <?php $__env->stopSection(); ?>

<?php $__env->startSection('uses'); ?>
use App\IM\Config\RolesActionsTrait;
<?php $__env->stopSection(); ?>

<?php $__env->startSection('name'); ?>RolesActions <?php $__env->stopSection(); ?>

<?php $__env->startSection('traits'); ?>
	/**
	 * TRAITS
	 */
	use RolesActionsTrait;
<?php $__env->stopSection(); ?>

<?php $__env->startSection('functions'); ?>
	/**
	 *
	 * @param    string $role        	
	 * @return    array
	 */
	public static function getActions($role) {
		return isset ( static::$__maps [$role] ) ? static::$__maps [$role] : [ ];
	}
	/**
	 *
	 * @param    string $role        	
	 * @return    string
	 */
	public static function getStringActions($role) {
		return implode ( '|', static::getActions ( $role ) );
	}
	/**
	 *
	 * @param    string $role        	
	 * @param    string $action        	
	 * @return    bool
	 */
	public static function hasAction($role, $action) {
		return in_array ( $action, static::getActions ( $role ) );
	}
<?php $__env->stopSection(); ?>
<?php echo $__env->make('classgenerator.class', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>