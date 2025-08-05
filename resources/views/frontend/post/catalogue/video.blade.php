@extends('frontend.homepage.layout')
@section('content')
    
    <div class="post-catalogue page-wrapper intro-wrapper">
        @include('frontend.component.breadcrumb', ['model' => $postCatalogue, 'breadcrumb' => $breadcrumb])
        <div class="product-catalogue-wrapper">
            <div class="uk-container uk-container-center">
                <h1 class="page-heading">{{ $postCatalogue->languages->first()->pivot->name }}</h1>
                
            </div>
        </div>
        <div class="post-container">
            <div class="uk-container uk-container-center" style="padding-top:20px;padding-bottom:20px;">
                <div class="wrapper">
                    <div class="uk-grid uk-grid-small">
                        @foreach($posts as $keyPost => $post)
                        @php
                            $name = $post->languages->first()->pivot->name;
                            $canonical = write_url($post->languages->first()->pivot->canonical);
                            $image = thumb($post->image, 344, 230);
                            $description = cutnchar(strip_tags($post['description']), 150);
                            $cat = $post->post_catalogues[0]->languages->first()->pivot->name;
                            $video = $post->video;
                        @endphp
                        <div class="uk-width-small-1-5 mb20">
                            <div class="news-item video-item">
                                <a href="" class="image img-cover">
                                    {!! $video !!}
                                </a>
                                <div class="info">
                                    <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }} </a></h3>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="uk-text-center">
                        @include('frontend.component.pagination', ['model' => $posts])
                    </div>    
                </div>
                <div class="description">
                    {!! $postCatalogue->languages->first()->pivot->description !!}
                </div>
                <div class="mt--80">
                    @include('frontend.component.news')
                </div>
            </div>
        </div>
    </div>
@endsection

