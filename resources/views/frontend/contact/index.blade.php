@extends('frontend.homepage.layout')
@section('content')

{{--
    Contact page.

    The old version of this page showed a showroom grid and a "tin nổi bật" column left
    over from a furniture site, read an empty contact_intro, and had no form at all —
    someone who wanted to get in touch had nothing to fill in.

    This page has one job, so it asks for the four things needed to call someone back and
    says plainly what happens after they press send.
--}}

@php
    $hotline = $system['contact_hotline'] ?? '';
    $email = $system['contact_email'] ?? '';
    $office = trim(strip_tags($system['contact_office'] ?? ''));
    $zalo = $system['social_zalo'] ?? $hotline;
    $company = $system['homepage_company'] ?? '';

    // Google Maps search rather than an embedded map: contact_map is empty in the
    // settings, and an empty iframe is worse than a link that works.
    $mapUrl = $office !== ''
        ? 'https://www.google.com/maps/search/?api=1&query='.urlencode($office)
        : null;

    $channels = array_values(array_filter([
        $hotline !== '' ? [
            'role' => 'phone',
            'label' => 'Gọi trực tiếp',
            'value' => $hotline,
            'href' => tel_href($hotline),
            'note' => 'Nhanh nhất. Trong giờ hành chính luôn có người nhấc máy.',
        ] : null,
        $zalo !== '' ? [
            'role' => 'chat',
            'label' => 'Zalo',
            'value' => $zalo,
            'href' => 'https://zalo.me/'.preg_replace('/\D+/', '', $zalo),
            'note' => 'Gửi được ảnh và bản mô tả. Trả lời trong ngày.',
        ] : null,
        $email !== '' ? [
            'role' => 'email',
            'label' => 'Email',
            'value' => $email,
            'href' => 'mailto:'.$email,
            'note' => 'Dùng khi cần gửi tài liệu hoặc yêu cầu báo giá bằng văn bản.',
        ] : null,
        $office !== '' ? [
            'role' => 'place',
            'label' => 'Văn phòng',
            'value' => $office,
            'href' => $mapUrl,
            'note' => 'Ghé qua thì hẹn trước một hôm để chúng tôi chuẩn bị.',
        ] : null,
    ]));
@endphp

