
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
                                        <a href="" title="" class="btn-facebook uk-flex uk-flex-middle">
                                            <i class="fa fa-facebook"></i>
                                            <span>Đăng nhập bằng Facebook</span>
                                        </a>
                                        <a href="" title="" class="btn-twitter uk-flex uk-flex-middle">
                                            <i class="fa fa-twitter"></i>
                                            <span>Đăng nhập bằng Twitter</span>
                                        </a>
                                        <a href="" title="" class="btn-google uk-flex uk-flex-middle">
                                            <i class="fa fa-google"></i>
                                            <span>Đăng nhập bằng Google</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-large-3-5">
                            <form action="{{ route('buyer.register') }}" method="post" class="uk-form form form-signup">
                                @csrf
                                <h2 class="form-heading">Sign Up</h2>
                                
                                <div class="form-row">
                                    <input type="text" name="name" class="input-text" placeholder="Nhập vào họ tên" value="{{ old('name') }}">
                                </div>
                                <div class="form-row">
                                    <input type="text" name="email" class="input-text" placeholder="Nhập vào email" value="{{ old('password') }}">
                                </div>
                                <div class="form-row">
                                    <input type="password" name="password" class="input-text" placeholder="Nhập vào mật khẩu">
                                </div>
                                <div class="form-row">
                                    <input type="password" name="re_password" class="input-text" placeholder="Nhập lại vào mật khẩu">
                                </div>
                                <button class="btn-form-submit">Đăng ký tài khoản</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
