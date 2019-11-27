<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8">
          <meta name="csrf-token" content="{{csrf_token()}}">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        @includeIf("main.header")
        @yield('style')
    </head>
    <body>
        @includeIf("main.navbar")
        @yield('content')
        @includeIf("main.footer")

        @yield('js')
    </body>
</html>
