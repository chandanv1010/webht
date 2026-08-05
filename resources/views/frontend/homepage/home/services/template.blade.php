@extends('frontend.homepage.layout')

@section('content')
{{--
    Website mẫu có sẵn.

    This decision is made by looking, not by reading, so the page puts real templates on
    screen immediately — the gallery is the argument. Everything else is short: a seven-day
    strip because the speed is the selling point, a two-panel "we change this, not that" so
    nobody is surprised, and three compact prices.

    No timeline spine, no comparison table. That is the bespoke page's job.
--}}
@php $hero = $service['hero']; $offer = $service['offer']; @endphp

<div class="svc svc--gallery">

    {{-- ── Hero: short, because the gallery is right below ───────── --}}
    <section class="svc-hero svc-hero--tight">
        <div class="uk-container uk-container-center">
            <div class="svc-hero__center">
                <p class="svc-eyebrow">{{ $hero['eyebrow'] }}</p>
                <h1 class="svc-title">{!! $hero['title'] !!}</h1>
                <p class="svc-lead">{{ $hero['lead'] }}</p>

                <div class="svc-actions svc-actions--center">
                    <a class="svc-btn svc-btn--primary" href="{{ write_url('kho-giao-dien') }}">Xem cả kho giao diện</a>
                    <button type="button" class="svc-btn svc-btn--secondary" data-lead-open
                            data-lead-subject="Website mẫu có sẵn">Nhận tư vấn chọn mẫu</button>
                </div>
            </div>
        </div>
    </section>

    {{-- ── The gallery: the argument ─────────────────────────────── --}}
    @if ($templates->isNotEmpty())
        <section class="svc-gallery">
            <div class="uk-container uk-container-center">
                <div class="svc-gallery__grid">
                    @foreach ($templates as $tpl)
                        @php
                            $pv = $tpl->languages->first()?->pivot;
                            $tName = $pv->name ?? '';
                            $tHref = write_url($pv->canonical ?? '');
                        @endphp
                        <a class="svc-tile" href="{{ $tHref }}">
                            <span class="svc-tile__shot tpl-card__poster">
                                <img src="{{ image($tpl->image) }}" alt="{{ $tName }}" loading="lazy">
                            </span>
                            <span class="svc-tile__name">{{ $tName }}</span>
                            <span class="svc-tile__price">
                                @if ((int) $tpl->price === 0) Miễn phí @else {{ convert_price($tpl->price, true) }}đ @endif
                            </span>
                        </a>
                    @endforeach
                </div>

                <p class="svc-gallery__more">
                    <a href="{{ write_url('kho-giao-dien') }}">Còn nữa trong kho giao diện →</a>
                </p>
            </div>
        </section>
    @endif

    {{-- ── Seven days, day by day ────────────────────────────────── --}}
    <section class="svc-days">
        <div class="uk-container uk-container-center">
            <header class="svc-sechead">
                <p class="svc-eyebrow">Bàn giao</p>
                <h2 class="svc-h2">Bảy ngày, ngày nào làm gì</h2>
                <p class="svc-p">Mốc hay trễ nhất là ngày đầu, khi nội dung chưa sẵn. Gửi đủ ngay từ đầu thì phần còn lại gần như luôn đúng hạn.</p>
            </header>

            {{-- A strip rather than a vertical list: seven short items read faster across
                 than down, and the horizontal run is itself the point about speed. --}}
            <ol class="svc-strip">
                @foreach ([
                    ['1', 'Chốt mẫu', 'Bạn gửi logo, nội dung, hình ảnh. Chúng tôi mua tên miền, dựng hosting.'],
                    ['2–3', 'Đổi nhận diện', 'Cài mẫu, thay logo và bộ màu, dựng menu và danh mục theo ngành của bạn.'],
                    ['4–5', 'Đưa nội dung', 'Nhập nội dung, tối ưu ảnh, cấu hình SEO cơ bản cho từng trang.'],
                    ['6', 'Bạn kiểm tra', 'Xem trên địa chỉ thử nghiệm và gửi lại danh sách cần sửa.'],
                    ['7', 'Chạy thật', 'Sửa xong, trỏ tên miền, bật SSL, hướng dẫn dùng trang quản trị.'],
                ] as [$day, $title, $text])
                    <li class="svc-strip__item">
                        <span class="svc-strip__day">Ngày {{ $day }}</span>
                        <span class="svc-strip__title">{{ $title }}</span>
                        <span class="svc-strip__text">{{ $text }}</span>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ── What changes, what does not ───────────────────────────── --}}
    <section class="svc-split">
        <div class="uk-container uk-container-center">
            <div class="svc-split__grid">
                <div class="svc-split__panel svc-split__panel--yes">
                    <h2 class="svc-split__title">Chúng tôi thay</h2>
                    <ul class="svc-checks">
                        <li>Logo, bộ màu, phông chữ theo nhận diện của bạn.</li>
                        <li>Toàn bộ nội dung, hình ảnh, thông tin liên hệ, bản đồ.</li>
                        <li>Cấu trúc menu và danh mục theo đúng ngành.</li>
                        <li>Thêm hoặc bỏ khối trên trang chủ.</li>
                        <li>Gắn Analytics, Search Console, Pixel nếu cần.</li>
                    </ul>
                </div>
                <div class="svc-split__panel svc-split__panel--no">
                    <h2 class="svc-split__title">Không nằm trong gói</h2>
                    <ul class="svc-checks svc-checks--no">
                        <li>Đổi bố cục sang một thiết kế khác.</li>
                        <li>Thêm luồng nghiệp vụ mới.</li>
                        <li>Nối với phần mềm kế toán, kho, CRM.</li>
                    </ul>
                    <p class="svc-split__note">
                        Những việc này thuộc
                        <a href="{{ write_url('thiet-ke-theo-yeu-cau') }}">thiết kế theo yêu cầu</a>.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Three prices, compact ─────────────────────────────────── --}}
    <section class="svc-tiers">
        <div class="uk-container uk-container-center">
            <header class="svc-sechead">
                <p class="svc-eyebrow">{{ $offer['label'] }}</p>
                <h2 class="svc-h2">{{ $offer['heading'] }}</h2>
            </header>

            <div class="svc-tiers__grid">
                @foreach ($offer['cards'] as $card)
                    <div class="svc-tier {{ !empty($card['featured']) ? 'is-featured' : '' }}">
                        @if (!empty($card['featured']))
                            <span class="svc-tier__flag">Hay được chọn</span>
                        @endif
                        <p class="svc-tier__name">{{ $card['name'] }}</p>
                        <p class="svc-tier__price">{{ $card['price'] }}</p>

                        <ul class="svc-tier__rows">
                            @foreach ($card['rows'] as [$label, $value])
                                <li class="{{ $value === '—' ? 'is-off' : '' }}">
                                    <span>{{ $label }}</span><b>{{ $value }}</b>
                                </li>
                            @endforeach
                        </ul>

                        <button type="button" class="svc-btn svc-btn--primary svc-btn--block" data-lead-open
                                data-lead-subject="Website mẫu có sẵn — {{ $card['name'] }}">Chọn gói này</button>
                    </div>
                @endforeach
            </div>

            <p class="svc-note">{{ $service['note'] }}</p>
        </div>
    </section>

    @include('frontend.homepage.home.services.partials.closing', [
        'subject' => 'Website mẫu có sẵn',
        'title' => 'Chưa biết chọn mẫu nào?',
        'lead' => 'Nói cho chúng tôi bạn bán gì và khách của bạn là ai. Chúng tôi gợi ý hai ba mẫu, không gợi ý cả kho.',
    ])
</div>
@endsection
