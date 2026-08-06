@extends('frontend.homepage.layout')
@section('content')

{{--
    Kho giao diện — browsed like a catalogue of worlds rather than a product list.

    A billboard for the newest template, then one shelf per category that scrolls
    sideways. Choosing a filter collapses the shelves into a single grid, because once
    you have narrowed things down you want to compare, not browse.

    Filtering is plain query parameters rendered on the server (?dm= ?gia= ?sap-xep=),
    so it works without JavaScript. The script at the bottom only adds the shelf arrow
    buttons, which are useless without JS anyway and so are created by it.
--}}

@php
    $featuredPivot = $storeFeatured?->languages->first()?->pivot;
    $featuredName = $featuredPivot->name ?? '';
    $featuredHref = write_url($featuredPivot->canonical ?? '');
    $featuredDesc = $featuredPivot->description ?? '';
    $featuredPrice = (int) ($storeFeatured->price ?? 0);
    $rootPivot = $storeRoot->languages->first()?->pivot;

    // Keep the other filters when building each control's URL, so choosing a price
    // does not silently drop the category the visitor already picked.
    $baseUrl = write_url($rootPivot->canonical ?? 'kho-giao-dien');
    $buildUrl = function (array $overrides) use ($baseUrl, $storeActiveCategory, $storeActiveBucket, $storeActiveSort) {
        $params = array_filter([
            'dm' => $overrides['dm'] ?? $storeActiveCategory,
            'gia' => $overrides['gia'] ?? $storeActiveBucket,
            'sap-xep' => $overrides['sap-xep'] ?? $storeActiveSort,
        ], fn ($v) => $v !== '' && $v !== 0 && $v !== 'moi-nhat');

        return $baseUrl.(count($params) ? '?'.http_build_query($params) : '');
    };
@endphp

