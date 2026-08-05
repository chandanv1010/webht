{{--
    Home hero — two slides, built to the two designs the client pointed at.

    1. The studio, dark: a badge, a headline whose second line types itself through the
       services, and an orbital diagram of what we do.
    2. The library, light: a headline with the real template count, a search field with
       industry suggestions, and a fan of actual template covers.

    Everything is markup and CSS. No artwork is borrowed: the fan is our own covers and
    the orbit is drawn here, so there is nothing to swap out later and no third-party
    image in the repo.

    Expects: $heroStats, $heroCategories, $heroCovers, $system
--}}
@php
    $templateCount = $heroStats[0]['value'] ?? '';

    // The second line of the dark headline cycles through these.
    $typedWords = ['thiết kế website', 'viết bài SEO', 'chăm sóc website', 'tối ưu tốc độ'];
@endphp

<section class="hero" data-hero>

    <div class="hero__slides">

        {{-- ── 1. The studio ─────────────────────────────────────── --}}
        <article class="hero__slide hero__slide--dark is-on" data-hero-slide aria-hidden="false">
            <div class="hero__dots-bg" aria-hidden="true"></div>

            <div class="uk-container uk-container-center">
                <div class="hero__grid">
                    <div class="hero__copy">
                        <span class="hero__badge"><i aria-hidden="true"></i>Website &amp; SEO</span>

                        <h1 class="hero__title hero__title--dark">
                            <span class="hero__line">Chúng tôi làm</span>
                            <span class="hero__line hero__line--type">
                                {{-- The word is swapped by script; the first one is in the
                                     markup so the headline is never empty before JS runs. --}}
                                <span data-type-out>{{ $typedWords[0] }}</span><i class="hero__caret" aria-hidden="true"></i>
                            </span>
                        </h1>

                        <p class="hero__lead hero__lead--dark">Nâng tầm thương hiệu, bứt phá thứ hạng tìm kiếm và giải phóng áp lực quản lý. Mã nguồn sạch, chạy ổn định, tối ưu tỷ lệ chuyển đổi.</p>

                        <div class="hero__actions">
                            <button type="button" class="hero__btn hero__btn--primary" data-lead-open
                                    data-lead-subject="TƯ VẤN THIẾT KẾ">Nhận tư vấn</button>
                            <a class="hero__btn hero__btn--outline" href="{{ write_url('kho-giao-dien') }}">Xem dự án</a>
                        </div>

                        {{-- Counted from the database. A number nobody can check is worth
                             less than no number. --}}
                        <dl class="hero__stats">
                            @foreach ($heroStats as $stat)
                                <div>
                                    <dd>{{ $stat['value'] }}</dd>
                                    <dt>{{ $stat['label'] }}</dt>
                                </div>
                            @endforeach
                        </dl>
                    </div>

                    {{-- The orbit. Two dashed rings, the brand at the centre, and the
                         capabilities as bubbles around it — four named, four as icons. --}}
                    <div class="hero__orbit" aria-hidden="true">
                        <div class="hero__ring hero__ring--outer"></div>
                        <div class="hero__ring hero__ring--inner"></div>

                        <div class="hero__core">
                            <img src="{{ $system['homepage_logo'] }}" alt="">
                        </div>

                        <div class="hero__bubbles">
                            @foreach ([
                                ['UI/UX', 'layout', 1],
                                ['Cloud', 'cloud', 2],
                                ['CMS', 'cms', 3],
                                ['SEO', 'seo', 4],
                                [null, 'cart', 5],
                                [null, 'code', 6],
                                [null, 'data', 7],
                                [null, 'chart', 8],
                            ] as [$label, $icon, $slot])
                                <span class="hero__bubble hero__bubble--{{ $slot }} {{ $label ? 'has-label' : '' }}">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        @switch($icon)
                                            @case('layout')
                                                <rect x="3.5" y="4" width="17" height="16" rx="2"/><path d="M3.5 9h17M9.5 9v11"/>
                                                @break
                                            @case('cloud')
                                                <path d="M7 18h10a3.5 3.5 0 0 0 .3-6.99A5.5 5.5 0 0 0 6.5 11 3.5 3.5 0 0 0 7 18Z"/>
                                                @break
                                            @case('cms')
                                                <rect x="3.5" y="4.5" width="17" height="15" rx="2"/><path d="M7 9h6M7 13h10M7 16h7"/>
                                                @break
                                            @case('seo')
                                                <circle cx="11" cy="11" r="6"/><path d="m15.5 15.5 4 4"/>
                                                @break
                                            @case('cart')
                                                <path d="M4 5h2l2.2 9.2h9.1L19.5 8H7"/><circle cx="9.5" cy="18" r="1.4"/><circle cx="16.5" cy="18" r="1.4"/>
                                                @break
                                            @case('code')
                                                <path d="m9 8-4 4 4 4M15 8l4 4-4 4"/>
                                                @break
                                            @case('data')
                                                <ellipse cx="12" cy="6.5" rx="7" ry="2.8"/><path d="M5 6.5v11c0 1.55 3.13 2.8 7 2.8s7-1.25 7-2.8v-11"/><path d="M5 12c0 1.55 3.13 2.8 7 2.8s7-1.25 7-2.8"/>
                                                @break
                                            @default
                                                <path d="M5 19V9M10 19V5M15 19v-7M20 19v-4"/>
                                        @endswitch
                                    </svg>
                                    @if ($label)<b>{{ $label }}</b>@endif
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </article>

        {{-- ── 2. The library ────────────────────────────────────── --}}
        <article class="hero__slide hero__slide--light" data-hero-slide aria-hidden="true">
            <div class="hero__glow" aria-hidden="true"></div>

            <div class="uk-container uk-container-center">
                <div class="hero__grid">
                    <div class="hero__copy">
                        <h1 class="hero__title">
                            <span class="hero__line">Kho <em>{{ $templateCount }} website đa ngành</em></span>
                            <span class="hero__line">Tiết kiệm &amp; triển khai nhanh</span>
                        </h1>

                        <p class="hero__lead">Website chuẩn SEO, tương thích đa thiết bị. Bàn giao mã nguồn và tài liệu sử dụng, dễ dàng đổi nội dung theo thương hiệu.</p>

                        {{-- A field, not a button: on this slide the search *is* the offer. --}}
                        <form class="hero__search" action="{{ route('product.catalogue.search') }}" method="get" role="search">
                            <label class="uk-hidden" for="hero-search">Tìm ngành nghề</label>
                            <input id="hero-search" type="search" name="keyword" autocomplete="off"
                                   placeholder="Tìm ngành nghề: bất động sản, giáo dục, bán hàng…">
                            <button type="submit" aria-label="Tìm kiếm">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" aria-hidden="true">
                                    <circle cx="10.5" cy="10.5" r="6.5"/><path d="m15.4 15.4 4.1 4.1"/>
                                </svg>
                            </button>
                        </form>

                        @if (count($heroCategories))
                            <div class="hero__hints">
                                <span class="hero__hints-label">Gợi ý:</span>
                                <ul>
                                    @foreach ($heroCategories as $category)
                                        <li><a href="{{ write_url($category['canonical']) }}">{{ $category['name'] }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="hero__actions">
                            <a class="hero__btn hero__btn--warm" href="{{ write_url('kho-giao-dien') }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                    <rect x="3.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="3.5" width="7" height="7" rx="1.5"/>
                                    <rect x="3.5" y="13.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="13.5" width="7" height="7" rx="1.5"/>
                                </svg>
                                Xem kho giao diện
                            </a>
                            <button type="button" class="hero__btn hero__btn--ghost" data-lead-open
                                    data-lead-subject="TƯ VẤN THIẾT KẾ">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                                     stroke-linecap="round" aria-hidden="true">
                                    <path d="M20 12a7.5 7.5 0 0 1-7.5 7.5 8 8 0 0 1-3.2-.66L4.5 20l1.2-3.5A7.5 7.5 0 1 1 20 12Z"/>
                                </svg>
                                Nhận tư vấn
                            </button>
                        </div>

                        <p class="hero__assure">
                            <span aria-hidden="true">✓</span> Bàn giao mã nguồn &amp; tài liệu hướng dẫn
                        </p>
                    </div>

                    {{-- The fan. Our own covers, overlapped and tilted, in a raised frame —
                         the design the client pointed at, with our content in it. --}}
                    <div class="hero__showcase">
                        <div class="hero__fan" aria-hidden="true">
                            @foreach ($heroCovers->take(5) as $i => $cover)
                                <span class="hero__fan-item" style="--n: {{ $i }}">
                                    <img src="{{ image($cover) }}" alt="" loading="lazy">
                                </span>
                            @endforeach
                        </div>

                        <span class="hero__pill hero__pill--demo">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z"/><circle cx="12" cy="12" r="2.6"/>
                            </svg>
                            <span><b>Trải nghiệm</b>Xem demo</span>
                        </span>

                        <span class="hero__pill hero__pill--count">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                <rect x="3.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="3.5" width="7" height="7" rx="1.5"/>
                                <rect x="3.5" y="13.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="13.5" width="7" height="7" rx="1.5"/>
                            </svg>
                            <span><b>Kho mẫu sẵn</b>{{ $templateCount }} giao diện</span>
                        </span>
                    </div>
                </div>
            </div>
        </article>
    </div>

    {{-- ── Arrows ────────────────────────────────────────────────── --}}
    <button type="button" class="hero__arrow hero__arrow--prev" data-hero-prev aria-label="Nội dung trước">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M14.5 5.5 8 12l6.5 6.5"/>
        </svg>
    </button>
    <button type="button" class="hero__arrow hero__arrow--next" data-hero-next aria-label="Nội dung sau">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M9.5 5.5 16 12l-6.5 6.5"/>
        </svg>
    </button>

    {{-- ── Which slide ───────────────────────────────────────────── --}}
    <div class="hero__nav">
        <div class="uk-container uk-container-center">
            <div class="hero__pager" role="tablist" aria-label="Chọn nội dung">
                <button type="button" class="hero__pip is-on" role="tab" aria-selected="true"
                        data-hero-go="0"><span class="uk-hidden">Về chúng tôi</span></button>
                <button type="button" class="hero__pip" role="tab" aria-selected="false"
                        data-hero-go="1"><span class="uk-hidden">Kho giao diện</span></button>
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    var hero = document.querySelector('[data-hero]');
    if (!hero) return;

    var slides = hero.querySelectorAll('[data-hero-slide]');
    var pips = hero.querySelectorAll('[data-hero-go]');
    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ── The rotating word ──────────────────────────────────────────────── */

    var words = @json($typedWords);
    var out = hero.querySelector('[data-type-out]');

    if (out && !reduced) {
        var w = 0, i = words[0].length, adding = false;

        (function tick() {
            var word = words[w];
            i += adding ? 1 : -1;
            out.textContent = word.slice(0, i);

            var wait = adding ? 70 : 40;

            if (adding && i === word.length) { adding = false; wait = 1900; }
            else if (!adding && i === 0) { adding = true; w = (w + 1) % words.length; wait = 260; }

            setTimeout(tick, wait);
        })();
    }

    /* ── The pair ───────────────────────────────────────────────────────── */

    if (slides.length < 2) return;

    var current = 0;
    var timer = null;
    var INTERVAL = 7500;

    function show(next, dir) {
        next = (next + slides.length) % slides.length;
        if (next === current) return;

        // Which way the pair moved, so the outgoing slide leaves the side the incoming one
        // came from rather than both drifting the same way.
        var forward = typeof dir === 'number' ? dir > 0 : next > current;
        hero.classList.toggle('is-back', !forward);

        slides.forEach(function (slide, n) {
            var on = n === next;
            slide.classList.toggle('is-on', on);
            slide.classList.toggle('was-on', n === current);
            slide.setAttribute('aria-hidden', on ? 'false' : 'true');
            // Keep the hidden slide's controls out of the tab order.
            slide.querySelectorAll('a, button, input').forEach(function (el) {
                on ? el.removeAttribute('tabindex') : (el.tabIndex = -1);
            });
        });

        pips.forEach(function (pip, n) {
            pip.classList.toggle('is-on', n === next);
            pip.setAttribute('aria-selected', n === next ? 'true' : 'false');
        });

        hero.classList.toggle('is-dark', next === 0);
        current = next;
    }

    function play() { if (!reduced && !timer) timer = setInterval(function () { show(current + 1); }, INTERVAL); }
    function pause() { clearInterval(timer); timer = null; }

    // Set the hidden slide's tab order without a visible change, then drop the classes
    // the transition uses so nothing animates on load.
    show(1, 1); show(0, -1);
    slides.forEach(function (slide) { slide.classList.remove('was-on'); });
    hero.classList.remove('is-back');

    function chosen(fn) {
        return function () {
            fn();
            // A deliberate choice should not be overwritten a moment later.
            pause();
            setTimeout(play, INTERVAL * 2);
        };
    }

    pips.forEach(function (pip) {
        pip.addEventListener('click', chosen(function () {
            var go = parseInt(pip.dataset.heroGo, 10);
            show(go, go > current ? 1 : -1);
        }));
    });

    var prev = hero.querySelector('[data-hero-prev]');
    var next = hero.querySelector('[data-hero-next]');
    if (prev) prev.addEventListener('click', chosen(function () { show(current - 1, -1); }));
    if (next) next.addEventListener('click', chosen(function () { show(current + 1, 1); }));

    // Arrow keys, once the hero has focus.
    hero.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') { e.preventDefault(); show(current - 1, -1); }
        if (e.key === 'ArrowRight') { e.preventDefault(); show(current + 1, 1); }
    });

    hero.addEventListener('mouseenter', pause);
    hero.addEventListener('mouseleave', play);
    hero.addEventListener('focusin', pause);
    document.addEventListener('visibilitychange', function () { document.hidden ? pause() : play(); });

    play();
})();
</script>
