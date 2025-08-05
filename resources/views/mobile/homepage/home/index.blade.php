@extends('mobile.homepage.layout')
@section('content')
    <div id="mobile-container">
        @include('mobile.component.slide')
        @if(isset($widgets['intro']))
            <div class="panel-mobile-intro">
                <a href="{{ write_url('ve-chung-toi') }}">
                    <h2 class="heading-1"><span>{{ $widgets['intro']->name }}</span></h2>
                    <div class="description">
                        {!! $widgets['intro']->description[1] !!}
                    </div>
                </a>
            </div>
        @endif
        
        <div class="product-container">
            @if(isset($widgets['products']))
                @foreach($widgets['products']->object as $cat)
                    @php
                        $nameC = $cat->languages->name;
                        $canonicalC = write_url($cat->languages->canonical)
                    @endphp
                <div class="panel-product">
                    <div class="uk-container uk-container-center">
                        <div class="panel-head uk-flex uk-flex-middle uk-flex-space-between">
                            <h2 class="heading-3"><a href="{{ $canonicalC }}" title="{{  $nameC }}">{{  $nameC }}</a></h2>
                            <a href="{{ $canonicalC }}" class="readmore button-style">Xem thêm</a>
                        </div>
                        @if($cat->products)
                            <div class="panel-body">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach($cat->products as $keyProduct => $product)
                                            <div class="swiper-slide">
                                                @include('frontend/component/product-item', ['product' => $product])
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        @if(isset($widgets['services-1']))
            <div class="mobile-service-container">
                @foreach($widgets['services-1']->object as $key => $val)
                @php
                    $nameC = $val->languages->name;
                    $canonicalC = write_url($val->languages->canonical);
                    $descriptionC = $val->languages->description;
                @endphp
                <div class="panel-service-1">
                    <div class="uk-container uk-container-center">
                        <div class="panel-head">
                            <div class="top-heading">{{ $widgets['services-1']->name }}</div>
                            <h2 class="heading-5"><span>{{ $nameC }}</span></h2>
                            <div class="description">
                                {!! $descriptionC  !!}
                            </div>
                            <a class="readmore button-style" href="{{ $canonicalC }}">Xem thêm</a>
                        </div>
                        @if(isset($val->posts) && count($val->posts))
                            <div class="panel-body">
                                <div class="swiper-container">
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-wrapper">
                                        @foreach($val->posts as $keyPost => $post )
                                            @php
                                                $name = $post->languages[0]->name;
                                                $canonical = write_url($post->languages[0]->canonical);
                                                $image = thumb($post->image, 600, 400)
                                            @endphp
                                            <div class="swiper-slide">
                                                <div class="service-item">
                                                    <a href="{{ $canonical }}" class="image img-cover"><img src="{{ $image }}" alt="{{ $name }}"></a>
                                                    <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
        @if(isset($widgets['video']))
            @foreach($widgets['video']->object as $key => $val)
                @php
                    $nameC = $val->languages->name;
                    $canonicalC = write_url($val->languages->canonical);
                @endphp
                <div class="panel-video">
                    <div class="uk-container uk-container-center">
                        <div class="panel-head">
                            <h2 class="heading-6">
                                <span>{{ $widgets['video']->name }}</span>
                                <span class="line"></span>
                            </h2>
                        </div>
                        @if($val->posts)
                            <div class="panel-body">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach($val->posts as $keyPost => $post)
                                            @php
                                                if($keyPost > 4) break;
                                                $name = $post->languages[0]->name;
                                                $canonical = write_url($post->languages[0]->canonical);
                                                $video = $post->video;
                                            @endphp
                                            <div class="swiper-slide">
                                                <div class="video-item">
                                                    <a href="{{ $canonical }}" class="image img-cover">
                                                        {!! $video !!}
                                                    </a>
                                                    <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
        @if(isset($widgets['projects-feature']))
            <div class="uk-container uk-container-center">
                <div class="post-featured project-featured index">
                    <h2 class="heading-6">
                        <span>{{ $widgets['projects-feature']->name }}</    span>
                    </h2>
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach($widgets['projects-feature']->object as $key => $val)
                                @php
                                    $name = $val->languages->name;
                                    $canonical = write_url($val->languages->canonical);
                                    $createdAt = $val->created_at;
                                    $image = thumb($val->image, 600, 400);
                                @endphp
                                <div class="swiper-slide">
                                    <div class="post-feature-item">
                                        <a href="{{ $canonical }}" class="image img-cover"><img src="{{ $image }}" alt="{{ $name }}"></a>
                                        <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(isset($widgets['news']))
            <div class="panel-news fix index">
                <div class="uk-container uk-container-center">
                    <div class="panel-head uk-text-center">
                        <h2 class="heading-6"><span>{{ $widgets['news']->name }}</span></h2>
                    </div>
                    <div class="panel-body">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach($widgets['news']->object as $key => $val)
                                    @php
                                        if($keyPost > 2) break;
                                        $name = $post->languages->name;
                                        $canonical = write_url($post->languages->canonical);
                                        $image = thumb($post->image, 600, 400);
                                        $description = cutnchar(strip_tags($post['description']), 150);
                                    @endphp
                                    <div class="swiper-slide">
                                        <div class="news-item">
                                            <a href="{{ $canonical }}" class="image img-cover"><img src="{{ $image }}" alt=""></a>
                                            <div class="info">
                                                <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }} </a></h3>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection