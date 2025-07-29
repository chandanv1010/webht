@extends('mobile.homepage.layout')
@section('content')
    <div id="mobile-container">
        <div class="post-catalogue-wrapper pn-video">
            <div class="uk-container uk-container-center">
                {{-- @if(isset($widgets['mobile-video']))
                    @foreach ($widgets['mobile-video']->object as $key => $item)
                        @php
                            $cat_name = $item->languages->first()->pivot->name;
                        @endphp
                        <div class="list-video">
                            <div class="panel-head">
                                <h3 class="heading-2">
                                    <span>{{  $cat_name   }}</span>
                                </h3>
                            </div>
                            <div class="panel-body">
                                @foreach ($item->posts as $k => $post)
                                    <div class="video-item">
                                        <a href="" class="image">
                                           {!! $post->video !!}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif --}}
            </div>
        </div>
        {{-- @include('mobile.component.news-outstanding') --}}
    </div>
@endsection