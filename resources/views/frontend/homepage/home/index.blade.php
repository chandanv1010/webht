@extends('frontend.homepage.layout')

@section('content')
    @include('frontend.component.slide')
    @include('frontend.component.service')
    <div class="panel-provider">
        <div class="uk-container uk-container-center">
            <div class="panel-head">
                <div class="sub-heading">Dịch vụ</div>
                <div class="h2 heading-3"><span>Các Dịch vụ của chúng tôi</span></div>
            </div>
            <div class="panel-body">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-small-1-2 uk-width-medium-1-2 uk-width-large-1-4">
                        <div class="service-item-1">
                            <div class="icon"> <img src="{{ asset('frontend/resources/img/coding.png') }}" alt=""></div>
                            <h3 class="title"><span>Thiết kế website</span></h3>
                            <div class="description">
                                Thiết kế Website đẹp, sáng tạo, mã nguồn riêng biệt, chuẩn SEO, Chuẩn Mobile
                            </div>
                            <div class="t-readmore">
                                <a href="" class="text-readmore">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-small-1-2 uk-width-medium-1-2 uk-width-large-1-4">
                        <div class="service-item-1">
                            <div class="icon"> <img src="{{ asset('frontend/resources/img/booking.png') }}" alt=""></div>
                            <h3 class="title"><span>Thiết kế App Mobile</span></h3>
                            <div class="description">
                                Chúng tôi tạo ra các sản phẩm App Mobile ấn tượng, và đạt chất lượng cao
                            </div>
                            <div class="t-readmore">
                                <a href="" class="text-readmore">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-small-1-2 uk-width-medium-1-2 uk-width-large-1-4">
                        <div class="service-item-1">
                            <div class="icon"> <img src="{{ asset('frontend/resources/img/adwords.png') }}" alt=""></div>
                            <h3 class="title"><span>Quảng cáo Google</span></h3>
                            <div class="description">
                                HT Việt Nam giúp khách hàng dễ dàng tiếp cận tới khách hàng bằng dịch vụ quảng cáo google hiệu quả
                            </div>
                            <div class="t-readmore">
                                <a href="" class="text-readmore">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-small-1-2 uk-width-medium-1-2 uk-width-large-1-4">
                        <div class="service-item-1">
                            <div class="icon"> <img src="{{ asset('frontend/resources/img/hosting.png') }}" alt=""></div>
                            <h3 class="title"><span>Hosting</span></h3>
                            <div class="description">
                                Máy chủ sử dụng các dòng CPU thế hệ mới nhất của Intel công nghệ lưu trữ NVMe SSD U.2 - Raid 10 cực nhanh và an toàn dữ liệu cao nhất 
                            </div>
                            <div class="t-readmore">
                                <a href="" class="text-readmore">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-video">
        <div class="uk-container uk-container-center">
            <span class="image img-cover">
                <img src="{{ asset('frontend/resources/img/bg-img-01.jpg') }}" alt="icon">
            </span>
            <div class="button-container" style="position: relative;">
                <button class="play-button" data-uk-modal="{target:'#video-modal'}">
                    <div class="play-icon"></div>
                </button>
                
                <!-- Floating particles -->
                <div class="particles">
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-intro">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium uk-flex uk-flex-middle">
                <div class="uk-width-large-1-2">
                    <lottie-player src="https://lottie.host/5bd4f1d0-25a2-419b-8029-62523573228e/T3lPk1hX4F.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop="" autoplay=""></lottie-player>
                </div>
                <div class="uk-width-large-1-2">
                    <div class="intro-container">
                        <h2 class="heading-1"><span>Về Chúng Tôi</span></h2>
                        <div class="main-heading">Chúng tôi cung cấp những dịch vụ có chất lượng vượt trội</div>
                        <div class="description">
                            Thông qua thiết kế website & sáng tạo nội dung cho website, mỗi ngày Chúng tôi luôn thực hiện với khát khao làm cho việc kinh doanh online của khách hàng trở nên dễ dàng và hiệu quả hơn.
                        </div>
                        <div class="intro-item uk-clearfix uk-flex uk-flex-middle">
                            <div class="icon">
                                <img src="{{ asset('frontend/resources/img/slide/discovery.png') }}" alt="">
                            </div>
                            <div class="intro-text">
                                <div class="intro-title">Tìm hiểu và khám phá sản phẩm</div>
                                <div class="description">
                                    Một website hiệu quả cần được nghiên cứu kỹ lưỡng về đối tượng khách hàng và mục tiêu kinh doanh
                                </div>
                            </div>
                        </div>
                        <div class="intro-item uk-clearfix uk-flex uk-flex-middle">
                            <div class="icon">
                                <img src="{{ asset('frontend/resources/img/slide/satellite.png') }}" alt="">
                            </div>
                            <div class="intro-text">
                                <div class="intro-title">Chiến lược Website & Tối ưu hóa</div>
                                <div class="description">
                                    Website không chỉ đẹp mà còn phải hoạt động hiệu quả, thu hút khách hàng và tăng doanh số bán hàng
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-whyus">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-large uk-flex uk-flex-middle">
                <div class="uk-width-large-1-2">
                    <div class="whyus-container">
                        <h2 class="heading-1"><span>Tại sao lựa chọn chúng tôi</span></h2>
                        <div class="main-heading">Sở hữu website chưa bao giờ dễ dàng đến vậy</div>
                        <div class="description">
                            Giải pháp website kinh doanh chuyên nghiệp giúp đẩy mạnh kinh doanh online, tích hợp bán hàng trên nhiều kênh như Facebook, Sàn TMĐT Tiki, Shopee, Lazada, 
                            Cửa hàng….và quản lý mọi việc kinh doanh tại một nơi duy nhất
                        </div>
                        <div class="whyus-list">
                            <div class="whyus-item uk-clearfix">
                                <div class="icon">01</div>
                                <div class="info">
                                    <h3 class="title">Giao diện đẹp, đa dạng</h3>
                                    <div class="description">
                                        <strong>HT Việt Nam</strong> có hơn 250+ giao diện đẹp, <strong>chuẩn SEO</strong> phù hợp với mọi ngành nghề kinh doanh bán lẻ.
                                        Tuỳ chọn phong cách, màu sắc, hình ảnh bạn mong muốn mà không cần đến kỹ năng thiết kế phức tạp.
                                    </div>
                                </div>
                            </div>
                            <div class="whyus-item uk-clearfix">
                                <div class="icon">02</div>
                                <div class="info">
                                    <h3 class="title">Tối ưu hiển thị trên nhiều thiết bị</h3>
                                    <div class="description">
                                        Website tối ưu hiển thị trên nhiều thiết bị Laptop, Máy tính bảng hay Điện thoại. 
                                        Thông tin doanh nghiệp, hình ảnh sản phẩm được hiển thị với bố cục bắt mắt, dễ thao tác xem, tìm kiếm sản phẩm và mua hàng.
                                    </div>
                                </div>
                            </div>
                            <div class="whyus-item uk-clearfix">
                                <div class="icon">03</div>
                                <div class="info">
                                    <h3 class="title">Tốc độ load nhanh, miễn phí hosting, bảo mật SSL</h3>
                                    <div class="description">
                                        HT Việt Nam cung cấp hosting miễn phí với tốc độ load web nhanh, băng thông không giới hạn. 
                                        Miễn phí bảo mật SSL giúp bảo vệ website và khách hàng của bạn.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-large-1-2">
                    {{-- <lottie-player src="https://lottie.host/a51827b4-c698-4cad-aa01-2a46968b4c90/lKyLGQB3ZB.json" background="transparent" speed="1" style="width: 100%;height: 100%" loop="" autoplay=""></lottie-player> --}}
                    <lottie-player src="https://lottie.host/ca57390d-70b9-4333-b2f2-4f465db1cfa2/NeEadUlzgA.json" background="transparent" speed="1" style="width: 100%; height: 100%;" loop="" autoplay=""></lottie-player>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-staff">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium uk-flex uk-flex-middle">
                <div class="uk-width-large-1-2">
                    <lottie-player src="https://lottie.host/c3b4ff4e-7823-4cd8-85a2-266b71d49c22/T1wUNBCS7U.json" background="transparent" speed="1" style="width: 100%;height: 100%" loop="" autoplay=""></lottie-player>

                </div>
                <div class="uk-width-large-1-2">
                    <div class="staff-container">
                        <div class="special-heading">Đội ngũ nhân sự</div>
                        <div class="main-heading">Giải pháp toàn diện cho mọi yêu cầu thiết kế Website</div>
                        <div class="description">
                            Chúng tôi là một đội ngũ trẻ nhưng giàu kinh nghiệm và đam mê với công việc phát triển website. Với nhiều năm hợp tác với các danh nghiệp và tập đoàn
                        </div>
                        <ul class="uk-list uk-clearfix">
                            <li>
                                <img src="{{ asset('frontend/resources/img/slide/check.png') }}" alt="">
                                <span>Phân tích và thiết kế đa dạng theo yêu cầu khách hàng</span>
                            </li>
                            <li>
                                <img src="{{ asset('frontend/resources/img/slide/check.png') }}" alt="">
                                <span>Tối ưu tốc độ tải trang (thời gian, dung lượng, số lượng Request)</span>
                            </li>
                            <li>
                                <img src="{{ asset('frontend/resources/img/slide/check.png') }}" alt="">
                                <span>Tích hợp và xử lý dữ liệu thông minh</span>
                            </li>
                            <li>
                                <img src="{{ asset('frontend/resources/img/slide/check.png') }}" alt="">
                                <span>Tương thích đa thiết bị (Mobile, Tablet, Desktop)</span>
                            </li>
                            <li>
                                <img src="{{ asset('frontend/resources/img/slide/check.png') }}" alt="">
                                <span>Bảo mật, sao lưu dữ liệu hiệu quả</span>
                            </li>
                        </ul>
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
    @if(count($slides['banner-1']['item']))
    <div class="panel-partner">
        <div class="uk-container uk-container-center">
            <div class="panel-head uk-text-center">
                <div class="small-text">HT VIỆT NAM</div>
                <h2 class="heading-10"><span>Khách Hàng của chúng tôi</span></h2>
            </div>
            <div class="panel-body">
                <div class="uk-grid uk-grid-medium">
                    @foreach($slides['banner-1']['item'] as $key => $val)
                    @if($key > 19) @break @endif
                    <div class="uk-width-1-2 uk-width-large-1-10 mb20">
                        <div class="partner-item">
                            <a href="{{ $val['canonical'] }}" title="{{ $val['title'] ?? 'partner' }}" class="image img-scaledown img-zoomin">
                                <div class="skeleton-loading"></div>
                                <img class="lazy-image loaded" data-src="{{ $val['image'] }}" alt="partner">
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
