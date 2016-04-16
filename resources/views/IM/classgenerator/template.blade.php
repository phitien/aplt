{{ $php }}

namespace {{ $namespace }};
@if (isset($usingclasses)) @foreach ($usingclasses as $class)
use {{ $class }};
@endforeach @endif

class {{ $classname }} {
	/**
	 * Constants
	 */
@if (isset($constants)) @foreach ($constants as $key => $value)
	const {{ $key }} = {{ $value }};
@endforeach @endif
	/**
	 * Private static variables
	 */
@if (isset($private_static_vars)) @foreach ($private_static_vars as $key => $value)
	private static $__{{ $key }} = {{ $value }};
@endforeach @endif
	/**
	 * Protected static variables
	 */
@if (isset($protected_static_vars)) @foreach ($protected_static_vars as $key => $value)
	protected static $_{{ $key }} = {{ $value }};
@endforeach @endif
	/**
	 * Public static variables
	 */
@if (isset($public_static_vars)) @foreach ($public_static_vars as $key => $value)
	public static ${{ $key }} = {{ $value }};
@endforeach @endif
	/**
	 * Private variables
	 */
@if (isset($private_vars)) @foreach ($private_vars as $key => $value)
	private $__{{ $key }} = {{ $value }};
@endforeach @endif
	/**
	 * Protected variables
	 */
@if (isset($protected_vars)) @foreach ($protected_vars as $key => $value)
	protected $_{{ $key }} = {{ $value }};
@endforeach @endif
	/**
	 * Public variables
	 */
@if (isset($public_vars)) @foreach ($public_vars as $key => $value)
	public ${{ $key }} = {{ $value }};
@endforeach @endif
	/**
	 * Others (Functions...)
	 */
@section('functions')
@show
}