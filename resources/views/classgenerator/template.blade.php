{{ $php }}

namespace @yield('namespace');
 
@yield('uses')

@yield('type')@yield('name'){
@yield('traits')
@if (isset($constants)) @foreach ($constants as $key => $value)
	const {{ $key }} = {{ $value }};
@endforeach @endif
@if (isset($private_static_vars)) @foreach ($private_static_vars as $key => $value)
	private static ${{ $key }} = {{ $value }};
@endforeach @endif
@if (isset($protected_static_vars)) @foreach ($protected_static_vars as $key => $value)
	protected static ${{ $key }} = {{ $value }};
@endforeach @endif
@if (isset($public_static_vars)) @foreach ($public_static_vars as $key => $value)
	public static ${{ $key }} = {{ $value }};
@endforeach @endif
@if (isset($private_vars)) @foreach ($private_vars as $key => $value)
	private ${{ $key }} = {{ $value }};
@endforeach @endif
@if (isset($protected_vars)) @foreach ($protected_vars as $key => $value)
	protected ${{ $key }} = {{ $value }};
@endforeach @endif
@if (isset($public_vars)) @foreach ($public_vars as $key => $value)
	public ${{ $key }} = {{ $value }};
@endforeach @endif
@section('functions')
@show
}