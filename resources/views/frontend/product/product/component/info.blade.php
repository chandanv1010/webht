<div class="product-info">
    <div class="price-container">
        {!! $price['html'] !!}
    </div>
    
    <div class="product-detail__description">
        {!! $product->description !!}
    </div>
    <div class="uk-grid uk-grid-medium">
        <div class="uk-width-large-1-2">
            <a class="button-item suggest" data-uk-modal="{target:'#suggest'}">
                <span class="main-text">Yêu cầu tư vấn</span>
                <span class="small-text">Thông tin chi tiết nhất</span>
            </a>
            @include('frontend.product.product.component.suggest', ['payload' => $product])
        </div>
        <div class="uk-width-large-1-2">
            <a class="button-item book" data-uk-modal="{target:'#suggest'}">
                <span class="main-text">Hẹn lịch đến xem</span>
                <span class="small-text">Được sắp chỗ để xe miễn phí</span>
            </a>
        </div>
    </div>
    <div class="quick-consult">
        <div class="quick-consult-title">Tư vấn nhanh</div>
        <div class="quick-consult-form" data-id="{{ $product->id }}">
            <input type="number" name="phone" class="phone-input" placeholder="Nhập số điện thoại..." required>
            <input type="hidden" name="product-name" value="{{ $product->name }}">
            <button type="submit" class="submit-button" >Gửi</button>
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
            <div class="uk-width-large-1-2">
                <button class="btn-product-button addToCart order-button-item" data-id="{{ $product->id }}">
                    Thêm vào giỏ hàng
                </button>
            </div>
            <div class="uk-width-large-1-2">
                <button class="order-button-item order-buy-now" data-id="{{ $product->id }}">
                    Mua ngay
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 320 512" class="w-5 h-5 text-[#B20000]"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path>
                        </svg>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>