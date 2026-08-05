@extends('frontend.homepage.layout')

@section('content')
{{--
    Bảng giá.

    Three packages side by side, the middle one raised — the shape the client asked for.
    Two things added to it, both because they are what buyers find out too late otherwise:
    each card lists what it does *not* include, and there is a table of the work that is
    not in any package.

    Every button opens the shared enquiry popup, carrying the package name with it, so a
    lead from "Cao cấp" arrives in Telegram saying so.
--}}
@php
    $lead = $pricing['lead'];
    $packages = $pricing['packages'];
@endphp

<div class="pri">

    {{-- ── Lead: badge, heading, one paragraph, all centred ──────── --}}
    <section class="pri-hero">
        <div class="uk-container uk-container-center">
            <div class="pri-hero__inner">
                <span class="pri-badge"><i aria-hidden="true"></i>{{ $lead['eyebrow'] }}</span>
                <h1 class="pri-title">{{ $lead['title'] }}</h1>
                <p class="pri-lead">{{ $lead['text'] }}</p>
            </div>
        </div>
    </section>

    {{-- ── The three packages ────────────────────────────────────── --}}
    <section class="pri-cards">
        <div class="uk-container uk-container-center">
            <div class="pri-grid">
                @foreach ($packages as $pkg)
                    {{-- No card is singled out. Three identical frames let the numbers do
                         the comparing, which is what someone on this page is here for. --}}
                    <article class="pri-card">
                        <h2 class="pri-card__name">{{ $pkg['name'] }}</h2>

                        <p class="pri-card__price">
                            <strong>{{ $pkg['price'] }}</strong><span class="pri-card__per">/ dự án</span>
                        </p>

                        @if (!empty($pkg['was']))
                            <p class="pri-card__was"><s>{{ $pkg['was'] }}</s></p>
                        @endif

                        <p class="pri-card__scope">{{ $pkg['scope'] }}</p>

                        <ul class="pri-list">
                            @foreach ($pkg['features'] as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach

                            {{-- Greyed with a dash. What a package leaves out is the thing
                                 people most often discover after paying. --}}
                            @foreach ($pkg['missing'] as $missing)
                                <li class="is-off">{{ $missing }}</li>
                            @endforeach
                        </ul>

                        {{-- Pushed to the bottom so the three buttons line up however long
                             each list is. --}}
                        <button type="button" class="pri-card__btn" data-lead-open
                                data-lead-subject="Bảng giá — gói {{ $pkg['name'] }}">
                            Đăng ký ngay <span aria-hidden="true">→</span>
                        </button>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Work that is in no package ────────────────────────────── --}}
    <section class="pri-extras">
        <div class="uk-container uk-container-center">
            <div class="pri-extras__grid">
                <div>
                    <h2 class="pri-h2">Những khoản tính thêm</h2>
                    <p class="pri-p">Nói trước để bạn không gặp con số lạ trên hoá đơn. Giá trên chưa gồm thuế giá trị gia tăng; cần hoá đơn thì cộng 8% theo quy định hiện hành.</p>
                </div>

                <dl class="pri-extras__list">
                    @foreach ($pricing['extras'] as [$label, $value])
                        <div>
                            <dt>{{ $label }}</dt>
                            <dd>{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>
    </section>

    {{-- ── Questions ─────────────────────────────────────────────── --}}
    <section class="pri-faq">
        <div class="uk-container uk-container-center">
            <h2 class="pri-h2">Câu hỏi về giá</h2>

            <div class="pri-acc" data-acc>
                @foreach ($pricing['faqs'] as $i => [$q, $a])
                    <div class="pri-acc__item {{ $i === 0 ? 'is-open' : '' }}">
                        <button type="button" class="pri-acc__q" aria-expanded="{{ $i === 0 ? 'true' : 'false' }}">
                            <span>{{ $q }}</span>
                            <i aria-hidden="true"></i>
                        </button>
                        <div class="pri-acc__a"><p>{{ $a }}</p></div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Close ─────────────────────────────────────────────────── --}}
    <section class="pri-close">
        <div class="uk-container uk-container-center">
            <div class="pri-close__box">
                <div>
                    <h2 class="pri-close__title">Chưa rõ gói nào vừa với bạn?</h2>
                    <p class="pri-close__lead">Nói cho chúng tôi bạn bán gì và cần website làm được việc gì. Nếu gói thấp nhất là đủ, chúng tôi sẽ nói vậy.</p>
                </div>

                <div class="pri-close__actions">
                    <button type="button" class="pri-card__btn pri-card__btn--solid" data-lead-open
                            data-lead-subject="Bảng giá — nhận tư vấn">Nhận tư vấn</button>
                    <a class="pri-close__call" href="{{ tel_href($system['contact_hotline'] ?? '') }}">
                        {{ $system['contact_hotline'] ?? '' }}
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // One open at a time, height animated from its real value.
    document.querySelectorAll('[data-acc]').forEach(function (acc) {
        var items = acc.querySelectorAll('.pri-acc__item');

        function setOpen(item, open) {
            var panel = item.querySelector('.pri-acc__a');
            item.classList.toggle('is-open', open);
            item.querySelector('.pri-acc__q').setAttribute('aria-expanded', open ? 'true' : 'false');
            panel.style.maxHeight = open ? panel.scrollHeight + 'px' : '0px';
        }

        items.forEach(function (item) {
            setOpen(item, item.classList.contains('is-open'));
            item.querySelector('.pri-acc__q').addEventListener('click', function () {
                var willOpen = !item.classList.contains('is-open');
                items.forEach(function (other) { setOpen(other, false); });
                if (willOpen) setOpen(item, true);
            });
        });

        window.addEventListener('resize', function () {
            items.forEach(function (item) {
                if (item.classList.contains('is-open')) setOpen(item, true);
            });
        });
    });
</script>
@endsection
