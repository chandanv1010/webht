@extends('frontend.homepage.layout')

@section('content')
   <div class="hosting-container">
        <div class="hosting-header">
            <div class="uk-grid uk-grid-medium uk-flex uk-flex-middle">
                <div class="uk-width-large-2-5">
                    <div class="hosting-content">
                        <h2 class="hosting-element-title">
                            Powerful  <strong><em>Web</em> Hosting</strong>
                        </h2>
                        <div class="description">
                            HT Việt Nam cung cấp dịch vụ hosting siêu tốc, ổn định và tối ưu cho mọi nền tảng website – từ landing page đến hệ thống dữ liệu phức tạp.
                        </div>
                    </div>
                </div>
                <div class="uk-width-large-3-5">
                    <lottie-player src="https://lottie.host/7f18a936-2156-430e-9143-373dbd94a589/0HWlkEScMy.json" background="transparent" speed="1" style="width: 100%;height: 100%" loop="" autoplay=""></lottie-player>
                </div>
            </div>
        </div>
        <div class="uk-container uk-container-center">
            <div class="panel-search-domain">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-large-1-3">
                        <div class="heading">Tìm kiếm tên miền <br> phù hợp với bạn </div>
                    </div>
                    <div class="uk-width-large-2-3">
                        <form action="" class="domain-form">
                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                <span class="mr10">www.</span>
                                <input type="text" class="input-text" placeholder="tên miền">
                                <span class="dot">.</span>
                                <select name="" class="domain-check">
                                    <option value="com">com</option>
                                    <option value="net">net</option>
                                    <option value="vn">vn</option>
                                    <option value="com.vn">com.vn</option>
                                </select>
                                <input type="submit" class="dc-submit-1" value="Kiểm tra">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-best">
            <div class="uk-container uk-container-center">
                <div class="panel-head uk-text-center">
                    <span>Hosting chất lượng cao</span>
                    <h2 class="heading-9"><span>Web Hosting Platform</span></h2>
                </div>
                <div class="panel-body">
                    <div class="uk-grid uk-grid-medium">
                        <div class="uk-width-medium-1-2 uk-width-large-1-3">
                            <div class="best-item">
                                <div class="icon">
                                    <img src="{{ asset('frontend/resources/img/icon-img-01.png') }}" alt="">
                                </div>
                                <div class="info">
                                    <h3 class="title">🌐 Cam kết hoạt động 99.9%</h3>
                                    <div class="description">
                                    Chúng tôi đảm bảo website của bạn luôn online, hoạt động ổn định gần như mọi lúc mọi nơi.
                                        Bạn có thể yên tâm tập trung vào công việc mà không lo gián đoạn.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-2 uk-width-large-1-3">
                            <div class="best-item active">
                                <div class="icon">
                                    <img src="{{ asset('frontend/resources/img/icon-img-02.png') }}" alt="">
                                </div>
                                <div class="info">
                                    <h3 class="title">🔐 An toàn và bảo mật</h3>
                                    <div class="description">
                                        Mọi dữ liệu của bạn đều được bảo vệ nghiêm ngặt với hệ thống bảo mật hiện đại.
                                        Chỉ những người được phép mới có quyền truy cập.
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="uk-width-medium-1-2 uk-width-large-1-3">
                            <div class="best-item">
                                <div class="icon">
                                    <img src="{{ asset('frontend/resources/img/icon-img-03.png') }}" alt="">
                                </div>
                                <div class="info">
                                    <h3 class="title">🙋‍♂️ Hỗ trợ tận tâm</h3>
                                    <div class="description">
                                        Đội ngũ hỗ trợ thân thiện, luôn sẵn sàng giúp đỡ bạn 24/7 bất cứ khi nào cần.
                                        Chúng tôi ở đây để đồng hành cùng bạn.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-host-intro panel-best">
           <div class="uk-grid uk-grid-medium uk-flex uk-flex-middle">
                <div class="uk-width-large-1-2">
                    <div class="lotier">
                        <lottie-player src="https://lottie.host/fce80f91-dd65-4dc8-944f-4f727ecf23f8/nHJzPOX8u5.json" background="transparent" speed="1" style="width: 100%;height: 100%" loop="" autoplay=""></lottie-player>
                    </div>
                </div>
                <div class="uk-width-large-1-2">
                    <div class="host-intro-container">
                        <div class="panel-head">
                            <span>HT Việt Nam</span>
                            <h2 class="heading-9"><span>Nền tảng vững chắc, hiệu năng <br> vượt trội</span></h2>
                            <div class="description">
                                Chúng tôi sử dụng hạ tầng Google Cloud để mang đến một dịch vụ hosting mạnh mẽ, hiện đại và ổn định vượt trội.
                                Hệ thống của bạn sẽ luôn sẵn sàng, bảo mật và hoạt động hiệu quả trên nền tảng công nghệ hàng đầu.
                            </div>
                            
                            <div class="elementor-widget-container" bis_skin_checked="1">
							    <ul class="uk-list uk-clearfix">
                                    <li class="elementor-icon-list-item">
                                        <span class="elementor-icon-list-icon">
                                            01.
                                        </span>
                                        <span class="elementor-icon-list-text">Lý tưởng cho các agency và website có lưu lượng lớn</span>
                                    </li>
                                    <li class="elementor-icon-list-item">
                                        <span class="elementor-icon-list-icon">
                                            02.
                                        </span>
                                         <span class="elementor-icon-list-text">Chúng tôi luôn trân trọng sự tin tưởng của bạny</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-host-pricing">
            <div class="uk-container uk-container-center">
                <div class="panel-head">
                    <div class="special-text-1">Bảng Giá</div>
                    <div class="heading-11"><span>Bảng giá hosting của chúng tôi</span></div>
                </div>
                <div class="panel-body">
                    <div class="uk-grid uk-grid-medium">
                        <div class="uk-width-medium-1-2 uk-width-large-1-3">
                            <div class="hosting-item">
                                <div class="head">
                                    <div class="name">Gói cơ bản</div>
                                    <div class="price">75.000đ</div>
                                    <div class="per">/ tháng</div>
                                </div>
                                <div class="body">
                                    <ul class="uk-list uk-clearfix">
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>SSD NVME</span>
                                                <span>1GB</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Băng thông</span>
                                                <span>50GB</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Địa chỉ Email</span>
                                                <span>1</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Database</span>
                                                <span>1</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Park/Addon Domain</span>
                                                <span>1</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>SSL</span>
                                                <span>-</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Tiêu chuẩn chất lượng</span>
                                                <div class="rating" bis_skin_checked="1">
                                                    <div class="uk-flex uk-flex-middle" bis_skin_checked="1">
                                                        <img src="{{ asset('frontend/resources/img/star.png') }}" alt="star-rating">
                                                        <img src="{{ asset('frontend/resources/img/star.png') }}" alt="star-rating">
                                                        <img src="{{ asset('frontend/resources/img/star.png') }}" alt="star-rating">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-2 uk-width-large-1-3">
                            <div class="hosting-item">
                                <div class="head">
                                    <div class="name">Gói chuyên nghiệp</div>
                                    <div class="price">130.000đ</div>
                                    <div class="per">/ tháng</div>
                                </div>
                                <div class="body">
                                    <ul class="uk-list uk-clearfix">
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>SSD NVME</span>
                                                <span>3 GB</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Băng thông</span>
                                                <span>150GB</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Địa chỉ Email</span>
                                                <span>3</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Database</span>
                                                <span>3</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Park/Addon Domain</span>
                                                <span>3</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>SSL</span>
                                                <span>-</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Tiêu chuẩn chất lượng</span>
                                                <div class="rating" bis_skin_checked="1">
                                                    <div class="uk-flex uk-flex-middle" bis_skin_checked="1">
                                                        <img src="{{ asset('frontend/resources/img/star.png') }}" alt="star-rating">
                                                        <img src="{{ asset('frontend/resources/img/star.png') }}" alt="star-rating">
                                                        <img src="{{ asset('frontend/resources/img/star.png') }}" alt="star-rating">
                                                        <img src="{{ asset('frontend/resources/img/star.png') }}" alt="star-rating">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                         <div class="uk-width-medium-1-2 uk-width-large-1-3">
                            <div class="hosting-item">
                                <div class="head">
                                    <div class="name">Gói doanh nghiệp</div>
                                    <div class="price">175.000đ</div>
                                    <div class="per">/ tháng</div>
                                </div>
                                <div class="body">
                                    <ul class="uk-list uk-clearfix">
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>SSD NVME</span>
                                                <span>5 GB</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Băng thông</span>
                                                <span>Không giới hạn</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Địa chỉ Email</span>
                                                <span>5</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Database</span>
                                                <span>5</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Park/Addon Domain</span>
                                                <span>5</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>SSL</span>
                                                <span>-</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Tiêu chuẩn chất lượng</span>
                                                <div class="rating" bis_skin_checked="1">
                                                    <div class="uk-flex uk-flex-middle" bis_skin_checked="1">
                                                        <img src="{{ asset('frontend/resources/img/star.png') }}" alt="star-rating">
                                                        <img src="{{ asset('frontend/resources/img/star.png') }}" alt="star-rating">
                                                        <img src="{{ asset('frontend/resources/img/star.png') }}" alt="star-rating">
                                                        <img src="{{ asset('frontend/resources/img/star.png') }}" alt="star-rating">
                                                        <img src="{{ asset('frontend/resources/img/star.png') }}" alt="star-rating">
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($widgets['feedback']->object)
            @foreach($widgets['feedback']->object as $feedback)
            <div class="panel-customer">
                <div class="panel-head">
                    <h2 class="heading-10"><span>Feedback</span></h2>
                </div>
                @if(isset($feedback->posts) && count($feedback->posts))
                <div class="panel-body">
                    <div class="swiper-container your-swiper-container">
                        <div class="swiper-controls">
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                        <div class="swiper-wrapper">
                            @for($i = 0; $i<=10; $i++)
                                @foreach($feedback->posts as $post)
                                @php
                                    $name = explode('-', $post->languages[0]->name);
                                    $description = $post->languages[0]->description;
                                    $image = $post->image;
                                @endphp
                                <div class="swiper-slide">
                                    <div class="customer-item">
                                        <div class="rating">
                                            <div class="uk-flex uk-flex-middle">
                                                <img src="{{ asset('frontend/resources/img/star.png') }}" alt="">
                                                <img src="{{ asset('frontend/resources/img/star.png') }}" alt="">
                                                <img src="{{ asset('frontend/resources/img/star.png') }}" alt="">
                                                <img src="{{ asset('frontend/resources/img/star.png') }}" alt="">
                                                <img src="{{ asset('frontend/resources/img/star.png') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="description">
                                        {!! $description !!}
                                        </div>
                                        <div class="uk-flex uk-flex-middle">
                                            <div class="avatar">
                                                <img src="{{ $image }}" alt="">
                                            </div>
                                            <div class="customer-info">
                                                <div class="name">{{ $name[0] }}</div>
                                                <div class="role">{{ ($name[1]) ?? '' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endfor
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            @endif
        </div>
        <div class="panel-support">
            <div class="uk-container uk-container-center">
                <div class="panel-head uk-text-center">
                    <div class="small-heading">HT VIỆT NAM</div>
                    <h2 class="heading-9"><span>Bạn Đang Tìm Kiếm Giải Pháp?</span></h2>
                    <div class="description">Chúng tôi cung cấp các tài liệu, kiến thức, FAQ và hơn thế nữa về dịch vụ Website</div>
                </div>
                <div class="panel-body">
                    <div class="uk-grid uk-grid-medium">
                        <div class="uk-width-large-1-2">
                            <div class="support-item">
                                <div class="uk-grid uk-grid-small uk-flex uk-flex-middle">
                                    <div class="uk-width-large-1-2">
                                        <div class="support-article">
                                            <div class="title">Hỗ trợ qua Email</div>
                                            <div class="description">Dịch vụ phát triển website chuyên nghiệp. Hãy gửi cho chúng tôi Email của bạn</div>
                                            <a href="" class="btn-support-button">Give Me A Email</a>
                                        </div>
                                    </div>
                                    <div class="uk-width-large-1-2">
                                        <div class="lottier-wraper">
                                            <lottie-player src="https://lottie.host/18f60b16-e23a-48df-89db-281c208fe879/LUAdHKdqJP.json" background="transparent" speed="1" style="width: 100%;height: 100%" loop="" autoplay=""></lottie-player>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-large-1-2">
                            <div class="support-item support-phone">
                                <div class="uk-grid uk-grid-small uk-flex uk-flex-middle">
                                    <div class="uk-width-large-1-2">
                                        <div class="support-article">
                                            <div class="title">Hỗ trợ Hotline</div>
                                            <div class="description">Dịch vụ phát triển website chuyên nghiệp. Hãy gọi ngay cho chúng tôi</div>
                                            <a href="" class="btn-support-button support-phone-button">{{ $system['contact_hotline'] }}</a>
                                        </div>
                                    </div>
                                    <div class="uk-width-large-1-2">
                                        <div class="lottier-wraper">
                                            <lottie-player src="https://lottie.host/4803ecb0-dbde-4ff8-be38-76065fe3e084/cyxKMmXrCA.json" background="transparent" speed="1" style="width: 100%;height: 100%" loop="" autoplay=""></lottie-player>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>
@endsection
