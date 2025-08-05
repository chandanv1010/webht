
@extends('frontend.homepage.layout')

@section('content')
    <div id="buyer-signup">
        <div class="buyer-container">
            <div class="uk-container uk-container-center">
                <div class="signup-form">
                    @include('backend.dashboard.component.formError')
                    <div class="uk-grid uk-grid-collapse uk-flex uk-flex-middle">
                        <div class="uk-width-large-2-5">
                            <div class="social-login">
                                <div class="info">
                                    <div class="logo"><img src="{{ $system['homepage_logo'] }}" alt=""></div>
                                    <div class="description">
                                        Truy cập nhanh bằng mạng xã hội của bạn
                                    </div>
                                    <div class="login-social-item">
                                        <a href="{{ route('buyer.facebook.redirect') }}" title="" class="btn-facebook uk-flex uk-flex-middle">
                                            <i class="fa fa-facebook"></i>
                                            <span>Đăng nhập bằng Facebook</span>
                                        </a>
                                        <a href="{{ route('buyer.google.redirect') }}" title="" class="btn-google uk-flex uk-flex-middle">
                                            <i class="fa fa-google"></i>
                                            <span>Đăng nhập bằng Google</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-large-3-5">
                            <form action="{{ route('buyer.authenticate') }}" method="post" class="uk-form form form-signup">
                                @csrf
                                <h2 class="form-heading">Login</h2>
                                <div class="form-row">
                                    <input type="text" name="email" class="input-text" placeholder="Nhập vào email" value="{{ old('password') }}">
                                </div>
                                <div class="form-row">
                                    <input type="password" name="password" class="input-text" placeholder="Nhập vào mật khẩu">
                                </div>
                                <div class="form-row">
                                    <a href="" class="forgot-password">Quên mật khẩu?</a>
                                </div>
                                <button class="btn-form-submit">Đăng nhập</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
