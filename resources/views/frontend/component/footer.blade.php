<footer class="footer">
    <div class="uk-container uk-container-center">
        <div class="footer-upper footer-support">
            <h2 class="footer-heading">Chúng tôi hỗ trợ khách hàng 7 ngày trong tuần với Hotline</h2>
            <ul class="uk-grid uk-grid-medium uk-grid-width-1-1 uk-grid-width-medium-1-3 list">
                <li>
                    <div class="box">
                        <span class="label">Tư vấn thiết kế web</span>
                        <a class="value" href="tel: {{ $system['contact_phone'] }}" title="Tư vấn thiết kế web">{{ $system['contact_phone'] }}</a>
                    </div>
                </li>
                <li>
                    <div class="box">
                        <span class="label">Hỗ trợ kỹ thuật</span>
                        <a class="value" href="tel: {{ $system['contact_hotline'] }}" title="Tư vấn thiết kế web">{{ $system['contact_hotline'] }}</a>
                    </div>
                </li>
                <li>
                    <div class="box">
                        <span class="label">Gửi yêu cầu làm web</span>
                        <a class="value" href="mailto: {{ $system['contact_email'] }}" title="Tư vấn thiết kế web">{{ $system['contact_email'] }}</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="footer-lower">
            <div class="footer-heading">Công ty cổ phần xây dựng và công nghệ HT Việt Nam</div>
            <div class="uk-grid uk-grid-large">
                <div class="uk-width-large-1-3">
                    <div class="footer-address">
                        <div class="footer-address-official">Văn phòng Hà Nội</div>
                        <div class="info">
                            <div>- Địa chỉ: {{ $system['contact_office'] }}</div>
                            <div>- Số Điện thoại: {{ $system['contact_phone'] }} - Hotline: {{ $system['contact_hotline'] }}</div>
                            <div>- Email: {{ $system['contact_email'] }}</div>
                            <div>- Website: https://webchuanseoht.com/</div>
                            <div>- {!! $system['homepage_đkkd'] !!}</div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-large-1-3">
                    <div class="footer-address">
                        <div class="footer-address-official">Văn phòng Hồ Chí Minh</div>
                        <div class="info">
                            <div>- Địa chỉ: {{ $system['hcm_office'] }}</div>
                            <div>- Số Điện thoại: {{ $system['contact_phone'] }} - Hotline: {{ $system['contact_hotline'] }}</div>
                            <div>- Email: {{ $system['contact_email'] }}</div>
                            <div>- Website: https://webchuanseoht.com/</div>
                            <div>- 	0107813329-001</div>
                        </div>
                    </div>
                </div>
                {{-- @dd($menu) --}}
                <div class="uk-width-large-1-3">
                    <div class="footer-menu">
                        <div class="uk-grid uk-grid-medium">
                            @foreach($menu['footer-menu'] as $item)
                            @php
                                $name = $item['item']->languages()->first()->pivot->name;
                            @endphp
                            <div class="uk-width-large-1-2">
                                <div class="footer-menu-item">
                                    <div class="menu-heading">{{ $name }}</div>
                                    <ul class="uk-list uk-clearfix">
                                        @foreach($item['children'] as $key => $child)
                                         @php
                                            $nameC = $child['item']->languages()->first()->pivot->name;
                                            $canonical = write_url($child['item']->languages()->first()->pivot->canonical);
                                        @endphp

                                        <li><a href="{{ $canonical }}">- {{ $nameC }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="copyright">
    <div class="uk-text-center">
        {{ $system['homepage_copyright'] }}
    </div>
</div>

<div id="video-modal" class="uk-modal">
    <div class="uk-modal-dialog">
        {!! $system['homepage_video_youtube_pc'] !!}
    </div>
</div>