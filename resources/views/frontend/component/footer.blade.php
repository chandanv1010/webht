<footer class="footer">
    <div class="uk-container uk-container-center">
        <div class="footer-upper footer-support">
            <h2 class="footer-heading">Chúng tôi hỗ trợ khách hàng 7 ngày trong tuần với Hotline</h2>
            <ul class="uk-grid uk-grid-medium uk-grid-width-1-1 uk-grid-width-medium-1-3 list">
                <li>
                    <div class="box">
                        <span class="label">Tư vấn thiết kế web</span>
                        <a class="value" href="{{ tel_href($system['contact_phone']) }}" title="Tư vấn thiết kế web">{{ $system['contact_phone'] }}</a>
                    </div>
                </li>
                <li>
                    <div class="box">
                        <span class="label">Hỗ trợ kỹ thuật</span>
                        <a class="value" href="{{ tel_href($system['contact_hotline']) }}" title="Tư vấn thiết kế web">{{ $system['contact_hotline'] }}</a>
                    </div>
                </li>
                <li>
                    <div class="box">
                        <span class="label">Gửi yêu cầu làm web</span>
                        <a class="value" href="mailto:{{ $system['contact_email'] }}" title="Tư vấn thiết kế web">{{ $system['contact_email'] }}</a>
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
                            {{-- ->languages, not ->languages(): with the parentheses this
                                 calls the relation method, which builds a brand new query
                                 and ignores the rows MenuComposer already eager-loaded.
                                 It ran three times per child link, which is where 26 of the
                                 27 menu_language queries on every page came from. --}}
                            @foreach($menu['footer-menu'] as $item)
                            @php
                                $name = $item['item']->languages->first()->pivot->name;
                            @endphp
                            <div class="uk-width-large-1-2">
                                <div class="footer-menu-item">
                                    <div class="menu-heading">{{ $name }}</div>
                                    <ul class="uk-list uk-clearfix">
                                        @foreach($item['children'] as $key => $child)
                                         @php
                                            $childPivot = $child['item']->languages->first()->pivot;
                                            $nameC = $childPivot->name;
                                            $canonical = write_url($childPivot->canonical);
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

{{-- The player is built when the modal opens. A hidden iframe still loads, so this
     block used to fetch a YouTube frame on every page of the site for a modal almost
     nobody opens. --}}
@php
    $footerVideoId = null;
    if (preg_match('~(?:embed/|v=|youtu\.be/)([A-Za-z0-9_-]{6,})~', (string) ($system['homepage_video_youtube_pc'] ?? ''), $m)) {
        $footerVideoId = $m[1];
    }
@endphp
@if ($footerVideoId)
<div id="video-modal" class="uk-modal" data-video-modal="{{ $footerVideoId }}">
    <div class="uk-modal-dialog"></div>
</div>
<script>
(function () {
    var modal = document.getElementById('video-modal');
    if (!modal) return;

    var dialog = modal.querySelector('.uk-modal-dialog');
    var id = modal.getAttribute('data-video-modal');

    function build() {
        if (dialog.querySelector('iframe')) return;
        var frame = document.createElement('iframe');
        frame.src = 'https://www.youtube-nocookie.com/embed/' + id + '?autoplay=1&rel=0';
        frame.width = '100%';
        frame.height = '520';
        frame.title = 'Video';
        frame.allow = 'accelerometer; autoplay; encrypted-media; picture-in-picture';
        frame.allowFullscreen = true;
        frame.style.border = '0';
        dialog.appendChild(frame);
    }

    // Anything that opens this modal, however it does it.
    document.addEventListener('click', function (e) {
        var t = e.target.closest('[href="#video-modal"], [data-uk-modal]');
        if (t) setTimeout(build, 30);
    });

    // And stop the sound when it closes.
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.uk-modal-close') && e.target !== modal) return;
        var frame = dialog.querySelector('iframe');
        if (frame) frame.remove();
    });
})();
</script>
@endif