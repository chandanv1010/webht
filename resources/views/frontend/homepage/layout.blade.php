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

        {{-- One enquiry popup for the whole site: any [data-lead-open] element opens it,
             so a new CTA never needs its own form. --}}
        @include('frontend.component.lead-popup')

        @include('frontend.component.script')
    </body>
</html>