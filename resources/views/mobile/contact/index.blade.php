@extends('mobile.homepage.layout')
@section('content')
    <div class="contact-page">
        <div class="intro">
            <div class="uk-container uk-container-center">
                <p>
                    {{ $system['contact_intro'] }}
                </p>
            </div>
        </div>
        @if(isset($widgets['showroom-system']))
            @foreach($widgets['showroom-system']->object as $key => $val)
                @php
                    $cat_title = $val->languages->first()->pivot->name;
                @endphp
                <div class="showroom-system">
                    <div class="uk-container uk-container-center">
                        <div class="panel-head">
                            <h2 class="heading-1">
                                <span>{{ $cat_title }}</span>
                            </h2>
                        </div>
                        @if(isset($val->posts) && count($val->posts))
                            <div class="panel-body">
                                <div class="uk-grid uk-grid-small">
                                    @foreach($val->posts as $k => $post)
                                        <div class="uk-width-small-1-2">
                                            @php
                                                $image = $post->image;
                                                $title = $post->languages->first()->pivot->name;
                                                $description = $post->languages->first()->pivot->description;
                                                $canonical = write_url($post->languages->first()->pivot->canonical);
                                            @endphp
                                            <div class="showroom-item">
                                                <a href="{{ $canonical }}" class="image-content image img-cover">
                                                    <img src="{{ $image }}" alt="">
                                                </a>
                                                <div class="text-content">
                                                    <h3 class="heading-2">
                                                        <span>{{ $title }}</span>
                                                    </h3>
                                                    <div class="description">
                                                        {!! $description !!}
                                                    </div>
                                                    <div class="toolbox">
                                                        <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                            <div class="uk-flex uk-flex-middle">
                                                                <a href="">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 320 512">
                                                                        <path d="M80 299.3V512h116V299.3h86.5l18-97.8H196v-34.6c0-51.7 20.3-71.5 72.7-71.5 16.3 0 29.4.4 37 1.2V7.9C291.4 4 256.4 0 236.2 0 129.3 0 80 50.5 80 159.4v42.1H14v97.8z"></path>
                                                                    </svg>
                                                                </a>
                                                                <a href="">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 512 512"><path d="M64 112c-8.8 0-16 7.2-16 16v22.1l172.5 141.6c20.7 17 50.4 17 71.1 0L464 150.1V128c0-8.8-7.2-16-16-16zM48 212.2V384c0 8.8 7.2 16 16 16h384c8.8 0 16-7.2 16-16V212.2L322 328.8c-38.4 31.5-93.7 31.5-132 0zM0 128c0-35.3 28.7-64 64-64h384c35.3 0 64 28.7 64 64v256c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64z"></path></svg>
                                                                </a>
                                                                <a href="">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 512 512"><path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64c0 247.4 200.6 448 448 448 18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368c-70.4-33.3-127.4-90.3-160.7-160.7l49.3-40.3c13.7-11.2 18.4-30 11.6-46.3l-40-96z"></path><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 512 512"><path d="M64 112c-8.8 0-16 7.2-16 16v22.1l172.5 141.6c20.7 17 50.4 17 71.1 0L464 150.1V128c0-8.8-7.2-16-16-16zM48 212.2V384c0 8.8 7.2 16 16 16h384c8.8 0 16-7.2 16-16V212.2L322 328.8c-38.4 31.5-93.7 31.5-132 0zM0 128c0-35.3 28.7-64 64-64h384c35.3 0 64 28.7 64 64v256c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64z"></path></svg></svg>
                                                                </a>
                                                                <a href="">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 576 512"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305m-317.51 213.508V175.185l142.739 81.205z"></path></svg>
                                                                </a>
                                                            </div>
                                                            <button class="btn-detail">
                                                                <a href="{{ $canonical }}">Xem chi tiết</a>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
        @if(isset($widgets['news-outstanding']))
            <div class="news-outstanding">
                <div class="uk-container uk-container-center">
                    <div class="uk-grid uk-grid-medium">
                        @foreach($widgets['news-outstanding']->object as $key => $val)
                            <div class="uk-width-medium-1-3">
                                @php
                                    $cat_title = $val->languages->first()->pivot->name;
                                    $cat_image = $val->image;
                                @endphp
                                <div class="news-post">
                                    <h2 class="heading-1">
                                        <span>{{ $cat_title }}</span>
                                    </h2>
                                    <a href="" class="image img-cover">
                                        <img src="{{ $cat_image }}" alt="">
                                    </a>
                                    <div class="list-post">
                                        @foreach($val->posts as $k => $post)
                                            @php
                                                $title = $post->languages->first()->pivot->name;
                                                $canonical = write_url($post->languages->first()->pivot->canonical);
                                            @endphp
                                           <div class="post-item">
                                              <a href="{{ $canonical }}">{{ $title }}</a>
                                           </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

