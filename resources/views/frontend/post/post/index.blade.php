@extends('frontend.homepage.layout')
@section('content')

{{--
    Article page, on the store's dark canvas.

    Built for reading: one column, generous measure, and nothing competing with the
    text until it ends. The previous version put a widget sidebar next to the body and
    read the widgets without guarding for a missing one, which is how five article
    pages ended up returning 500.
--}}

@php
    $pv = $post->languages->first()?->pivot;
    $title = $pv->name ?? '';
    $lead = plain_text($pv->description ?? '');
    $body = $pv->content ?? '';
    $cover = trim((string) $post->image);

    $catPivot = $postCatalogue->languages->first()?->pivot;
    $catName = $catPivot->name ?? '';
    $catHref = write_url($catPivot->canonical ?? '');

    // Rough reading time. Useful enough to show, honest enough not to dress up.
    $words = str_word_count(strip_tags($body.' '.$lead));
    $minutes = max(1, (int) ceil($words / 200));

    // Contents, read out of the body's own headings, with ids injected so the links land.
    // Built here rather than stored, so it cannot drift from the article.
    $toc = [];
    if (trim(strip_tags($body)) !== '') {
        if (preg_match_all('/<(h2|h3)[^>]*>(.*?)<\/\1>/is', $body, $m, PREG_SET_ORDER)) {
            foreach ($m as $i => $hit) {
                $text = trim(strip_tags($hit[2]));
                if ($text === '') {
                    continue;
                }
                $slug = 'muc-'.($i + 1);
                $toc[] = ['slug' => $slug, 'text' => $text, 'level' => $hit[1]];
                $body = preg_replace(
                    '/'.preg_quote($hit[0], '/').'/',
                    '<'.$hit[1].' id="'.$slug.'">'.$hit[2].'</'.$hit[1].'>',
                    $body,
                    1
                );
            }
        }
    }

    // Other articles in the same catalogue. $asidePost is a paginator, and collect()ing a
    // paginator gives its meta array (current_page, per_page, …) rather than its rows —
    // which is why reading ->id off those values turned these pages into 500s. Take
    // ->items() when it is a paginator, and still guard the type: nothing here should be
    // able to break an article page.
    $related = collect(
        $asidePost instanceof \Illuminate\Contracts\Pagination\Paginator
            ? $asidePost->items()
            : ($asidePost ?? [])
    )
        ->filter(fn ($p) => is_object($p) && isset($p->id) && method_exists($p, 'getAttribute'))
        ->filter(fn ($p) => (int) $p->id !== (int) $post->id)
        ->take(8);
@endphp

