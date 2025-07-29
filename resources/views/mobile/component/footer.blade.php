{{-- <footer class="footer">
    <div class="panel-official">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-large">
                <div class="uk-width-large-1-2">
                    <div class="official-item">
                        <div class="panel-head">
                            Văn Phòng Hà Nội
                        </div>
                        <div class="panel-body">
                            <div class="row uk-clearfix">
                                <span class="label"><i class="fa fa-home"></i>Địa chỉ:</span>
                                <span class="value">{{ $system['contact_office'] }}</span>
                            </div>
                            <div class="row uk-clearfix">
                                <span class="label"><i class="fa fa-phone"></i>Điện thoại: </span>
                                <span class="value">{{ $system['contact_hotline'] }}</span>
                            </div>
                            <div class="row uk-clearfix">
                                <span class="label"><i class="fa fa-envelope"></i>Email: </span>
                                <span class="value">{{ $system['contact_email'] }}</span>
                            </div>
                            <div class="row uk-clearfix">
                                <span class="label"><i class="fa fa-university" aria-hidden="true"></i>Xưởng SX:</span>
                                <span class="value">{{ $system['contact_xuong'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-large-1-2">
                    <div class="official-item">
                        <div class="panel-head">
                            Văn Phòng Hồ Chí Minh
                        </div>
                        <div class="panel-body">
                            <div class="row uk-clearfix">
                                <span class="label"><i class="fa fa-home"></i>Địa chỉ:</span>
                                <span class="value">{{ $system['hcm_office'] }}</span>
                            </div>
                            <div class="row uk-clearfix">
                                <span class="label"><i class="fa fa-phone"></i>Điện thoại: </span>
                                <span class="value">{{ $system['hcm_hotline'] }}</span>
                            </div>
                            <div class="row uk-clearfix">
                                <span class="label"><i class="fa fa-envelope"></i>Email: </span>
                                <span class="value">{{ $system['hcm_email'] }}</span>
                            </div>
                            <div class="row uk-clearfix">
                                <span class="label"><i class="fa fa-university" aria-hidden="true"></i>Xưởng SX:</span>
                                <span class="value">{{ $system['hcm_xuong'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-footer">
        <div class="uk-container uk-container-center">
            <div class="main-footer-container">
                <div class="footer-contact">
                    <div class="footer-heading">{{ $system['homepage_company'] }}</div>
                    <div class="footer-row">
                        <strong>Giấy phép kinh doanh số</strong>
                        <p>0107017623 do phòng Kinh doanh sở KH&ĐT TP.Hà NộiCấp ngày: 06/10/2015</p>
                    </div>
                    <div class="footer-row">
                        <strong>Ngân hàng BIDV: Trần Đăng Dũng</strong>
                        <p>1991.0000.263.050</p>
                    </div>
                    <div class="footer-row">
                        <strong>Techcombank: Trần Đăng Dũng</strong>
                        <p>1902.3397.720.013</p> 
                    </div>
                    <div class="footer-row">
                        <strong>Mở cửa:  </strong>
                        <p>8h30 - 20h30 cả thứ 7 và CN, có vị trí đậu xe ôtô</p>
                    </div>
                    <div class="footer-social">
                        <div class="uk-flex uk-flex-middle">
                            <a href="{{ $system['social_facebook'] }}" class="social-item"><i class="fa fa-facebook"></i></a>
                            <a href="{{ $system['social_twitter'] }}" class="social-item"><i class="fa fa-twitter"></i></a>
                            <a href="{{ $system['social_instagram'] }}" class="social-item"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="footer-menu">
                    <div class="uk-grid uk-grid-medium">
                        @foreach($menu['footer-menu'] as $key => $val)
                        @php
                            $nameC = $val['item']->languages->first()->pivot->name;
                        @endphp
                        <div class="uk-width-medium-1-2">
                            <div class="menu-item">
                                <div class="menu-heading">{{ $nameC }}</div>
                                @if($val['children'] && count($val['children']))
                                <ul class="uk-list uk-clearfix">
                                    @foreach($val['children'] as $keyChild => $valChild)
                                    @php
                                        $name = $valChild['item']->languages->first()->pivot->name;
                                        $canonical = $valChild['item']->languages->first()->pivot->canonical;
                                    @endphp
                                    <li><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="footer-network">
                    <div class="menu-heading">Fanpage</div>
                    <div class="footer-logo mb20">
                        <a href="." class="image"><img src="{{ asset('frontend/resources/img/footer-logo.png') }}" alt="Logo Footer"></a>
                    </div>
                    <div class="page" style="padding:0;">
                        <div class="fb-page" data-href="<?php echo $system['social_facebook'] ?>" data-tabs="" data-width="400" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo $system['social_facebook'] ?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $system['social_facebook'] ?>">Facebook</a></blockquote></div>
                    </div>
                    <div class="text-contact">
                        Quý khách hàng liên hệ phản ánh về chất lượng dịch vụ theo số hotline: 0904.922.223
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="uk-container uk-container-center">
            <div class="uk-text-center">
                Bản quyền thuộc về <strong>CÔNG TY SẢN XUẤT NỘI THẤT AN HƯNG</strong>. Mọi sự sao chép đều phải ghi nguồn và được sự cho phép bằng văn bản của chúng tôi.
            </div>
        </div>
    </div>
    <div class="button-fixed">
        <ul class="uk-clearfix uk-flex uk-flex-middle uk-flex-space-between">
            <li>
                <a href="{{ $system['social_zalo'] }}">
                    <img src="/userfiles/image/logo/zalo.png" alt="">
                    <span>Zalo</span>
                </a>
            </li>
            <li>
                <a href="{{ $system['contact_hotline'] }}">
                    <img src="/userfiles/image/logo/advise.png" alt="">
                    <span>Tư vấn</span>
                </a>
            </li>
            <li>
                <a href="{{ $system['contact_map'] }}">
                    <img src="/userfiles/image/logo/location.png" alt="">
                    <span>Vị trí</span>
                </a>
            </li>
            <li>
                <a href="{{ $system['social_messenger'] }}">
                    <img src="/userfiles/image/logo/mess.webp" alt="">
                    <span>Messenger</span> 
                </a>
            </li>
            <li>
                <a href="{{ $system['contact_hotline'] }}">
                    <img src="/userfiles/image/logo/phone.webp">
                    <span>Gọi điện</span>
                </a>
            </li>
        </ul>
    </div>
</footer> --}}
<footer class="_footer">
    <div class="panel-advise">
        <div class="uk-container uk-container-center">
            <div class="wrapper">
                <p>
                    {{ $system['text_1'] }}
                </p>
                <p class="strong">
                    {!! $system['text_2'] !!}
                </p>
                <form action="">
                    <input type="text" class="mb20" name="phone" placeholder="Nhập SĐT nhận ưu đãi">
                    <button type="submit">Đăng ký</button>
                </form>
            </div>
        </div>
    </div>
    <div class="main-footer">
        <div class="uk-container uk-container-center">
            <div class="main-footer-container">
                <div class="footer-menu">
                    <div class="uk-grid uk-grid-medium">
                        @foreach($menu['footer-menu'] as $key => $val)
                        @php
                            $nameC = $val['item']->languages->first()->pivot->name;
                        @endphp
                        <div class="uk-width-medium-1-3">
                            <div class="menu-item">
                                <div class="menu-heading">{{ $nameC }}</div>
                                @if($val['children'] && count($val['children']))
                                    <ul class="uk-list uk-clearfix">
                                        @foreach($val['children'] as $keyChild => $valChild)
                                        @php
                                            $name = $valChild['item']->languages->first()->pivot->name;
                                            $canonical = write_url($valChild['item']->languages->first()->pivot->canonical);
                                        @endphp
                                        <li><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="footer-network">
                    <div class="page" style="padding:0;">
                        <div class="fb-page" data-href="<?php echo $system['social_facebook'] ?>" data-tabs="" data-width="400" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo $system['social_facebook'] ?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $system['social_facebook'] ?>">Facebook</a></blockquote></div>
                    </div>
                </div>
                <div class="panel-offical" id="system">
                    @if(isset($widgets['showroom-system']))
                        @foreach($widgets['showroom-system']->object as $key => $val)
                            <div class="showroom-sys">
                                <div class="panel-head">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 576 512" class="w-7 h-7 fill-light"><path d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40h-16c-1.1 0-2.2 0-3.3-.1-1.4.1-2.8.1-4.2.1H392c-22.1 0-40-17.9-40-40v-88c0-17.7-14.3-32-32-32h-64c-17.7 0-32 14.3-32 32v88c0 22.1-17.9 40-40 40h-55.9c-1.5 0-3-.1-4.5-.2-1.2.1-2.4.2-3.6.2h-16c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9.1-2.8v-69.6H32c-18 0-32-14-32-32.1 0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7l255.4 224.5c8 7 12 15 11 24"></path></svg>
                                    <h3 class="heading-2">
                                        <span>{{ $widgets['showroom-system']->name }}</span>
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    @foreach($val->posts as $k => $post)
                                        <div class="showroom-item">
                                            @php
                                                $name = $post->languages[0]->name;
                                                $description = $post->languages[0]->description;
                                            @endphp
                                            <p class="name">
                                                {{ $name }}
                                            </p>
                                            {!! $description !!}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="info-contact">
                    <p class="name_company">
                        {{ $system['homepage_company'] }}
                    </p>
                    <p class="hotline">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M375.8 275.2c-16.4-7-35.4-2.4-46.7 11.4l-33.2 40.6c-46-26.7-84.4-65.1-111.1-111.1l40.5-33.1c13.8-11.3 18.5-30.3 11.4-46.7l-48-112C181.2 6.7 162.3-3.1 143.6.9l-112 24C13.2 28.8 0 45.1 0 64c0 231.2 175.2 421.6 400.1 445.5 9.8 1 19.6 1.8 29.6 2.2h.1c6.1.2 12.1.4 18.2.4 18.9 0 35.2-13.2 39.1-31.6l24-112c4-18.7-5.8-37.6-23.4-45.1l-112-48zM441.5 464c-215.7-3.5-390-177.8-393.4-393.5l99.2-21.3 43 100.4-35.9 29.4c-18.2 14.9-22.9 40.8-11.1 61.2 30.9 53.3 75.3 97.7 128.6 128.6 20.4 11.8 46.3 7.1 61.2-11.1l29.4-35.9 100.4 43zM48 64"></path>
                        </svg>
                        <a href="tel:{{ $system['contact_hotline'] }}">{{ $system['contact_hotline'] }}</a>
                    </p>
                    <p class="mail">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 512 512"><path d="M64 112c-8.8 0-16 7.2-16 16v22.1l172.5 141.6c20.7 17 50.4 17 71.1 0L464 150.1V128c0-8.8-7.2-16-16-16zM48 212.2V384c0 8.8 7.2 16 16 16h384c8.8 0 16-7.2 16-16V212.2L322 328.8c-38.4 31.5-93.7 31.5-132 0zM0 128c0-35.3 28.7-64 64-64h384c35.3 0 64 28.7 64 64v256c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64z"></path></svg>
                        <a href="mailto:{{ $system['contact_email'] }}">{{ $system['contact_email'] }}</a>
                    </p>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 384 512">
                            <path d="M48 448V64c0-8.8 7.2-16 16-16h160v80c0 17.7 14.3 32 32 32h80v288c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16M64 0C28.7 0 0 28.7 0 64v384c0 35.3 28.7 64 64 64h256c35.3 0 64-28.7 64-64V154.5c0-17-6.7-33.3-18.7-45.3l-90.6-90.5C262.7 6.7 246.5 0 229.5 0zm32 96c-8.8 0-16 7.2-16 16s7.2 16 16 16h80c8.8 0 16-7.2 16-16s-7.2-16-16-16zm0 64c-8.8 0-16 7.2-16 16s7.2 16 16 16h80c8.8 0 16-7.2 16-16s-7.2-16-16-16zm54.2 221.8L160 349l16.7 55.6c1.9 6.3 7.4 10.8 13.9 11.3s12.8-2.9 15.7-8.8l10.6-21.3c.6-1.2 1.8-1.9 3.1-1.9s2.5.7 3.1 1.9l10.6 21.3c2.7 5.4 8.3 8.8 14.3 8.8h40c8.8 0 16-7.2 16-16s-7.2-16-16-16h-30.1l-6.2-12.4c-6-12-18.3-19.6-31.7-19.6-8.6 0-16.8 3.1-23.1 8.6L185.6 323c-3.4-11.3-13.8-19-25.6-19s-22.2 7.7-25.6 19.1l-14.9 49.5c-2 6.8-8.3 11.4-15.3 11.4H96c-8.8 0-16 7.2-16 16s7.2 16 16 16h8.2c21.2 0 39.9-13.9 46-34.2"></path>
                        </svg>
                        <a href="">Số ĐKKD: {{ $system['homepage_đkkd'] }}</a>
                    </p>
                </div>
                <div class="certificate">
                    <div class="uk-flex uk-flex-middle mb10">
                        @if(!is_null($system['image_1']))
                            <a href="" class="image img-scaledown">
                                <img src="{{ $system['image_1'] }}" alt="">
                            </a>
                        @endif
                        @if(!is_null($system['image_2']))
                            <a href="" class="image img-scaledown">
                                <img src="{{ $system['image_2'] }}" alt="">
                            </a>
                        @endif
                    </div>
                    <p class="copyright">
                        {{ $system['homepage_copyright'] }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="button-fixed">
        <ul class="uk-clearfix uk-flex uk-flex-middle uk-flex-space-between">
            <li>
                <a href="https://zalo.me/{{ $system['social_zalo'] }}" target="_blank">
                    <img src="/userfiles/image/logo/zalo.png" alt="">
                    <span>Zalo</span>
                </a>
            </li>
            <li>
                <a href="{{ $system['contact_hotline'] }}" data-uk-modal="{target:'#advise'}">
                    <img src="/userfiles/image/logo/advise.png" alt="">
                    <span>Tư vấn</span>
                </a>
                @include('frontend.component.advise')
            </li>
            <li>
                <a href="#system">
                    <img src="/userfiles/image/logo/location.png" alt="">
                    <span>Vị trí</span>
                </a>
            </li>
            <li>
                <a href="https://m.me/{{ $system['social_messenger'] }}" target="_blank">
                    <img src="/userfiles/image/logo/mess.webp" alt="">
                    <span>Messenger</span> 
                </a>
            </li>
            <li>
                <a href="tel:{{ $system['contact_hotline'] }}">
                    <img src="/userfiles/image/logo/phone.webp">
                    <span>Gọi điện</span>
                </a>
            </li>
        </ul>
    </div>
</footer>
<div id="fb-root"></div>
<script 
    async defer crossorigin="anonymous" 
    src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v22.0&appId=103609027035330">
</script>
