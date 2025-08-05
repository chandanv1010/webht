@extends('mobile.homepage.layout')
@section('content')
    <div id="mobile-container">
        @include('mobile.component.breadcrumb', ['model' => $postCatalogue, 'breadcrumb' => $breadcrumb])
        <div class="post-catalogue-wrapper  design">
            <div class="product-catalogue-wrapper">
                <div class="uk-container uk-container-center">
                    <h1 class="page-heading">{{ $postCatalogue->languages->first()->pivot->name }}</h1>
                </div>
            </div>
            <div class="uk-container uk-container-center" style="padding-top:20px;padding-bottom:20px;">
                <div class="wrapper">
                    <div class="uk-grid uk-grid-medium">
                        @foreach($posts as $keyPost => $post)
                            @php
                                $name = $post->languages->first()->pivot->name;
                                $canonical = write_url($post->languages->first()->pivot->canonical);
                                $image = thumb($post->image, 600, 400);
                                $description = cutnchar(strip_tags($post['description']), 150);
                                $cat = $post->post_catalogues[0]->languages->first()->pivot->name;
                            @endphp
                            <div class="uk-width-medium-1-3 mb20">
                                <div class="news-item">
                                    <a href="{{ $canonical }}" class="image img-cover"><img src="{{ $image }}" alt=""></a>
                                    <div class="info">
                                        <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }} </a></h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="uk-text-center">
                        @include('mobile.component.pagination', ['model' => $posts])
                    </div>    
                </div>
            </div>
        </div>
        @include('mobile.component.news-outstanding')
    </div>
@endsection