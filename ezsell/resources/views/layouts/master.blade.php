<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8">
        <title>@yield('title')</title>
        <base href="/" target="_self">
        @section('css')
        @show
        @section('script')
        @show
    </head>
    <body>
        @section('sidebar')
        @show
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>

@section('css')
	{{ Html::style('css/im.css') }}
	{{ Html::style('js/react-15.0.1/examples/shared/css/base.css') }}
@endsection

@section('script')
	{{ Html::script('js/react-15.0.1/build/react.js') }}
	{{ Html::script('js/react-15.0.1/build/react-dom.js') }}
	{{ Html::script('js/browser.min.js') }}
@endsection

