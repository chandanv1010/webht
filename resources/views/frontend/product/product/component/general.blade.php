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
        @include('frontend.product.product.component.review', ['model' => $product, 'reviewable' => 'App\Models\Product'])
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