<div class="store store-page news-page article-page">

    {{-- ── Header ────────────────────────────────────────────────── --}}
    <section class="store-hero article-hero">
        @if ($cover !== '')
            <div class="store-hero__back" aria-hidden="true">
                <div class="store-hero__back-layer is-on" style="background-image:url('{{ image($cover) }}')"></div>
            </div>
        @endif

        <div class="uk-container uk-container-center">
            <div class="article-hero__inner">
                <p class="store-hero__eyebrow">
                    <a href="{{ $catHref }}" class="tpl-hero__cat">{{ $catName }}</a>
                </p>

                <h1 class="article-title">{{ $title }}</h1>

                @if ($lead !== '')
                    <p class="article-lead">{{ $lead }}</p>
                @endif

                <p class="article-meta">
                    @if ($post->created_at)
                        <span>{{ convertDateTime($post->created_at, 'd/m/Y') }}</span>
                    @endif
                    <span>{{ $minutes }} phút đọc</span>
                    @if ($post->viewed)
                        <span>{{ number_format($post->viewed, 0, ',', '.') }} lượt xem</span>
                    @endif
                </p>
            </div>
        </div>
    </section>

    {{-- ── Body, with the contents beside it ─────────────────────── --}}
    <section class="article-body {{ count($toc) > 1 ? 'has-toc' : '' }}">
        <div class="uk-container uk-container-center">
            <div class="article-layout">
                <div class="article-body__inner tpl-prose" data-article>
                    @if (trim(strip_tags($body)) !== '')
                        {!! $body !!}
                    @else
                        <p>{{ $lead }}</p>
                    @endif

                    <div class="article-foot">
                        <a class="store-btn store-btn--ghost" href="{{ $catHref }}">← Quay lại {{ $catName }}</a>
                        <a class="store-btn store-btn--primary" href="{{ write_url('lien-he') }}">Cần tư vấn cho trường hợp của bạn?</a>
                    </div>
                </div>

                @if (count($toc) > 1)
                    {{-- The right column was empty, which on a wide screen left the article
                         as a narrow strip. A contents list is what belongs there: it is the
                         one thing a long article can offer that a printed page cannot. --}}
                    <aside class="article-toc" data-toc aria-label="Nội dung bài viết">
                        <p class="article-toc__label">Nội dung bài viết</p>
                        <nav>
                            <ol class="article-toc__list">
                                @foreach ($toc as $item)
                                    <li class="is-{{ $item['level'] }}">
                                        <a href="#{{ $item['slug'] }}">{{ $item['text'] }}</a>
                                    </li>
                                @endforeach
                            </ol>
                        </nav>

                        <div class="article-toc__progress" aria-hidden="true">
                            <span data-read-bar></span>
                        </div>
                    </aside>
                @endif
            </div>
        </div>
    </section>

    @if (count($toc) > 1)
        {{-- Once the sidebar has scrolled away this takes over: a button that opens the
             same list as a panel. --}}
        <button type="button" class="toc-fab" data-toc-open aria-expanded="false"
                aria-label="Mở nội dung bài viết">
            <span class="toc-fab__bars" aria-hidden="true"><i></i><i></i><i></i></span>
            <span class="toc-fab__text">Nội dung</span>
        </button>

        <div class="toc-sheet" data-toc-sheet hidden>
            <div class="toc-sheet__veil" data-toc-close></div>
            <div class="toc-sheet__panel" role="dialog" aria-modal="true" aria-label="Nội dung bài viết">
                <header class="toc-sheet__head">
                    <p class="toc-sheet__title">Nội dung bài viết</p>
                    <button type="button" class="toc-sheet__x" data-toc-close aria-label="Đóng">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                            <path d="M6 6l12 12M18 6L6 18"/>
                        </svg>
                    </button>
                </header>

                <ol class="article-toc__list">
                    @foreach ($toc as $item)
                        <li class="is-{{ $item['level'] }}">
                            <a href="#{{ $item['slug'] }}" data-toc-jump>{{ $item['text'] }}</a>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    @endif

    {{-- ── Related ──────────────────────────────────────────────── --}}
    @if ($related->isNotEmpty())
        <section class="news-list article-related">
            <div class="uk-container uk-container-center">
                <header class="store-shelf__head">
                    <h2 class="store-shelf__title">Bài viết khác</h2>
                    <a class="store-shelf__all" href="{{ $catHref }}">Xem cả chuyên mục</a>
                </header>

                <div class="news-grid">
                    @foreach ($related as $item)
                        @include('frontend.component.article-card', ['post' => $item])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>

