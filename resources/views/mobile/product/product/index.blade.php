@php
    $name = $product->name;
    $canonical = write_url($product->canonical);
    $image = image($product->image);
    $price = getPrice($product);
    $catName = $productCatalogue->name;
    $review = getReview($product);
    
    $description = $product->description;
    $content = $product->content;
    $attributeCatalogue = $product->attributeCatalogue;
    $gallery = json_decode($product->album);
@endphp

@extends('mobile.homepage.layout')
@section('content')
    <div id="mobile-container" class="mobile-product-detail">
        @include('mobile.component.breadcrumb', ['model' => $productCatalogue, 'breadcrumb' => $breadcrumb])
        <div class="uk-container uk-container-center">
            <div class="panel-head">
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
                                            <a href="{{ $val }}" data-uk-lightbox="{group:'my-group'}" class="image img-cover"><img src="{{ image($val) }}" alt="<?php echo $val ?>"></a>
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
                            <div class="price-container">
                                {!! $price['html'] !!}
                            </div>
                            
                            <div class="product-detail__description">
                                {!! $product->description !!}
                            </div>
                            <div class="uk-grid uk-grid-medium">
                                <div class="uk-width-1-2 uk-width-large-1-2">
                                    <a class="button-item suggest" data-uk-modal="{target:'#suggest'}">
                                        <span class="main-text">Yêu cầu tư vấn</span>
                                        <span class="small-text">Thông tin chi tiết nhất</span>
                                    </a>
                                    @include('mobile.product.product.component.suggest', ['product' => $product])
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
                                    <input type="number" name="phone" class="phone-input" placeholder="Nhập số điện thoại..." required="">
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
                            <div class="order-group">
                                <div class="uk-grid uk-grid-medium">
                                    <div class="uk-width-1-2 uk-width-large-1-2">
                                        <button class="btn-product-button addToCart order-button-item" data-id="{{ $product->id }}">
                                            Thêm giỏ hàng
                                        </button>
                                    </div>
                                    <div class="uk-width-1-2 uk-width-large-1-2">
                                        <button class="order-button-item order-buy-now" data-id="{{ $product->id }}">
                                            Mua ngay
                                        </button>
                                    </div>
                                </div>
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
                    
                            <!-- This is the container of the content items -->
                            <ul id="my-id" class="uk-switcher">
                                <li>
                                    <div class="content-container">
                                        {!! $content !!}
                                    </div>
                                    <button class="view-more-btn">Xem thêm</button>
                                </li>
                            </ul>
                            @include('mobile.product.product.component.review', ['model' => $product, 'reviewable' => 'App\Models\Product'])
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
                    
                            @if(isset($cartSeen))
                            <div class="product-seen mt30 mb30">
                                <div class="aside-heading">Sản phẩm đã xem</div>
                                <div>
                                    @foreach($cartSeen as $key => $val)
                                    @php
                                        $name = $val->name;
                                        $canonical = write_url($val->options['canonical']);
                                        $image = $val->options['image'];
                                        $price = $val->price;
                                    @endphp
                                    <div class="product-seen-item">
                                        <a href="{{ $canonical }}" class="image img-cover"><img src="{{ $image }}" alt="{{ $name }}"></a>
                                        <div class="info">
                                            <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <div class="price">
                                                    Giá: <span>{{ number_format($price, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        </div>
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
        <div class="product-related">
            <div class="uk-container uk-container-center">
                <div class="panel-product content-aside">
                    <div class="aside-heading">Sản phẩm liên quan</div>
                    <div class="panel-body list-product">
                        @if(count($productCatalogue->products))
                            @foreach($productCatalogue->products as $index => $item)
                                @if($item->id != $product->id)
                                    @if($index > 2) @break @endif
                                    @include('mobile.component.product-item', ['product' => $item])
                                @endif
                            @endforeach
                        @endif
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
        @if(isset($widgets['news']))
            <div class="panel-news fix index">
                <div class="uk-container uk-container-center">
                    <div class="panel-head uk-text-center">
                        <h2 class="heading-6"><span>{{ $widgets['news']->name }}</span></h2>
                    </div>
                    <div class="panel-body">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @if(count($widgets['news']->object))
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
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection