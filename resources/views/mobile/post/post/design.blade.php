@php
    $name = $post->name;
    $canonical = write_url($post->canonical);
    $image = image($post->image);
    $catName = $postCatalogue->name;
    $description = $post->description;
    $content = $post->content;
    $gallery = json_decode($post->album);
@endphp
@extends('mobile.homepage.layout')
@section('content')
    <div id="mobile-container" class="mobile-product-detail">
        @include('mobile.component.breadcrumb', ['model' => $postCatalogue, 'breadcrumb' => $breadcrumb])
        <div class="uk-container uk-container-center">
            <div class="panel-head">
                @if(isset($postCatalogue->children) && !is_null($postCatalogue->children) )
                    <ul class="children">
                        @foreach($postCatalogue->children as $key => $item)
                            @php
                                $name =  $item->short_name;
                                $canonical = write_url($item->languages->first()->pivot->canonical);
                            @endphp
                            <li>
                                <a href="{{ $canonical }}" title="{{ $name }}" class="{{ $item->languages->first()->pivot->canonical == $postCatalogue->canonical ? 'active' : '' }}">{{ $name }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <h1 class="product-detail-name ">{{ $name }}</h1>
                <div class="product-detail-container">
                    <div class="mobile-product-detail-gallery">
                        @if(!is_null($gallery))
                            <div class="product-gallery">
                                <div class="swiper-container">
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-wrapper big-pic">
                                        <?php foreach($gallery as $key => $val){  ?>
                                            <div class="swiper-slide" data-swiper-autoplay="2000">
                                                <a href="{{ $val }}" data-fancybox="my-group" class="image img-cover">
                                                    <img src="{{ image($val) }}" alt="<?php echo $val ?>">
                                                </a>
                                            </div>
                                        <?php }  ?>
                                    </div>
                                </div>
                                <div class="swiper-container-thumbs">
                                    <div class="swiper-wrapper pic-list">
                                        <?php foreach($gallery as $key => $val){  ?>
                                        <div class="swiper-slide">
                                            <span  class="image img-cover"><img src="{{  image($val) }}" alt="<?php echo $val ?>"></span>
                                        </div>
                                        <?php }  ?>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="mobile-product-info product-detail-info mb30">
                        <div class="product-info">
                            <div class="product-detail__description">
                                {!! $post->description !!}
                            </div>
                            <div class="uk-grid uk-grid-medium">
                                <div class="uk-width-1-2 uk-width-large-1-2">
                                    <a class="button-item suggest" data-uk-modal="{target:'#suggest'}">
                                        <span class="main-text">Yêu cầu tư vấn</span>
                                        <span class="small-text">Thông tin chi tiết nhất</span>
                                    </a>
                                    @include('mobile.product.product.component.suggest', ['product' => $post])
                                </div>
                                <div class="uk-width-1-2 uk-width-large-1-2">
                                    <a class="button-item book" data-uk-modal="{target:'#suggest'}">
                                        <span class="main-text">Hẹn lịch đến xem</span>
                                        <span class="small-text">Được sắp chỗ để xe miễn phí</span>
                                    </a>
                                </div>
                            </div>
                            <div class="quick-consult">
                                <div class="quick-consult-title">Tư vấn nhanh</div>
                                <div class="quick-consult-form">
                                    <input type="tel" class="phone-input" placeholder="Nhập số điện thoại..." required>
                                    <button type="submit" class="submit-button">Gửi</button>
                                </div>
                            </div>
                            <div class="shopware mb20">
                                <p>HỆ THỐNG SHOWROOM CHÍNH HÃNG:</p>
                                <p>
                                    <a href="{{ $system['contact_office_map'] }}" target="_blank">
                                        Hà Nội: {{ $system['contact_office'] }}
                                    </a>
                                </p>
                                <p>
                                    <a href="{{ $system['hcm_office_map'] }}" target="_blank">
                                        TP. HCM: {{ $system['hcm_office'] }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="product-general-info">
                        <div class="content-info">
                            <!-- This is the container of the toggling elements -->
                            <ul data-uk-switcher="{connect:'#my-id'}" class="switcher mb20">
                                <li><a href="">Mô tả</a></li>
                                <li><a href="">Thông tin bổ sung</a></li>
                                <li><a href="">Gợi ý kết hợp</a></li>
                            </ul>
                    
                            <ul id="my-id" class="uk-switcher">
                                <li>
                                    <div class="content-container">
                                        {!! $content !!}
                                    </div>
                                    <button class="view-more-btn">Xem thêm</button>
                                </li>
                            </ul>
                        </div>
                        <div class="content-aside">
                            @if(isset($widgets['news-feature']))
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
                    
                    
                            @if(isset($widgets['projects-feature']))
                                <div class="post-featured project-featured mt40" data-uk-sticky="{boundary: true}">
                                    <div class="aside-heading">{{ $widgets['projects-feature']->name }}</div>
                                    <div>
                                        @foreach($widgets['projects-feature']->object as $key => $val)
                                        @php
                                            $name = $val->languages->name;
                                            $canonical = write_url($val->languages->canonical);
                                            $createdAt = $val->created_at;
                                            $image = thumb($val->image, 280, 186);
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
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Lấy tất cả các nút "Xem thêm"
                            const viewMoreButtons = document.querySelectorAll('.view-more-btn');
                            
                            viewMoreButtons.forEach(function(button) {
                                // Tìm content container liên quan (element anh em liền trước)
                                const container = button.previousElementSibling;
                                
                                if (container && container.classList.contains('content-container')) {
                                    // Thêm sự kiện click cho nút
                                    button.addEventListener('click', function() {
                                        if (container.classList.contains('expanded')) {
                                            container.classList.remove('expanded');
                                            button.textContent = 'Xem thêm';
                                            // Scroll lên đầu của container nếu cần
                                            container.scrollIntoView({behavior: 'smooth'});
                                        } else {
                                            container.classList.add('expanded');
                                            button.textContent = 'Thu gọn';
                                        }
                                    });
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
        {{-- @include('mobile.component.news-outstanding') --}}
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