<script>
(function () {
    var toc = document.querySelector('[data-toc]');
    if (!toc) return;

    var links = document.querySelectorAll('.article-toc__list a');
    var fab = document.querySelector('[data-toc-open]');
    var sheet = document.querySelector('[data-toc-sheet]');
    var bar = document.querySelector('[data-read-bar]');
    var article = document.querySelector('[data-article]');
    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ── Smooth jumps ───────────────────────────────────────────────────── */

    // Done here rather than with scroll-behavior:smooth so the header's height is taken
    // into account — a plain anchor jump puts the heading underneath it.
    function jumpTo(hash) {
        var target = document.getElementById(hash.slice(1));
        if (!target) return false;

        var headerH = parseInt(getComputedStyle(document.documentElement)
            .getPropertyValue('--header-h'), 10) || 0;
        var top = target.getBoundingClientRect().top + window.scrollY - headerH - 24;

        window.scrollTo({ top: top, behavior: reduced ? 'auto' : 'smooth' });
        // Move focus so a keyboard user carries on from the heading, not from the link.
        target.setAttribute('tabindex', '-1');
        target.focus({ preventScroll: true });
        history.replaceState(null, '', hash);
        return true;
    }

    document.addEventListener('click', function (e) {
        var link = e.target.closest('.article-toc__list a, .toc-sheet a');
        if (!link) return;
        var hash = link.getAttribute('href') || '';
        if (hash.charAt(0) !== '#') return;
        if (jumpTo(hash)) {
            e.preventDefault();
            closeSheet();
        }
    });

    /* ── Which heading is in view, and how far through ───────────────────── */

    var headings = [].slice.call(document.querySelectorAll('[data-article] h2[id], [data-article] h3[id]'));

    function markCurrent() {
        var headerH = parseInt(getComputedStyle(document.documentElement)
            .getPropertyValue('--header-h'), 10) || 0;
        var line = window.scrollY + headerH + 90;
        var current = null;

        headings.forEach(function (h) {
            if (h.getBoundingClientRect().top + window.scrollY <= line) current = h.id;
        });

        links.forEach(function (a) {
            a.classList.toggle('is-on', a.getAttribute('href') === '#' + current);
        });

        if (bar && article) {
            // From the article's own rect, not offsetTop: offsetTop is measured against
            // the nearest positioned ancestor, which here is not the page, so the bar sat
            // at 100% from the first frame.
            var box = article.getBoundingClientRect();
            var start = box.top + window.scrollY;
            var span = box.height - window.innerHeight * 0.6;
            var done = span > 0 ? (window.scrollY + window.innerHeight * 0.4 - start) / span : 1;
            bar.style.transform = 'scaleX(' + Math.max(0, Math.min(1, done)).toFixed(3) + ')';
        }
    }

    /* ── The button takes over when the sidebar leaves ───────────────────── */

    function syncFab() {
        if (!fab) return;
        // Shown once the list itself has scrolled out of reach.
        var past = toc.getBoundingClientRect().bottom < 40;
        fab.classList.toggle('is-in', past);
    }

    var queued = false;
    window.addEventListener('scroll', function () {
        if (queued) return;
        queued = true;
        // One measurement per frame: reading layout on every scroll event is what makes a
        // page feel heavy under the finger.
        requestAnimationFrame(function () {
            markCurrent();
            syncFab();
            queued = false;
        });
    }, { passive: true });
    window.addEventListener('resize', markCurrent);
    markCurrent();
    syncFab();

    /* ── The panel ──────────────────────────────────────────────────────── */

    function openSheet() {
        if (!sheet) return;
        sheet.hidden = false;
        requestAnimationFrame(function () { sheet.classList.add('is-open'); });
        fab.setAttribute('aria-expanded', 'true');
        document.documentElement.style.overflow = 'hidden';
        var first = sheet.querySelector('a');
        if (first) first.focus({ preventScroll: true });
    }

    function closeSheet() {
        if (!sheet || sheet.hidden) return;
        sheet.classList.remove('is-open');
        fab.setAttribute('aria-expanded', 'false');
        document.documentElement.style.overflow = '';
        var hide = function () { sheet.hidden = true; };
        reduced ? hide() : setTimeout(hide, 240);
    }

    if (fab) fab.addEventListener('click', function () {
        sheet && sheet.hidden ? openSheet() : closeSheet();
    });

    document.addEventListener('click', function (e) {
        if (e.target.closest('[data-toc-close]')) { e.preventDefault(); closeSheet(); }
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeSheet();
    });
})();
</script>
@endsection
