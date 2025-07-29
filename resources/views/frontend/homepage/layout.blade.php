<!DOCTYPE html>
<html lang="en">
    <head>
        @include('frontend.component.head')
    </head>
    @if(isset($schema))
        {!! $schema !!}
    @endif
    <body>
        @include('frontend.component.header')

        @yield('content')

        @include('frontend.component.footer')
        @include('frontend.component.script')
    </body>
</html>