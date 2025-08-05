<!DOCTYPE html>
<html>

<head>
    @include('backend.dashboard.component.head')

</head>

    <body>
        <div id="wrapper">
            @include('seller.dashboard.component.sidebar')

            <div id="page-wrapper" class="gray-bg">
                @include('seller.dashboard.component.nav')
                @include($template)
                @include('seller.dashboard.component.footer')
            </div>
        </div>
        @include('seller.dashboard.component.script')
    </body>
</html>
