<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <base href="/" target="_self">
        @yield('css')
        @yield('script')
    </head>
    <body>
        @section('sidebar')
            This is the master sidebar.
        @show
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