<div class="store store-page contact-page">

    {{-- ── Header ────────────────────────────────────────────────── --}}
    <section class="store-hero contact-hero">
        <div class="uk-container uk-container-center">
            <div class="contact-hero__inner">
                <p class="store-hero__eyebrow">Liên hệ</p>
                <h1 class="article-title">Nói chuyện với người sẽ làm website của bạn</h1>
                <p class="article-lead">Không qua tổng đài, không chuyển máy. Bạn gọi hoặc để lại số, người trực tiếp làm dự án sẽ trao đổi với bạn về phạm vi, thời gian và chi phí.</p>
            </div>
        </div>
    </section>

    {{-- ── Channels ─────────────────────────────────────────────── --}}
    @if (count($channels))
        <section class="contact-channels">
            <div class="uk-container uk-container-center">
                <ul class="contact-channels__grid">
                    @foreach ($channels as $channel)
                        <li class="contact-channel contact-channel--{{ $channel['role'] }}">
                            {{-- Small line icons drawn here rather than pulled from the
                                 illustration component: that family is 480×360 scene art,
                                 far too large for a card this size. --}}
                            <span class="contact-channel__icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    @switch($channel['role'])
                                        @case('phone')
                                            <path d="M4.5 3.5h3l1.6 4-2 1.4a11.5 11.5 0 0 0 6 6l1.4-2 4 1.6v3a1.5 1.5 0 0 1-1.7 1.5C9.7 18.3 5.7 14.3 3 6.2A1.5 1.5 0 0 1 4.5 3.5Z"/>
                                            @break
                                        @case('chat')
                                            <path d="M20 12a7.5 7.5 0 0 1-7.5 7.5 8 8 0 0 1-3.2-.66L4.5 20l1.2-3.5A7.5 7.5 0 1 1 20 12Z"/>
                                            <path d="M9 11h6M9 14h3.5"/>
                                            @break
                                        @case('email')
                                            <rect x="3.2" y="5.5" width="17.6" height="13" rx="2.5"/>
                                            <path d="m3.9 7.4 7.1 5.3a1.7 1.7 0 0 0 2 0l7.1-5.3"/>
                                            @break
                                        @default
                                            <path d="M12 21s6.5-6.1 6.5-10.5a6.5 6.5 0 1 0-13 0C5.5 14.9 12 21 12 21Z"/>
                                            <circle cx="12" cy="10.3" r="2.4"/>
                                    @endswitch
                                </svg>
                            </span>

                            <p class="contact-channel__label">{{ $channel['label'] }}</p>

                            @if ($channel['href'])
                                <a class="contact-channel__value" href="{{ $channel['href'] }}"
                                   @if (str_starts_with($channel['href'], 'http')) target="_blank" rel="noopener" @endif>
                                    {{ $channel['value'] }}
                                </a>
                            @else
                                <span class="contact-channel__value">{{ $channel['value'] }}</span>
                            @endif

                            <p class="contact-channel__note">{{ $channel['note'] }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    {{-- ── Form ─────────────────────────────────────────────────── --}}
    <section class="contact-main" id="gui-yeu-cau">
        <div class="uk-container uk-container-center">
            <div class="contact-layout">

                <div class="contact-formwrap">
                    <h2 class="contact-formwrap__title">Để lại yêu cầu</h2>
                    <p class="contact-formwrap__sub">Hai ô đầu là bắt buộc. Phần còn lại giúp chúng tôi chuẩn bị trước, nên cuộc gọi đầu tiên đi vào việc thay vì hỏi lại từ đầu.</p>

                    <form class="contact-form tpl-form" action="{{ route('fe.contact.advise') }}" method="post" data-lead>
                        @csrf

                        <div class="contact-form__row">
                            <div class="contact-field">
                                <label for="c-name">Họ và tên <span aria-hidden="true">*</span></label>
                                <input id="c-name" type="text" name="name" required autocomplete="name">
                            </div>
                            <div class="contact-field">
                                <label for="c-phone">Số điện thoại <span aria-hidden="true">*</span></label>
                                <input id="c-phone" type="tel" name="phone" required autocomplete="tel"
                                       inputmode="tel" pattern="[0-9+ ().-]{9,}">
                            </div>
                        </div>

                        <div class="contact-form__row">
                            <div class="contact-field">
                                <label for="c-email">Email</label>
                                <input id="c-email" type="email" name="email" autocomplete="email">
                            </div>
                            <div class="contact-field">
                                <label for="c-service">Bạn đang cần</label>
                                <select id="c-service" name="address">
                                    <option value="">Chưa rõ, cần tư vấn</option>
                                    <option value="Thiết kế website theo yêu cầu">Thiết kế website theo yêu cầu</option>
                                    <option value="Website mẫu có sẵn">Website mẫu có sẵn</option>
                                    <option value="Chăm sóc website">Chăm sóc website</option>
                                    <option value="Hosting &amp; tên miền">Hosting &amp; tên miền</option>
                                    <option value="Dịch vụ SEO">Dịch vụ SEO</option>
                                    <option value="Việc khác">Việc khác</option>
                                </select>
                            </div>
                        </div>

                        <div class="contact-field">
                            <label for="c-content">Mô tả ngắn</label>
                            <textarea id="c-content" name="content" rows="5"
                                      placeholder="Bạn bán gì, khách của bạn là ai, và website cần làm được việc gì. Hai ba câu là đủ."></textarea>
                        </div>

                        <button type="submit" class="store-btn store-btn--primary contact-form__submit">Gửi yêu cầu</button>
                        <p class="tpl-form__msg" data-msg role="status" aria-live="polite"></p>
                        <p class="contact-form__fine">Chúng tôi dùng thông tin này để liên hệ về yêu cầu của bạn, không dùng cho việc khác và không chuyển cho bên thứ ba.</p>
                    </form>
                </div>

                <aside class="contact-side">
                    <div class="contact-card">
                        <h2 class="contact-card__title">Sau khi bạn gửi</h2>
                        {{-- Numbered because this genuinely is a sequence: each step happens
                             after the one before it, and the reader is waiting for step 1. --}}
                        <ol class="contact-steps">
                            <li>
                                <p class="contact-steps__when">Trong 1 giờ làm việc</p>
                                <p class="contact-steps__what">Chúng tôi gọi lại để hỏi rõ phạm vi. Cuộc gọi này thường 10–15 phút.</p>
                            </li>
                            <li>
                                <p class="contact-steps__when">Trong 1–2 ngày</p>
                                <p class="contact-steps__what">Bạn nhận đề xuất bằng văn bản: hạng mục, thời gian, chi phí, và những gì không nằm trong phạm vi.</p>
                            </li>
                            <li>
                                <p class="contact-steps__when">Khi bạn đồng ý</p>
                                <p class="contact-steps__what">Ký hợp đồng và bắt đầu. Nếu bạn không đồng ý, chúng tôi không gọi lại lần thứ hai.</p>
                            </li>
                        </ol>
                    </div>

                    <div class="contact-card">
                        <h2 class="contact-card__title">Giờ làm việc</h2>
                        <dl class="contact-hours">
                            <div><dt>Thứ 2 – Thứ 6</dt><dd>8:00 – 17:30</dd></div>
                            <div><dt>Thứ 7</dt><dd>8:00 – 12:00</dd></div>
                            <div><dt>Chủ nhật</dt><dd>Nghỉ</dd></div>
                        </dl>
                        <p class="contact-card__note">Sự cố khiến website không truy cập được thì gọi bất cứ lúc nào, kể cả ngoài giờ.</p>
                    </div>

                    @if ($company !== '')
                        <div class="contact-card contact-card--quiet">
                            <h2 class="contact-card__title">Đơn vị</h2>
                            <p class="contact-card__body">{{ $company }}</p>
                            @if ($office !== '')
                                <p class="contact-card__body">{{ $office }}</p>
                            @endif
                            @if (!empty($system['contact_tax']))
                                <p class="contact-card__body">Mã số thuế: {{ strip_tags($system['contact_tax']) }}</p>
                            @endif
                            @if ($mapUrl)
                                <a class="contact-card__link" href="{{ $mapUrl }}" target="_blank" rel="noopener">Xem trên bản đồ</a>
                            @endif
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>

    {{-- ── Before you write ─────────────────────────────────────── --}}
    <section class="contact-faq">
        <div class="uk-container uk-container-center">
            <h2 class="store-shelf__title">Ba câu hỏi trả lời trước để bạn không phải hỏi</h2>

            <div class="contact-faq__grid tpl-prose">
                <div>
                    <h3>Chưa có nội dung và hình ảnh thì làm được không?</h3>
                    <p>Được. Chúng tôi dựng bằng nội dung mẫu rồi thay dần. Nhưng phần văn bản chính nên do bạn viết vì bạn hiểu khách của mình nhất, chúng tôi biên tập lại.</p>
                </div>
                <div>
                    <h3>Ngân sách của tôi thấp thì có nên gọi?</h3>
                    <p>Nên. Nếu ngân sách chưa đủ cho thứ bạn muốn, chúng tôi nói thẳng và đề xuất cách làm từng bước, thay vì bán cho bạn một gói không giải quyết được việc.</p>
                </div>
                <div>
                    <h3>Website cũ đang chạy, chuyển sang có mất dữ liệu không?</h3>
                    <p>Không. Chúng tôi sao chép sang máy chủ mới, bạn kiểm tra bản chạy thử, rồi mới trỏ tên miền và giữ máy chủ cũ song song 7 ngày.</p>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // The same handler the service and template pages use: report what the server
    // actually said, never a blanket "thành công".
    document.querySelectorAll('[data-lead]').forEach(function (form) {
        var msg = form.querySelector('[data-msg]');
        var btn = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            btn.disabled = true;
            msg.className = 'tpl-form__msg';
            msg.textContent = 'Đang gửi…';

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': form.querySelector('[name=_token]').value
                }
            })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data.status === 422) {
                        msg.className = 'tpl-form__msg is-bad';
                        msg.textContent = data.messages.name || data.messages.phone || data.messages.email || 'Vui lòng kiểm tra lại thông tin.';
                        btn.disabled = false;
                        return;
                    }
                    if (data.code !== 10) {
                        msg.className = 'tpl-form__msg is-bad';
                        msg.textContent = 'Không lưu được yêu cầu. Vui lòng gọi {{ $hotline }}.';
                        btn.disabled = false;
                        return;
                    }
                    msg.className = 'tpl-form__msg is-good';
                    msg.textContent = 'Đã nhận yêu cầu. Chúng tôi gọi lại trong 1 giờ làm việc.';
                    form.reset();
                })
                .catch(function () {
                    msg.className = 'tpl-form__msg is-bad';
                    msg.textContent = 'Không gửi được. Vui lòng gọi {{ $hotline }}.';
                    btn.disabled = false;
                });
        });
    });
</script>
@endsection
