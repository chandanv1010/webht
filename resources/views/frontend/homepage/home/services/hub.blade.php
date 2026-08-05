@extends('frontend.homepage.layout')

@section('content')
{{--
    Dịch vụ — the page the menu item points at.

    Netflix's shape, because the job is the same: someone browsing, not searching. A
    billboard for the one they most likely came for, then rows of the rest, each row a
    thing you can act on rather than a card that only links away.

    Dark canvas, same as the template store, so the two browsing surfaces on the site
    look like one place.
--}}
@php
    $hero = $services->first();
    $rest = $services->slice(1)->values();
@endphp

<div class="store store-page hub">

    {{-- ── Billboard ─────────────────────────────────────────────── --}}
    <section class="hub-hero">
        <div class="hub-hero__art" aria-hidden="true">
            <div class="hub-hero__grid">
                @foreach ($posters as $poster)
                    <span style="background-image:url('{{ image($poster) }}')"></span>
                @endforeach
            </div>
        </div>

        <div class="uk-container uk-container-center">
            <div class="hub-hero__inner">
                <p class="hub-eyebrow">Dịch vụ · {{ $services->count() }} nhóm</p>
                <h1 class="hub-title">Chọn cách bạn muốn bắt đầu</h1>
                <p class="hub-lead">Bốn cách làm website, cùng một đội. Khác nhau ở thời gian, chi phí và mức độ bạn cần tham gia — không khác nhau ở việc ai làm.</p>

                <div class="hub-hero__actions">
                    <a class="store-btn store-btn--primary" href="{{ write_url($hero['canonical']) }}">
                        {{ $hero['cta'] }}
                    </a>
                    <button type="button" class="store-btn store-btn--ghost" data-lead-open
                            data-lead-subject="TƯ VẤN THIẾT KẾ">Chưa biết chọn gì</button>
                </div>
            </div>
        </div>
    </section>

    {{-- ── The rows ──────────────────────────────────────────────── --}}
    <section class="hub-rows">
        <div class="uk-container uk-container-center">
            @foreach ($services as $i => $service)
                <article class="hub-row">
                    <div class="hub-row__mark" aria-hidden="true">{{ sprintf('%02d', $i + 1) }}</div>

                    <div class="hub-row__body">
                        <header class="hub-row__head">
                            <h2 class="hub-row__title">
                                <a href="{{ write_url($service['canonical']) }}">{{ $service['name'] }}</a>
                            </h2>
                            <p class="hub-row__price">{{ $service['price'] }}</p>
                        </header>

                        <p class="hub-row__lead">{{ $service['lead'] }}</p>

                        {{-- What this one is actually for. Three lines, so the choice can be
                             made here rather than after four page visits. --}}
                        <ul class="hub-row__points">
                            @foreach ($service['points'] as $point)
                                <li>{{ $point }}</li>
                            @endforeach
                        </ul>

                        <div class="hub-row__foot">
                            <a class="hub-row__go" href="{{ write_url($service['canonical']) }}">{{ $service['cta'] }}</a>
                            <span class="hub-row__when">{{ $service['when'] }}</span>
                        </div>
                    </div>

                    {{-- The row's own visual: a schematic of what it delivers. --}}
                    <div class="hub-row__art hub-art hub-art--{{ $service['key'] }}" aria-hidden="true">
                        @for ($k = 0; $k < 4; $k++)<i></i>@endfor
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- ── Which one, in one table ───────────────────────────────── --}}
    <section class="hub-compare">
        <div class="uk-container uk-container-center">
            <header class="store-shelf__head">
                <h2 class="store-shelf__title">Nếu vẫn chưa rõ</h2>
            </header>

            <div class="hub-compare__wrap">
                <table class="hub-table">
                    <thead>
                        <tr>
                            <th scope="col">Bạn đang ở tình huống</th>
                            <th scope="col">Nên chọn</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ([
                            ['Cần có website trong tuần này', 'Website mẫu có sẵn', 'thiet-ke-website-theo-mau-co-san'],
                            ['Quy trình bán hàng không giống ai', 'Thiết kế theo yêu cầu', 'thiet-ke-theo-yeu-cau'],
                            ['Đã có website nhưng không ai trông', 'Chăm sóc website', 'cham-soc-website'],
                            ['Website chạy tốt nhưng không ai tìm thấy', 'Dịch vụ SEO', 'dich-vu-seo'],
                            ['Chỉ cần chỗ đặt website cho nhanh và ổn', 'Hosting & tên miền', 'dich-vu-hosting'],
                        ] as [$situation, $answer, $canonical])
                            <tr>
                                <th scope="row">{{ $situation }}</th>
                                <td><a href="{{ write_url($canonical) }}">{{ $answer }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
