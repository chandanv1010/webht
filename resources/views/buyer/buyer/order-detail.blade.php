
@extends('frontend.homepage.layout')

@section('content')
    <div id="buyer-signup"> 
        <div class="page-breadcrumb background">      
            <div class="uk-container uk-container-center">
                <ul class="uk-list uk-clearfix uk-flex uk-flex-middle">
                    <li>
                        <a href="/"><i class="fi-rs-home mr5"></i>Trang chủ</a>
                        <span><i class="fi-rs-angle-right"></i></span>
                    </li>
                    <li><a href="{{ route('buyer.profile') }}" title="">Danh sách đơn hàng</a></li>
                </ul>
            </div>
        </div>
        <div class="profile-container buyer-page">
            <div class="uk-container uk-container-center">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-large-1-4">
                        @include('buyer.buyer.component.aside')
                    </div>
                    <div class="uk-width-large-3-4">
                        <div class="profile-content buyer-wrapper">
                            <div class="panel-head">
                                <div class="heading-2"><span>Danh sách đơn hàng</span></div>
                                <div class="description">Quản lý thông tin đơn hàng của bạn</div>
                            </div>
                            <div class="panel-body">
                                <table class="order-table">
                                    <tbody>
                                        @foreach($order->products as $key => $val)
                                        @php
                                            $name = $val->pivot->name;
                                            $qty = $val->pivot->qty;
                                            $price = convert_price($val->pivot->price, true);
                                            $priceOriginal = convert_price($val->pivot->priceOriginal, true);
                                            $subtotal = convert_price($val->pivot->price * $qty, true);
                                            $image = image($val->image);
                                        @endphp
                                        <tr class="order-item">
                                            <td>
                                               <div class="image">
                                                    <span class="image img-scaledown"><img src="{{ $image; }}" alt=""></span>
                                                </div> 
                                            </td>
                                            <td style="width:285px;">
                                                <div class="order-item-name" title=""{{ $name }}">{{ $name }}</div>
                                                <div class="order-item-voucher">Mã giảm giá: Không có</div>
                                            </td>
                                            <td>
                                                <div class="order-item-price">{{ $price }} ₫</div>
                                            </td>
                                            <td>
                                                <div class="order-item-times">x</div>
                                            </td>
                                            <td>
                                                <div class="order-item-qty">{{ $qty }}</div>
                                            </td>
                                            <td>
                                                <div class="order-item-subtotal">
                                                    {{ $subtotal }} ₫
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="5" class="text-right">Tổng tạm</td>
                                            <td class="text-right">{{ convert_price($order->cart['cartTotal'], true) }} ₫</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">Giảm giá</td>
                                            <td class="text-right">- {{ convert_price($order->promotion['discount'], true) }} ₫</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right">Vận chuyển</td>
                                            <td class="text-right">{{ convert_price($order->shipping, true) }} ₫</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-right" ><strong>Tổng cuối</strong></td>
                                            <td class="text-right" style="font-size:18px;"><strong style="color:blue;">{{ convert_price($order->cart['cartTotal'] - $order->promotion['discount'] + $order->shipping, true) }} ₫</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
