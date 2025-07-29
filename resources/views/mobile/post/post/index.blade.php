@extends('mobile.homepage.layout')
@section('content')
    <div id="mobile-container">
        
        <div class="post-detail">
            <div class="product-catalogue-wrapper">
                <div class="uk-container uk-container-center">
                    <h1 class="page-heading">{{ $post->languages->first()->pivot->name }}</h1>
                </div>
            </div>
            <div class="panel-body">
                <div class="uk-container uk-container-center" style="padding-top:20px;padding-bottom:30px;">
                    <div class="post-detail-container">
                        <div class="post-content">
                            <div class="created_at uk-flex uk-flex-middle">
                                <div class="time">Đã đăng vào {{ convertDateTime($post->created_at, 'H:i:s d/m/Y') }} </div>
                            </div>
                            <div class="description">
                                {!! $post->description !!}
                            </div>
                            <div class="description">
                                {!! $post->content !!}
                            </div>
                        </div>
                        <div class="post-aside">
                            @if($widgets['news-feature'])
                            <div class="post-featured">
                                <div class="aside-heading">{{ $widgets['news-feature']->name }}</div>
                                <div>
                                    @foreach($widgets['news-feature']->object as $key => $val)
                                    @php
                                        $name = $val->languages->name;
                                        $canonical = write_url($val->languages->canonical);
                                        $createdAt = $val->created_at;
                                    @endphp
                                    <div class="post-feature-item">
                                        <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($widgets['projects-feature'])
                                <div class="post-featured project-featured mt40">
                                    <div class="aside-heading">{{ $widgets['projects-feature']->name }}</div>
                                    <div>
                                        @foreach($widgets['projects-feature']->object as $key => $val)
                                        @php
                                            $name = $val->languages->name;
                                            $canonical = write_url($val->languages->canonical);
                                            $createdAt = $val->created_at;
                                            $image = thumb($val->image, 600, 400);
                                        @endphp
                                        <div class="post-feature-item">
                                            <a href="{{ $canonical }}" class="image img-cover"><img src="{{ $image }}" alt="{{ $name }}"></a>
                                            <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
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
                        <span>{{ $widgets['projects-feature']->name }}</span>
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
            @foreach($widgets['news']->object as $key => $val)
                @php
                    $catCanonical = write_url($val->languages->canonical);
                @endphp
                <div class="panel-news fix index">
                    <div class="uk-container uk-container-center">
                        <div class="panel-head uk-text-center">
                            <h2 class="heading-6"><span>{{ $widgets['news']->name }}</span></h2>
                        </div>
                        <div class="panel-body">
                            @if(isset($val->posts))
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach($val->posts as $keyPost => $post)
                                            @php
                                                if($keyPost > 2) break;
                                                $name = $post->languages[0]->name;
                                                $canonical = write_url($post->languages[0]->canonical);
                                                $image = thumb($post->image, 600, 400);
                                                $description = cutnchar(strip_tags($post['description']), 150);
                                                $cat = $post->post_catalogues[0]->languages[0]->name;
                                            @endphp
                                            <div class="swiper-slide">
                                                <div class="news-item">
                                                    <a href="{{ $canonical }}" class="image img-cover img-zoomin"><img src="{{ $image }}" alt=""></a>
                                                    <div class="info">
                                                        <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }} </a></h3>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    
<script>


    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý nút Ẩn/Hiện
        const tocToggle = document.querySelector('.tocToggle');
        const widgetToc = document.querySelector('.widget-toc');
        
        tocToggle.addEventListener('click', function(e) {
            e.preventDefault();
            widgetToc.classList.toggle('collapsed');
            
            if (widgetToc.classList.contains('collapsed')) {
                tocToggle.textContent = 'Hiện';
            } else {
                tocToggle.textContent = 'Ẩn';
            }
        });
        
        // Xử lý scroll đến nội dung khi click vào liên kết
        const tocLinks = document.querySelectorAll('.widget-toc a');
        
        tocLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Lấy id từ href của liên kết
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    // Scroll đến phần tử với hiệu ứng mượt
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                    
                    // Thêm một chút padding để không bị che bởi header cố định (nếu có)
                    // Điều chỉnh số 80 này tùy theo chiều cao của header của bạn
                    window.scrollBy(0, -80);
                    
                    // Tùy chọn: Thêm hiệu ứng highlight tạm thời cho phần được scroll đến
                    targetElement.classList.add('highlight-section');
                    setTimeout(function() {
                        targetElement.classList.remove('highlight-section');
                    }, 2000);
                }
            });
        });
    });
    </script>
@endsection