<div class="store store-page">

    {{-- ── Billboard ─────────────────────────────────────────────── --}}
    @if ($storeFeaturedList->isNotEmpty())
        @php
            $slides = $storeFeaturedList->map(function ($p) {
                $pv = $p->languages->first()?->pivot;
                return [
                    'name' => $pv->name ?? '',
                    'href' => write_url($pv->canonical ?? ''),
                    'desc' => \Illuminate\Support\Str::limit(strip_tags($pv->description ?? ''), 165),
                    'price' => (int) $p->price,
                    'image' => image($p->image),
                    'cat' => $p->product_catalogues->first()?->languages->first()?->pivot->name ?? '',
                ];
            })->values();
        @endphp

        <section class="store-hero" data-hero aria-roledescription="carousel" aria-label="Giao diện nổi bật">
            {{-- One backdrop layer per slide, crossfaded. The backdrop is the template's
                 own screenshot, anchored to its top edge — the part of a homepage that
                 identifies it — so moving between slides changes the whole atmosphere
                 the way a streaming service does. --}}
            <div class="store-hero__back" aria-hidden="true">
                @foreach ($slides as $i => $slide)
                    <div class="store-hero__back-layer {{ $i === 0 ? 'is-on' : '' }}"
                         style="background-image:url('{{ $slide['image'] }}')"></div>
                @endforeach
            </div>

            <div class="uk-container uk-container-center">
                <div class="store-hero__inner">
                    <div class="store-hero__stage">
                        @foreach ($slides as $i => $slide)
                            <div class="store-hero__text {{ $i === 0 ? 'is-on' : '' }}"
                                 role="group"
                                 aria-roledescription="slide"
                                 aria-label="{{ $i + 1 }} / {{ count($slides) }}"
                                 @if ($i !== 0) aria-hidden="true" @endif>
                                <p class="store-hero__eyebrow">
                                    {{ $slide['cat'] !== '' ? $slide['cat'] : ($rootPivot->name ?? 'Kho giao diện') }}
                                    · {{ $storeTotal }} mẫu
                                </p>
                                <h1 class="store-hero__title">{{ $slide['name'] }}</h1>

                                @if ($slide['desc'] !== '')
                                    <p class="store-hero__desc">{{ $slide['desc'] }}</p>
                                @endif

                                <p class="store-hero__meta">
                                    <span class="store-hero__price">
                                        @if ($slide['price'] === 0) Miễn phí @else {{ convert_price($slide['price'], true) }}đ @endif
                                    </span>
                                    <span class="store-hero__count">Bàn giao 5–7 ngày · Kèm mã nguồn</span>
                                </p>

                                <div class="store-hero__actions">
                                    <a class="store-btn store-btn--primary" href="{{ $slide['href'] }}"
                                       @if ($i !== 0) tabindex="-1" @endif>Xem mẫu này</a>
                                    <a class="store-btn store-btn--ghost" href="{{ write_url('lien-he') }}"
                                       @if ($i !== 0) tabindex="-1" @endif>Nhận tư vấn chọn mẫu</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="store-hero__frames">
                        @foreach ($slides as $i => $slide)
                            <a class="store-hero__frame {{ $i === 0 ? 'is-on' : '' }}"
                               href="{{ $slide['href'] }}"
                               aria-label="{{ $slide['name'] }}"
                               @if ($i !== 0) tabindex="-1" aria-hidden="true" @endif>
                                <img src="{{ $slide['image'] }}" alt="{{ $slide['name'] }}"
                                     width="1400" height="875" {{ $i === 0 ? '' : 'loading=lazy' }}>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Dots live inside the same .uk-container as the slides. As a sibling
                     with its own container they became a second flex item of
                     .store-hero and both halves lost their gutter. --}}
                <div class="store-hero__controls">
                    <div class="store-hero__dots" role="tablist" aria-label="Chọn giao diện">
                    @foreach ($slides as $i => $slide)
                            <button type="button" class="store-hero__dot {{ $i === 0 ? 'is-on' : '' }}"
                                    role="tab" aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
                                    data-go="{{ $i }}">
                                <span class="uk-hidden">{{ $slide['name'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ── Filter bar ────────────────────────────────────────────── --}}
    <nav class="store-filter" aria-label="Lọc giao diện">
        <div class="uk-container uk-container-center">
            <div class="store-filter__row">
                <span class="store-filter__label">Danh mục</span>
                <div class="store-filter__pills">
                    <a class="store-pill {{ $storeActiveCategory === 0 ? 'is-on' : '' }}"
                       href="{{ $buildUrl(['dm' => 0]) }}">Tất cả</a>
                    @foreach ($storeCategories as $category)
                        @php $cName = $category->languages->first()?->pivot->name ?? ''; @endphp
                        <a class="store-pill {{ $storeActiveCategory === (int) $category->id ? 'is-on' : '' }}"
                           href="{{ $buildUrl(['dm' => (int) $category->id]) }}">{{ $cName }}</a>
                    @endforeach
                </div>
            </div>

            <div class="store-filter__row">
                <span class="store-filter__label">Mức giá</span>
                <div class="store-filter__pills">
                    <a class="store-pill {{ $storeActiveBucket === '' ? 'is-on' : '' }}"
                       href="{{ $buildUrl(['gia' => '']) }}">Tất cả</a>
                    @foreach ($storeBuckets as $key => $bucket)
                        <a class="store-pill {{ $storeActiveBucket === $key ? 'is-on' : '' }}"
                           href="{{ $buildUrl(['gia' => $key]) }}">{{ $bucket['label'] }}</a>
                    @endforeach
                </div>

                <div class="store-filter__sort">
                    <span class="store-filter__label">Sắp xếp</span>
                    @foreach ($storeSorts as $key => $sort)
                        <a class="store-pill store-pill--sm {{ $storeActiveSort === $key ? 'is-on' : '' }}"
                           href="{{ $buildUrl(['sap-xep' => $key]) }}">{{ $sort['label'] }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </nav>

    {{-- ── Results ───────────────────────────────────────────────── --}}
    @if ($storeIsFiltered)
        <section class="store-results">
            <div class="uk-container uk-container-center">
                <header class="store-results__head">
                    <h2 class="store-results__title">
                        {{ $storeTotal }} mẫu phù hợp
                    </h2>
                    @if ($storeActiveCategory > 0 || $storeActiveBucket !== '')
                        <a class="store-results__clear" href="{{ $baseUrl }}">Bỏ bộ lọc</a>
                    @endif
                </header>

                @if ($storeTotal === 0)
                    <div class="store-empty">
                        <p class="store-empty__title">Chưa có mẫu nào khớp bộ lọc này.</p>
                        <p class="store-empty__hint">Thử mở rộng mức giá, hoặc bỏ chọn danh mục để xem toàn bộ kho.</p>
                        <a class="store-btn store-btn--primary" href="{{ $baseUrl }}">Xem toàn bộ kho</a>
                    </div>
                @else
                    <div class="store-grid">
                        @foreach ($storeResults as $product)
                            @include('frontend.component.template-card', ['product' => $product])
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    @else
        @foreach ($storeShelves as $shelf)
            @php
                $shelfPivot = $shelf['category']->languages->first()?->pivot;
                $shelfName = $shelfPivot->name ?? '';
                $shelfHref = write_url($shelfPivot->canonical ?? '');
            @endphp
            <section class="store-shelf">
                <div class="uk-container uk-container-center">
                    <header class="store-shelf__head">
                        <h2 class="store-shelf__title">{{ $shelfName }}</h2>
                        <a class="store-shelf__all" href="{{ $shelfHref }}">
                            Xem tất cả {{ count($shelf['items']) }} mẫu
                        </a>
                    </header>
                </div>

                <div class="store-shelf__viewport" data-shelf>
                    <div class="uk-container uk-container-center">
                        <div class="store-shelf__track">
                            @foreach ($shelf['items'] as $product)
                                @include('frontend.component.template-card', ['product' => $product])
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    @endif

    {{-- ── Category copy ─────────────────────────────────────────── --}}
    @php
        // Show the copy for whatever the visitor is actually looking at: the selected
        // category, or the store itself when nothing is filtered.
        $aboutPivot = $rootPivot;
        $aboutTitle = $rootPivot->name ?? 'Kho giao diện';

        if ($storeActiveCategory > 0) {
            $activeCat = $storeCategories->firstWhere('id', $storeActiveCategory);
            if ($activeCat) {
                $catPivot = $activeCat->languages->first()?->pivot;
                if (($catPivot->description ?? '') !== '') {
                    $aboutPivot = $catPivot;
                    $aboutTitle = $catPivot->name;
                }
            }
        }
    @endphp

    @if (($aboutPivot->description ?? '') !== '')
        {{-- Rendered expanded. The script collapses it afterwards, so with JavaScript
             off — and for anything reading the page as text — the whole article is
             present rather than hidden behind a button. --}}
        <section class="store-about" data-readmore>
            <div class="uk-container uk-container-center">
                <div class="store-about__inner">
                    <h2 class="store-about__title">{{ $aboutTitle }}</h2>
                    <div class="store-about__body">{!! $aboutPivot->description !!}</div>
                </div>
            </div>
        </section>
    @endif
</div>

<script>
    // Shelf arrows are added by script because they do nothing without it. Scrolling
    // with a trackpad, touch, or the keyboard works whether this runs or not.
    // Eased horizontal scroll. behavior:'smooth' is quick and near-linear, which is why
    // the shelves felt like they jumped rather than moved; this runs long enough to read
    // as motion and decelerates into place.
    function glide(el, delta) {
        var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var max = el.scrollWidth - el.clientWidth;
        var from = el.scrollLeft;
        var to = Math.max(0, Math.min(max, from + delta));

        if (reduced || from === to) { el.scrollLeft = to; return; }

        // One animation per element: a second click replaces the first rather than
        // fighting it.
        if (el._glide) cancelAnimationFrame(el._glide);

        // The track carries scroll-snap-type: x proximity for swiping. Snapping and a
        // hand-driven scrollLeft fight each other every frame — the browser keeps pulling
        // the position back to the nearest card — which is why the arrows jumped instead
        // of gliding. Off for the duration, on again at the end.
        el.style.scrollSnapType = 'none';

        var DURATION = 720;
        var start = null;

        el._glide = requestAnimationFrame(function step(now) {
            if (start === null) start = now;
            var t = Math.min(1, (now - start) / DURATION);
            // easeInOutCubic: it leaves and arrives slowly, which is what reads as a glide
            // rather than a shove.
            var eased = t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
            el.scrollLeft = from + (to - from) * eased;

            if (t < 1) {
                el._glide = requestAnimationFrame(step);
            } else {
                el._glide = null;
                el.style.scrollSnapType = '';
            }
        });
    }

    document.querySelectorAll('[data-shelf]').forEach(function (shelf) {
        var track = shelf.querySelector('.store-shelf__track');
        if (!track) return;

        function overflows() {
            return track.scrollWidth - track.clientWidth > 4;
        }
        if (!overflows()) return;

        ['prev', 'next'].forEach(function (dir) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'store-shelf__nav store-shelf__nav--' + dir;
            btn.setAttribute('aria-label', dir === 'prev' ? 'Xem các mẫu trước' : 'Xem các mẫu tiếp theo');
            btn.addEventListener('click', function () {
                glide(track, (dir === 'next' ? 1 : -1) * Math.round(track.clientWidth * 0.8));
            });
            shelf.appendChild(btn);
        });

        function syncEdges() {
            shelf.classList.toggle('at-start', track.scrollLeft <= 2);
            shelf.classList.toggle('at-end', track.scrollLeft + track.clientWidth >= track.scrollWidth - 2);
        }
        track.addEventListener('scroll', syncEdges, { passive: true });
        window.addEventListener('resize', syncEdges);
        syncEdges();
    });
    // Read-more on the category article. The markup ships expanded and is collapsed
    // here, so the text is always in the document for search engines and for anyone
    // without JavaScript.
    document.querySelectorAll('[data-readmore]').forEach(function (block) {
        var body = block.querySelector('.store-about__body');
        if (!body) return;

        var COLLAPSED = 250;
        // Nothing to collapse if the article is already short.
        if (body.scrollHeight <= COLLAPSED + 80) return;

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'store-about__more';
        btn.setAttribute('aria-expanded', 'false');
        btn.setAttribute('aria-controls', body.id || (body.id = 'store-about-body'));

        function label() {
            btn.textContent = block.classList.contains('is-open') ? 'Thu gọn' : 'Xem thêm';
        }

        function collapse() {
            block.classList.add('is-clamped');
            block.classList.remove('is-open');
            body.style.maxHeight = COLLAPSED + 'px';
            btn.setAttribute('aria-expanded', 'false');
            label();
        }

        function expand() {
            block.classList.add('is-open');
            // Animate to the measured height, then release the cap so the block can
            // still reflow if the window is resized.
            body.style.maxHeight = body.scrollHeight + 'px';
            btn.setAttribute('aria-expanded', 'true');
            label();
            body.addEventListener('transitionend', function once(e) {
                if (e.propertyName !== 'max-height') return;
                if (block.classList.contains('is-open')) body.style.maxHeight = 'none';
                body.removeEventListener('transitionend', once);
            });
        }

        btn.addEventListener('click', function () {
            if (block.classList.contains('is-open')) {
                // Pin the current height first, or the transition has nothing to run from.
                body.style.maxHeight = body.scrollHeight + 'px';
                requestAnimationFrame(collapse);
            } else {
                expand();
            }
        });

        block.querySelector('.store-about__inner').appendChild(btn);
        collapse();
    });
    // Billboard slideshow. Crossfades the backdrop, the copy and the framed preview
    // together, so moving between slides changes the whole atmosphere rather than just
    // swapping a picture. Everything is already in the DOM; this only moves a class.
    document.querySelectorAll('[data-hero]').forEach(function (hero) {
        var layers = hero.querySelectorAll('.store-hero__back-layer');
        var texts  = hero.querySelectorAll('.store-hero__text');
        var frames = hero.querySelectorAll('.store-hero__frame');
        var dots   = hero.querySelectorAll('.store-hero__dot');
        var count  = texts.length;
        if (count < 2) return;

        var current = 0;
        var timer = null;
        var INTERVAL = 6500;
        var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        function show(next) {
            if (next === current) return;
            next = (next + count) % count;

            [[layers, false], [texts, true], [frames, true]].forEach(function (pair) {
                var nodes = pair[0], manageFocus = pair[1];
                if (!nodes[current] || !nodes[next]) return;

                nodes[current].classList.remove('is-on');
                nodes[next].classList.add('is-on');

                if (!manageFocus) return;
                // Keep the hidden slides out of the tab order and out of the
                // accessibility tree — three invisible CTAs is three wasted tab stops.
                nodes[current].setAttribute('aria-hidden', 'true');
                nodes[next].removeAttribute('aria-hidden');
                nodes[current].querySelectorAll('a').forEach(function (a) { a.tabIndex = -1; });
                nodes[next].querySelectorAll('a').forEach(function (a) { a.removeAttribute('tabindex'); });
                if (nodes[next].tagName === 'A') nodes[next].removeAttribute('tabindex');
                if (nodes[current].tagName === 'A') nodes[current].tabIndex = -1;
            });

            dots.forEach(function (d, i) {
                d.classList.toggle('is-on', i === next);
                d.setAttribute('aria-selected', i === next ? 'true' : 'false');
            });

            current = next;
        }

        function play() {
            if (reduced || timer) return;
            timer = setInterval(function () { show(current + 1); }, INTERVAL);
        }
        function pause() { clearInterval(timer); timer = null; }

        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                show(parseInt(dot.dataset.go, 10));
                // A deliberate choice should not be overwritten a moment later.
                pause();
            });
        });

        // Arrow keys work when the dot strip has focus.
        hero.querySelector('.store-hero__dots').addEventListener('keydown', function (e) {
            if (e.key === 'ArrowRight') { show(current + 1); pause(); }
            if (e.key === 'ArrowLeft')  { show(current - 1); pause(); }
        });

        hero.addEventListener('mouseenter', pause);
        hero.addEventListener('mouseleave', play);
        hero.addEventListener('focusin', pause);

        // Nothing should animate in a tab nobody is looking at.
        document.addEventListener('visibilitychange', function () {
            document.hidden ? pause() : play();
        });

        play();
    });
</script>
@endsection
