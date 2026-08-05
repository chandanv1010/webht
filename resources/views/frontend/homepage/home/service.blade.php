@extends('frontend.homepage.layout')

@section('content')
{{--
    A service landing page. Same layout as the hosting page — hero, three promises, a
    "why us" block, the offer as cards, feedback, then a way to get in touch — so the
    four services read as one family instead of four different sites.

    Content comes from config/apps/services.php. Nothing here is service-specific, which
    is why a new service is a new array rather than another copy of this file.
--}}
@php
    $hero = $service['hero'];
    $offer = $service['offer'];
@endphp

<div class="hosting-container service-landing">

    {{-- ── Hero ──────────────────────────────────────────────────── --}}
    <div class="hosting-header">
        <div class="uk-grid uk-grid-medium uk-flex uk-flex-middle">
            <div class="uk-width-large-2-5">
                <div class="hosting-content">
                    <div class="service-eyebrow">{{ $hero['eyebrow'] }}</div>
                    <h1 class="hosting-element-title">{!! $hero['title'] !!}</h1>
                    <div class="description">{{ $hero['lead'] }}</div>

                    <div class="service-hero-actions">
                        @foreach (['primary', 'secondary'] as $slot)
                            @continue(empty($hero[$slot]))
                            @php $cta = $hero[$slot]; @endphp

                            @if (($cta['action'] ?? null) === 'popup')
                                {{-- Opens the enquiry popup rather than navigating: the
                                     visitor is already on the page that answers their
                                     question, so sending them elsewhere loses them. --}}
                                <button type="button"
                                        class="svc-btn svc-btn--{{ $slot }}"
                                        data-lead-open
                                        data-lead-subject="{{ $service['meta_title'] }}">
                                    {{ $cta['label'] }}
                                </button>
                            @else
                                <a class="svc-btn svc-btn--{{ $slot }}" href="{{ write_url($cta['url']) }}">
                                    {{ $cta['label'] }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="uk-width-large-3-5">
                @include('frontend.component.illustration', ['name' => $hero['illustration']])
            </div>
        </div>
    </div>

    {{-- ── Three promises ────────────────────────────────────────── --}}
    <div class="panel-best">
        <div class="uk-container uk-container-center">
            <div class="panel-body">
                <div class="uk-grid uk-grid-medium">
                    @foreach ($service['promises'] as $i => $promise)
                        <div class="uk-width-medium-1-2 uk-width-large-1-3">
                            {{-- The middle card is raised, as on the hosting page. --}}
                            <div class="best-item {{ $i === 1 ? 'active' : '' }}">
                                <div class="icon">
                                    <img src="{{ asset($promise['icon']) }}" alt="" width="56" height="56">
                                </div>
                                <div class="info">
                                    <h3 class="title">{{ $promise['title'] }}</h3>
                                    <div class="description">{{ $promise['text'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ── Why us ────────────────────────────────────────────────── --}}
    <div class="panel-host-intro panel-best">
        <div class="uk-grid uk-grid-medium uk-flex uk-flex-middle">
            <div class="uk-width-large-1-2">
                <div class="lotier">
                    @include('frontend.component.illustration', ['name' => $service['why']['illustration']])
                </div>
            </div>
            <div class="uk-width-large-1-2">
                <div class="host-intro-container">
                    <div class="panel-head">
                        <span>{{ $service['why']['label'] }}</span>
                        <h2 class="heading-9"><span>{!! $service['why']['heading'] !!}</span></h2>
                        <div class="description">{{ $service['why']['lead'] }}</div>

                        <div class="elementor-widget-container">
                            <ul class="uk-list uk-clearfix">
                                @foreach ($service['why']['points'] as $i => $point)
                                    <li class="elementor-icon-list-item">
                                        <span class="elementor-icon-list-icon">{{ sprintf('%02d.', $i + 1) }}</span>
                                        <span class="elementor-icon-list-text">{{ $point }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Process, when the service has a real sequence ─────────── --}}
    @if (!empty($service['steps']))
        <div class="panel-steps">
            <div class="uk-container uk-container-center">
                <div class="panel-head">
                    <div class="special-text-1">{{ $service['steps']['label'] }}</div>
                    <div class="heading-11"><span>{{ $service['steps']['heading'] }}</span></div>
                    <div class="description">{{ $service['steps']['lead'] }}</div>
                </div>

                {{-- Numbered because this genuinely is a sequence: each step happens after
                     the one before it. --}}
                <ol class="svc-steps">
                    @foreach ($service['steps']['items'] as $step)
                        <li class="svc-step">
                            <div class="svc-step__when">{{ $step['when'] }}</div>
                            <div class="svc-step__title">{{ $step['title'] }}</div>
                            <div class="svc-step__text">{{ $step['text'] }}</div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    @endif

    {{-- ── The offer ─────────────────────────────────────────────── --}}
    <div class="panel-host-pricing">
        <div class="uk-container uk-container-center">
            <div class="panel-head">
                <div class="special-text-1">{{ $offer['label'] }}</div>
                <div class="heading-11"><span>{{ $offer['heading'] }}</span></div>
            </div>
            <div class="panel-body">
                <div class="uk-grid uk-grid-medium">
                    @foreach ($offer['cards'] as $card)
                        <div class="uk-width-medium-1-2 uk-width-large-1-3">
                            <div class="hosting-item {{ !empty($card['featured']) ? 'is-featured' : '' }}">
                                <div class="head">
                                    <div class="name">{{ $card['name'] }}</div>
                                    <div class="price">{{ $card['price'] }}</div>
                                    <div class="per">{{ $card['per'] }}</div>
                                </div>
                                <div class="body">
                                    <ul class="uk-list uk-clearfix">
                                        @foreach ($card['rows'] as [$label, $value])
                                            <li>
                                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                    <span>{{ $label }}</span>
                                                    <span>{{ $value }}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                        <li>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <span>Tiêu chuẩn chất lượng</span>
                                                <div class="rating">
                                                    <div class="uk-flex uk-flex-middle">
                                                        @for ($i = 0; $i < ($card['rating'] ?? 3); $i++)
                                                            <img src="{{ asset('frontend/resources/img/star.png') }}" alt="" width="14" height="14">
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                    <button type="button" class="svc-btn svc-btn--primary svc-btn--block"
                                            data-lead-open
                                            data-lead-subject="{{ $service['meta_title'] }} — {{ $card['name'] }}">
                                        Chọn gói này
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if (!empty($service['note']))
                    <p class="svc-note">{{ $service['note'] }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Feedback ──────────────────────────────────────────────── --}}
    @if (isset($widgets['feedback']) && !empty($widgets['feedback']->object))
        @foreach ($widgets['feedback']->object as $feedback)
            @continue(!isset($feedback->posts) || !count($feedback->posts))
            <div class="panel-customer">
                <div class="panel-head">
                    <h2 class="heading-10"><span>Khách hàng nói gì</span></h2>
                </div>
                <div class="panel-body">
                    <div class="swiper-container your-swiper-container">
                        <div class="swiper-controls">
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                        <div class="swiper-wrapper">
                            @foreach ($feedback->posts as $post)
                                @php
                                    $name = explode('-', $post->languages[0]->name);
                                @endphp
                                <div class="swiper-slide">
                                    <div class="customer-item">
                                        <div class="rating">
                                            <div class="uk-flex uk-flex-middle">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <img src="{{ asset('frontend/resources/img/star.png') }}" alt="" width="14" height="14">
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="description">{!! $post->languages[0]->description !!}</div>
                                        <div class="uk-flex uk-flex-middle">
                                            <div class="avatar">
                                                <img src="{{ $post->image }}" alt="{{ $name[0] }}" loading="lazy">
                                            </div>
                                            <div class="customer-info">
                                                <div class="name">{{ $name[0] }}</div>
                                                <div class="role">{{ $name[1] ?? '' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    {{-- ── Get in touch ──────────────────────────────────────────── --}}
    <div class="panel-support">
        <div class="uk-container uk-container-center">
            <div class="panel-head uk-text-center">
                <div class="small-heading">HT VIỆT NAM</div>
                <h2 class="heading-9"><span>Còn câu hỏi nào chưa được trả lời?</span></h2>
                <div class="description">Gọi trong giờ hành chính luôn có người nhấc máy, hoặc để lại số để chúng tôi gọi lại.</div>
            </div>
            <div class="panel-body">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-large-1-2">
                        <div class="support-item">
                            <div class="uk-grid uk-grid-small uk-flex uk-flex-middle">
                                <div class="uk-width-large-1-2">
                                    <div class="support-article">
                                        <div class="title">Để lại yêu cầu</div>
                                        <div class="description">Điền tên và số điện thoại, chúng tôi gọi lại trong 1 giờ làm việc.</div>
                                        <button type="button" class="btn-support-button" data-lead-open
                                                data-lead-subject="{{ $service['meta_title'] }}">
                                            Gửi yêu cầu
                                        </button>
                                    </div>
                                </div>
                                <div class="uk-width-large-1-2">
                                    <div class="lottier-wraper">
                                        @include('frontend.component.illustration', ['name' => 'email'])
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
                                        <div class="title">Gọi trực tiếp</div>
                                        <div class="description">Nhanh nhất. Người nghe máy là người làm dự án của bạn.</div>
                                        <a href="{{ tel_href($system['contact_hotline'] ?? '') }}"
                                           class="btn-support-button support-phone-button">{{ $system['contact_hotline'] ?? '' }}</a>
                                    </div>
                                </div>
                                <div class="uk-width-large-1-2">
                                    <div class="lottier-wraper">
                                        @include('frontend.component.illustration', ['name' => 'support'])
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
