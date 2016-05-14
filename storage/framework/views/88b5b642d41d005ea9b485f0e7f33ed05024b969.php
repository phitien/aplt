[ 
<?php foreach($roles as $role => $actions): ?>		'<?php echo e($role); ?>' => [
<?php foreach($actions as $action): ?>			'<?php echo e($action); ?>', 
<?php endforeach; ?>
		],
<?php endforeach; ?> 
	]