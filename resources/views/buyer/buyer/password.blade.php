
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
                                <form action="{{ route('buyer.profile.password.update') }}" method="post" class="uk-form form">
                                    @csrf
                                    <div class="form-row">
                                        <span class="label-name">Mật khẩu cũ:</span>
                                        <span class="label-value">
                                            <input 
                                                type="password"
                                                name="old_password"
                                                value=""
                                                class="input-text"
                                            >
                                        </span>
                                    </div>
                                    <div class="form-row">
                                        <span class="label-name">Mật khẩu mới:</span>
                                        <span class="label-value">
                                            <input 
                                                type="password"
                                                name="new_password"
                                                value=""
                                                placeholder=""
                                                class="input-text"
                                            >
                                        </span>
                                    </div>
                                    <div class="form-row">
                                        <span class="label-name">Nhập lại mk:</span>
                                        <span class="label-value">
                                            <input 
                                                type="password"
                                                name="re_new_password"
                                                value=""
                                                placeholder=""
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
@endsection
