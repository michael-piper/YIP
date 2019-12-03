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
        <script>
                window.API_URL=location.protocol+'//'+location.host+'/api/';
                $.ajaxSetup({
                headers: {
                    'X-Csrf-Token': $("meta[name='csrf-token']").attr('content')||"",
                    'X-Api-Token' : $("meta[name='X-Api-Token']").attr("content")||''
                }
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
        @yield('js')

        @stack('scripts')
        <script>
                new WOW().init();
        </script>
    </body>
</html>
