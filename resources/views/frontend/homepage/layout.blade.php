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

        {{-- The panel the header's search icon opens. --}}
        @include('frontend.component.search-panel')

        {{-- Pulsing placeholders for images that arrive after paint. --}}
        @include('frontend.component.media-skeleton')

        {{-- Self-hosted Lottie, with the inline SVG as its fallback. --}}
        @include('frontend.component.lottie')

        @include('frontend.component.script')
    </body>
</html>