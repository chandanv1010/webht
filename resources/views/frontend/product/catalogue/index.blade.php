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
    @if ($storeFeatured)
        <section class="store-hero">
            {{-- The mosaic is the whole catalogue at once, dimmed and drifting. It is
                 the literal reading of "a world of websites" — you see the scale of
                 the store before you have scrolled a pixel. Duplicated once so the
                 vertical drift has somewhere to go without a visible seam. --}}
            <div class="store-hero__wall" aria-hidden="true">
                <div class="store-hero__wall-grid">
                    @foreach ($storePosters as $poster)
                        <img src="{{ image($poster) }}" alt="" loading="lazy" width="1200" height="750">
                    @endforeach
                    @foreach ($storePosters as $poster)
                        <img src="{{ image($poster) }}" alt="" loading="lazy" width="1200" height="750">
                    @endforeach
                </div>
            </div>

            {{-- The grid lives on an inner div, not on .uk-container: UIkit gives that
                 class ::before/::after for clearfix, and pseudo-elements become grid
                 items — they took the first cells and pushed the text into column two
                 and the frame onto a second row. --}}
            <div class="uk-container uk-container-center">
                <div class="store-hero__inner">
                <div class="store-hero__text">
                    <p class="store-hero__eyebrow">{{ $rootPivot->name ?? 'Kho giao diện' }} · {{ $storeTotal }} mẫu</p>
                    <h1 class="store-hero__title">{{ $featuredName }}</h1>

                    @if ($featuredDesc !== '')
                        <p class="store-hero__desc">{{ \Illuminate\Support\Str::limit(strip_tags($featuredDesc), 170) }}</p>
                    @endif

                    <p class="store-hero__meta">
                        <span class="store-hero__price">
                            @if ($featuredPrice === 0) Miễn phí @else {{ convert_price($featuredPrice, true) }}đ @endif
                        </span>
                        <span class="store-hero__count">Bàn giao 5–7 ngày · Kèm mã nguồn</span>
                    </p>

                    <div class="store-hero__actions">
                        <a class="store-btn store-btn--primary" href="{{ $featuredHref }}">Xem mẫu này</a>
                        <a class="store-btn store-btn--ghost" href="{{ write_url('lien-he') }}">Nhận tư vấn chọn mẫu</a>
                    </div>
                </div>

                {{-- The featured template shown as what it is: a website, in a frame. --}}
                {{-- No browser bar of our own here: the poster already draws one, and
                     two stacked chrome strips read as a bug. --}}
                <a class="store-hero__frame" href="{{ $featuredHref }}" aria-label="{{ $featuredName }}">
                    <img src="{{ image($storeFeatured->image) }}" alt="{{ $featuredName }}" width="1200" height="750">
                </a>
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
                track.scrollBy({
                    left: (dir === 'next' ? 1 : -1) * Math.round(track.clientWidth * 0.8),
                    behavior: 'smooth'
                });
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
</script>
@endsection
