
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
                    <li><a href="{{ route('buyer.profile') }}" title="">Thông tin tài khoản</a></li>
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
                                <div class="heading-2"><span>Hồ sơ của tôi</span></div>
                                <div class="description">Quản lý thông tin hồ sơ để bảo mật tài khoản</div>
                            </div>
                            <div class="panel-body">
                                @include('backend.dashboard.component.formError')
                                <form action="{{ route('buyer.profile.update') }}" method="post" class="uk-form form">
                                    @csrf
                                    <div class="form-row">
                                        <span class="label-name">Họ Tên:</span>
                                        <span class="label-value">
                                            <input 
                                                type="text"
                                                name="name"
                                                value="{{ $customerAuth->name }}"
                                                class="input-text"
                                            >
                                        </span>
                                    </div>
                                    <div class="form-row">
                                        <span class="label-name">Số điện thoại:</span>
                                        <span class="label-value">
                                            <input 
                                                type="text"
                                                name="phone"
                                                value="{{ $customerAuth->phone }}"
                                                placeholder=" {{ $customerAuth->phone ?? 'Chưa cập nhật' }}"
                                                class="input-text"
                                            >
                                        </span>
                                    </div>
                                    <div class="form-row">
                                        <span class="label-name">Email:</span>
                                        <span class="label-value">{{ $customerAuth->email }}</span>
                                    </div>

                                    <div class="form-row">
                                        <span class="label-name">Thành phố:</span>
                                        <span class="label-value">
                                            <select name="province_id" class="input-text city">
                                                <option value="0">[Chọn Thành Phố]</option>
                                                @if($provinces['data'])
                                                    @foreach($provinces['data'] as $city)
                                                    <option value="{{ $city['PROVINCE_ID'] }}">{{ $city['PROVINCE_NAME'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </span>
                                    </div>
                                    <div class="form-row">
                                        <span class="label-name">Quận/Huyện:</span>
                                        <span class="label-value">
                                            <select name="district_id" class="input-text district">
                                                <option value="0">[Chọn Quận/Huyện]</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="form-row">
                                        <span class="label-name">Chọn Phường Xã:</span>
                                        <span class="label-value">
                                            <select name="ward_id" class="input-text ward">
                                                <option value="0">[Chọn Phường/Xã]</option>
                                            </select>
                                        </span>
                                    </div>

                                    <div class="form-row">
                                        <span class="label-name">Địa chỉ:</span>
                                        <span class="label-value">
                                            <input 
                                                type="text"
                                                name="address"
                                                value="{{ $customerAuth->address }}"
                                                placeholder=" {{ $customerAuth->address ?? 'Chưa cập nhật' }}"
                                                class="input-text"
                                            >
                                        </span>
                                    </div>

                                    <div class="form-row">
                                        <span class="label-name">Tài khoản ViettelPost:</span>
                                        <span class="label-value">
                                            <input 
                                                type="text"
                                                name="viettelpost_email"
                                                value="{{ $customerAuth->viettelpost_email }}"
                                                placeholder=" {{ $customerAuth->viettelpost_email ?? 'Chưa cập nhật' }}"
                                                class="input-text"
                                            >
                                        </span>
                                    </div>

                                    <div class="form-row">
                                        <span class="label-name">Mật khẩu ViettelPost:</span>
                                        <span class="label-value">
                                            <input 
                                                type="text"
                                                name="viettelpost_password"
                                                value="{{ $customerAuth->viettelpost_password }}"
                                                placeholder=" {{ $customerAuth->viettelpost_password ?? 'Chưa cập nhật' }}"
                                                class="input-text"
                                            >
                                        </span>
                                    </div>
                                   
                                    <button type="submit" href="" class="button-shop change-info">Thay đổi thông tin</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var province_id = '{{ (isset($customerAuth->province_id)) ? $customerAuth->province_id : old('province_id') }}'
        var district_id = '{{ (isset($customerAuth->district_id)) ? $customerAuth->district_id : old('district_id') }}'
        var ward_id = '{{ (isset($customerAuth->ward_id)) ? $customerAuth->ward_id : old('ward_id') }}'
    </script>

@endsection
