
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
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã đơn hàng</th>
                                            <th>Ngày đặt</th>
                                            <th>Thành tiền</th>
                                            <th>Phí ship</th>
                                            <th>Tổng tiền</th>
                                            <th>Tình trạng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($order) && count($order))
                                            @foreach($order as $key => $val)
                                            @php
                                                // dd($val);
                                                $cartTotal = convert_price($val->cart['cartTotal'], true);
                                            @endphp
                                            <tr>
                                                <td>{{ $val->id }}</td>
                                                <td><a class="order-detail-link" href="{{ route('buyer.order.detail', ['id' => $val->id]) }}">{{ $val->code }}</a></td>
                                                <td>{{ convertDateTime($val->created_at, 'd-m-Y') }}</td>
                                                <td>{{ $cartTotal }}₫</td>
                                                <td>{{ convert_price($val->shipping, true) }}₫</td>
                                                <td style="color: blue;">{{ convert_price($val->shipping + $val->cart['cartTotal'], true) }}₫</td>
                                                <td>
                                                    {!! ($val->confirm != 'cancle') ? __('cart.confirm')[$val->confirm] : '<span class="cancle-badge">'.__('cart.confirm')[$val->confirm].'</span>' !!}
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
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
