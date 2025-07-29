<!DOCTYPE html>
<html lang="en">
    <head>
        @include('mobile.component.head')
    </head>
    <body>
        @include('mobile.component.header')

        @yield('content')

        @include('mobile.component.footer')
        @include('mobile.component.script')
    </body>
</html>