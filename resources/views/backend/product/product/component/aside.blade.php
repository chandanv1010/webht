<div class="ibox w">
    <div class="ibox-title">
        <h5>{{ __('messages.parent') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <select name="product_catalogue_id" class="form-control setupSelect2" id="">
                        @foreach($dropdown as $key => $val)
                        <option {{ 
                            $key == old('product_catalogue_id', (isset($product->product_catalogue_id)) ? $product->product_catalogue_id : '') ? 'selected' : '' 
                            }} value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @php
            $catalogue = [];
            if(isset($product)){
                foreach($product->product_catalogues as $key => $val){
                    $catalogue[] = $val->id;
                }
            }
        @endphp
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <label class="control-label">{{ __('messages.subparent') }}</label>
                    <select multiple name="catalogue[]" class="form-control setupSelect2" id="">
                        @foreach($dropdown as $key => $val)
                        <option 
                            @if(is_array(old('catalogue', (
                                isset($catalogue) && count($catalogue)) ?   $catalogue : [])
                                ) && isset($product->product_catalogue_id) && $key !== $product->product_catalogue_id &&  in_array($key, old('catalogue', (isset($catalogue)) ? $catalogue : []))
                            )
                            selected
                            @endif value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ibox w">
    <div class="ibox-title">
        <h5>{{ __('messages.product.information') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="">{{ __('messages.product.code') }}</label>
                    <input 
                        type="text"
                        name="code"
                        value="{{ old('code', ($product->code) ?? time()) }}"
                        class="form-control"
                    >
                </div>
            </div>
        </div>
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="">{{ __('messages.product.made_in') }}</label>
                    <input 
                        type="text"
                        name="made_in"
                        value="{{ old('made_in', ($product->made_in) ?? null) }}"
                        class="form-control "
                    >
                </div>
            </div>
        </div>
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="">{{ __('messages.product.price') }}</label>
                    <input 
                        type="text"
                        name="price"
                        value="{{ old('price', (isset($product)) ? number_format($product->price, 0 , ',', '.') : '') }}"
                        class="form-control int"
                    >
                </div>
            </div>
        </div>
        <div class="form-row mb20">
            <label for="" class="control-label text-left">Thời gian BH</label>
            <div class="guarantee">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <input 
                        type="text"
                        name="guarantee"
                        value="{{ old('guarantee', $product->guarantee  ?? null) }}"
                        class="text-right form-control int"
                        placeholder=""
                        autocomplete="off"
                        style="margin-right:10px;"
                    >
                    <select class="setupSelect2" name="" id="">
                        <option value="month">tháng</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-row">
            <label for="">Thông số kỹ thuật</label>
            <textarea
                type="text"
                name="specs"
                class="form-control"
                style="height:150px;"
                placeholder="Nền tảng: Laravel 10 · PHP 8.1+ · MySQL 8.0&#10;Số trang: 12&#10;Trang quản trị: Tiếng Việt, có phân quyền"
            >{{ old('specs', ($product->specs) ?? '') }}</textarea>
            <small style="display:block;margin-top:6px;color:#888;line-height:18px;">
                Mỗi dòng một thông số, theo dạng <b>Nhãn: Giá trị</b>. Hiện ở tab
                &ldquo;Thông số kỹ thuật&rdquo; trên trang chi tiết. Để trống thì dùng bộ
                thông số mặc định.
            </small>
        </div>

        <div class="form-row">
            <label for="">Link xem trước (hoặc mã nhúng)</label>
            <textarea
                type="text"
                name="iframe"
                class="form-control"
                style="height:110px;"
                placeholder="https://demo.example.com — hoặc dán cả thẻ <iframe src=&quot;...&quot;>"
            >{{ old('iframe', ($product->iframe) ?? '') }}</textarea>
            <small style="display:block;margin-top:6px;color:#888;line-height:18px;">
                Dán địa chỉ mẫu đang chạy. Trang chi tiết sẽ hiển thị mẫu thật trong khung
                máy tính / máy tính bảng / điện thoại, và bố cục co giãn theo khung.
                Để trống thì dùng ảnh chụp.
            </small>
        </div>
    </div>
</div>
@include('backend.dashboard.component.publish', ['model' => ($product) ?? null, 'hideImage' => false])

@if(!empty($product->qrcode))
<div class="ibox w">
    <div class="ibox-title">
        <h5>Mã QRCODE</h5>
    </div>
    <div class="ibox-content qrcode">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    {!! $product->qrcode !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endif