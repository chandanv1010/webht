@php
    $slideKeyword = App\Enums\SlideEnum::MAIN;
@endphp
@if(count($slides[$slideKeyword]['item']))
<div class="panel-slide page-setup" data-setting="{{ json_encode($slides[$slideKeyword]['setting']) }}">
    <div class="swiper-container">
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-wrapper">
            {{-- @for($i = 1; $i<=2; $i++) --}}
                @include('frontend.component.slide-item.slide-1')
                @include('frontend.component.slide-item.slide-5')
                @include('frontend.component.slide-item.slide-2')
                @include('frontend.component.slide-item.slide-3')
                @include('frontend.component.slide-item.slide-4')
            {{-- @endfor --}}
        </div>
    </div>
</div>
@endif