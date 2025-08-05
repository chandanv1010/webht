@php
    $slideKeyword = 'mobile-slide';
@endphp
@if(count($slides[$slideKeyword]['item']))
    <div class="panel-slide" data-setting="{{ json_encode($slides[$slideKeyword]['setting']) }}">
        <div class="video-item">
            {!! $system['homepage_video_youtube_mobile'] !!}
        </div>
    </div>
@endif
