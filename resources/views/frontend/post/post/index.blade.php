@extends('frontend.homepage.layout')
@section('content')

<div class="post-detail">
    @include('frontend.component.breadcrumb', ['model' => $postCatalogue, 'breadcrumb' => $breadcrumb])
    <div class="product-catalogue-wrapper post-container">
        <div class="uk-container uk-container-center">
            <h1 class="page-heading">{{ $post->languages->first()->pivot->name }}</h1>
            <div class="description">
                {!! $postCatalogue->languages->first()->pivot->description !!}
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="uk-container uk-container-center" style="padding-top:30px;padding-bottom:30px;">
            <div class="post-detail-container">
                <div class="post-content {{ $post->status_menu == 2 ? 'full' : '' }}">
                    <div class="description">
                        {!! $post->languages->first()->pivot->description !!}
                    </div>
                    <div class="content">
                        {!! $post->languages->first()->pivot->content !!}
                    </div>
                </div>
                @if($post->status_menu != 2)
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
                        <div class="post-featured mt40" data-uk-sticky="{boundary: true}">
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
                @endif
            </div>
        </div>
    </div>
    @include('frontend.component.news')
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
