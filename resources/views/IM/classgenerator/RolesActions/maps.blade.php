[ 
@foreach ($roles as $role => $actions)		'{{ $role }}' => [
@foreach ($actions as $action)			'{{ $action }}', 
@endforeach
		],
@endforeach 
	]