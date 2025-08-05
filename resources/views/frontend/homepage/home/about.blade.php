@extends('frontend.homepage.layout')

@section('content')
   <div class="about-container">
        <div class="about-banner">
            <div class="banner-overlay uk-text-center">
                <h2 class="main-title"><span>Đơn giản</span> để bắt đầu</h2>
                <div class="sub-title">Mạnh mẽ <span>để phát triển</span></div>
            </div>
            <div class="about-button-group">
                <div class="uk-flex uk-flex-middle  uk-flex-center">
                    <a href="{{ write_url('lien-he') }}" class="btn-about-item">
                        Liên hệ ngay
                    </a>
                    <a href=""  class="btn-about-item">
                        Hotline: {{ $system['contact_hotline'] }}
                    </a>
                </div>
            </div>
            <div class="about-banner-image">
                <lottie-player src="https://lottie.host/e1c1bcc6-6c8f-42d5-8a99-7f0984cafac8/ml2GixAWGc.json" background="transparent" speed="1" style="width: 100%;height: 100%" loop="" autoplay=""></lottie-player>
            </div>
        </div>
        <div class="uk-container uk-container-center">
            @if(count($slides['banner-1']['item']))
            <div class="panel-partner">
                <div class="uk-container uk-container-center">
                    <div class="panel-head uk-text-center">
                        <div class="small-text">Hơn 600+</div>
                        <h2 class="heading-10"><span>Khách Hàng tin tưởng</span></h2>
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
        </div>
        <div class="panel-intro-service">
            <div class="uk-container uk-container-center">
                <div class="panel-head uk-text-center mb50">
                    <h2 class="heading-9"><span>Dịch vụ của chúng tôi</span></h2>
                </div>
                <div class="panel-body">
                    <div class="uk-grid uk-grid-medium">
                        <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-4">
                            <div class="about-service-item">
                                <div class="icon"> <img src="{{ asset('frontend/resources/img/coding.png') }}" alt=""></div>
                                <h3 class="title"><span>Thiết kế website</span></h3>
                                <div class="description">
                                    Thiết kế Website đẹp, sáng tạo, mã nguồn riêng biệt, chuẩn SEO, Chuẩn Mobile
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-4">
                            <div class="about-service-item">
                                <div class="icon"> <img src="{{ asset('frontend/resources/img/booking.png') }}" alt=""></div>
                                <h3 class="title"><span>Thiết kế App Mobile</span></h3>
                                <div class="description">
                                    Chúng tôi tạo ra các sản phẩm App Mobile ấn tượng, và đạt chất lượng cao
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-4">
                            <div class="about-service-item">
                                <div class="icon"> <img src="{{ asset('frontend/resources/img/adwords.png') }}" alt=""></div>
                                <h3 class="title"><span>Quảng cáo Google</span></h3>
                                <div class="description">
                                    HT Việt Nam giúp khách hàng dễ dàng tiếp cận tới khách hàng bằng dịch vụ quảng cáo google hiệu quả
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-small-1-1 uk-width-medium-1-2 uk-width-large-1-4">
                            <div class="about-service-item">
                                <div class="icon"> <img src="{{ asset('frontend/resources/img/hosting.png') }}" alt=""></div>
                                <h3 class="title"><span>Hosting</span></h3>
                                <div class="description">
                                    Máy chủ sử dụng các dòng CPU thế hệ mới nhất của Intel công nghệ lưu trữ NVMe SSD U.2 - Raid 10 cực nhanh và an toàn dữ liệu cao nhất 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-best-choose">
            <div class="uk-container uk-container-center">
                <div class="uk-grid uk-grid-medium uk-flex uk-flex-middle">
                    <div class="uk-width-large-1-2">
                        <lottie-player src="https://lottie.host/968c48f5-cdbe-4b04-81b8-aa93883c6f64/ryuy8Ejutp.json" background="transparent" speed="1" style="width: 100%;height: 100%" loop="" autoplay=""></lottie-player>
                    </div>
                    <div class="uk-width-large-1-2">
                        <div class="best-choose-container">
                            <div class="special-text">Sự lựa chọn tốt nhất</div>
                            <div class="title">Trải nghiệm đội ngũ thiết kế web giàu kinh nghiệm với kỹ năng vượt trội</div>
                            <div class="description">
                                <p>
                                    <strong>1.</strong> Chúng tôi là đội ngũ trẻ, sáng tạo và giàu kinh nghiệm trong lĩnh vực thiết kế website, luôn nỗ lực mang đến các giải pháp linh hoạt phù hợp với mọi nhu cầu kinh doanh.
                                </p>

                                <p>
                                    <strong>2.</strong> Chúng tôi chuyên đánh giá cấu trúc website và thực hiện các tối ưu kỹ thuật để đảm bảo website của bạn thân thiện với công cụ tìm kiếm và đạt hiệu quả cao trên Google.
                                </p>
                                <p><strong>3.</strong> Chúng tôi vận hành hệ thống trên nền tảng Cloud nhằm mang đến giải pháp thiết kế website mạnh mẽ, ổn định và tối ưu về mặt kỹ thuật. Cam kết đem lại hiệu suất cao và trải nghiệm người dùng tốt nhất.</p>
                            </div>
                            <a href="{{ write_url('lien-he') }}" class="btn-support-button">Liên hệ ngay với chúng tôi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-about-intro panel-best-choose">
            <div class="uk-container uk-container-center">
                <div class="uk-grid uk-grid-medium uk-flex uk-flex-middle">
                    <div class="uk-width-large-1-2">
                        <div class="best-choose-container">
                            <div class="special-text">Giải pháp tốt nhất</div>
                            <div class="title">Quy trình tối ưu giúp doanh nghiệp lựa chọn giải pháp thiết kế website phù hợp nhất</div>
                            <div class="description">
                                <p>
                                    <strong>1.</strong>Tại HT Việt Nam, chúng tôi xây dựng và triển khai các giải pháp thiết kế website chuyên nghiệp trên nền tảng  Cloud, mang đến hiệu năng mạnh mẽ, bảo mật cao và khả năng mở rộng linh hoạt.
                                </p>

                                <p>
                                    <strong>2.</strong>Với quy trình làm việc rõ ràng, đội ngũ giàu kinh nghiệm và tinh thần sáng tạo, chúng tôi giúp doanh nghiệp xác định đúng nhu cầu, lựa chọn đúng công nghệ và phát triển đúng giải pháp – để website không chỉ đẹp mà còn tạo ra giá trị thật sự.
                                </p>
                            </div>
                            <a href="tel:{{ $system['contact_hotline'] }}" class="btn-support-button spec-button">Hotline: {{ $system['contact_hotline'] }}</a>
                        </div>
                    </div>
                    <div class="uk-width-large-1-2">
                        <lottie-player src="https://lottie.host/1d14b75c-337c-4468-9292-194664d159ad/Hrb7rHZG0d.json" background="transparent" speed="1" style="width: 100%;height: 100%" loop="" autoplay=""></lottie-player>
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
