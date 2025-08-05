@extends('mobile.homepage.layout')
@section('content')
    <div id="mobile-container">
        @include('mobile.component.breadcrumb', ['model' => $productCatalogue, 'breadcrumb' => $breadcrumb])
        <div class="product-catalogue-wrapper panel-product">
            <div class="uk-container uk-container-center">

                @if(!is_null($menu['main-menu_array']))
                    @foreach($menu['main-menu_array'] as $key => $val)
                        @if($key !== 2 ) @continue @endif
                        {{-- @dd($val)
                        @dd($val['item']->languages->first()->pivot->name) --}}
                        <ul class="children">
                            @foreach($val['children'] as $key2 => $item)
                                @php
                                    $name = $item['item']->languages->first()->pivot->name;
                                    $canonical = write_url($item['item']->languages->first()->pivot->canonical);
                                @endphp
                            <li>
                                <a href="{{ $canonical }}" title="{{ $name }}" class="{{ $item['item']->languages->first()->pivot->canonical == $productCatalogue->canonical ? 'active' : '' }}">{{ $name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    @endforeach
                @endif

                <h1 class="page-heading">{{ $productCatalogue->languages->first()->pivot->name }}</h1>

                <div class="panel-body">
                    <div class="wrapper ">
                        @if(!is_null($products))
                            <div class="product-list">
                                <div class="uk-grid uk-grid-medium">
                                    @foreach($products as $product)
                                        <div class="uk-width-1-1 mb20">
                                            @include('mobile.component.product-item', ['product'  => $product])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="uk-flex uk-flex-center">
                                @include('mobile.component.pagination', ['model' => $products])
                            </div>
                        @endif
                    </div>
                </div>
                <div class="description mb30">
                    {!! $productCatalogue->languages->first()->pivot->description !!}
                </div>
            </div>
        </div>
        @if(isset($widgets['design_construction_interior']))
            @foreach($widgets['design_construction_interior']->object as $key => $val)
                <div class="panel-design">
                    <div class="uk-container uk-container-center">
                        <h2 class="heading-6">
                            <span>
                                {{ $val->languages->name }}
                            </span>
                        </h2>
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach($val->posts as $k => $item)
                                    @php
                                        $name = $item->languages[0]->name;
                                        $canonical = write_url($item->languages[0]->canonical);
                                        $createdAt = $item->created_at;
                                        $image = thumb($item->image, 600, 400);
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
                                    @foreach($widgets['news']->object as $key => $post)
                                        @php
                                            $name = $post->languages->name;
                                            $canonical = write_url($post->languages->canonical);
                                            $image = thumb($post->image, 600, 400);
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