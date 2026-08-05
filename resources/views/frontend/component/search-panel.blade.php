{{--
    Search panel.

    The header carries a single icon; this is what it opens. A field with room to type, and
    the keywords people actually search for underneath — which is the part that makes a
    search box useful to someone who does not yet know what to call what they want.

    The suggestions come from the "Từ khoá tìm kiếm gợi ý" setting, comma separated, so the
    client changes them in the admin rather than asking for a deploy.
--}}
@php
    $hotKeywords = collect(explode(',', (string) ($system['homepage_hot_keywords'] ?? '')))
        ->map(fn ($k) => trim(strip_tags($k)))
        ->filter()
        ->unique()
        ->take(12)
        ->values();
@endphp

<div class="search-panel" id="search-panel" hidden>
    <div class="search-panel__veil" data-search-close></div>

    <div class="search-panel__body" role="dialog" aria-modal="true" aria-label="Tìm kiếm giao diện">
        <form action="{{ route('product.catalogue.search') }}" method="get" class="search-panel__form" role="search">
            <span class="search-panel__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <circle cx="10.5" cy="10.5" r="6.5"/><path d="m15.4 15.4 4.1 4.1"/>
                </svg>
            </span>

            <label class="uk-hidden" for="search-panel-input">Từ khoá</label>
            <input id="search-panel-input" type="search" name="keyword" autocomplete="off"
                   placeholder="Bạn đang tìm mẫu website nào?" value="{{ request('keyword') }}"
                   data-search-input>

            <button type="submit" class="search-panel__go">Tìm</button>
            <button type="button" class="search-panel__x" data-search-close aria-label="Đóng">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                    <path d="M6 6l12 12M18 6L6 18"/>
                </svg>
            </button>
        </form>

        @if ($hotKeywords->isNotEmpty())
            <div class="search-panel__hot">
                <p class="search-panel__hot-label">Từ khoá được tìm nhiều</p>
                <ul class="search-panel__chips">
                    @foreach ($hotKeywords as $keyword)
                        <li>
                            <a href="{{ route('product.catalogue.search', ['keyword' => $keyword]) }}">{{ $keyword }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>

<script>
(function () {
    var panel = document.getElementById('search-panel');
    if (!panel) return;

    var input = panel.querySelector('[data-search-input]');
    var opener = null;

    function open(trigger) {
        opener = trigger || null;
        panel.hidden = false;
        requestAnimationFrame(function () { panel.classList.add('is-open'); });
        document.documentElement.style.overflow = 'hidden';
        // Focus after the panel is on screen, or the browser scrolls to it mid-transition.
        setTimeout(function () { input.focus({ preventScroll: true }); input.select(); }, 60);
    }

    function close() {
        panel.classList.remove('is-open');
        document.documentElement.style.overflow = '';

        var hide = function () { panel.hidden = true; };
        window.matchMedia('(prefers-reduced-motion: reduce)').matches ? hide() : setTimeout(hide, 200);

        if (opener && document.contains(opener)) opener.focus();
    }

    document.addEventListener('click', function (e) {
        var o = e.target.closest('[data-search-open]');
        if (o) { e.preventDefault(); open(o); return; }
        if (e.target.closest('[data-search-close]')) { e.preventDefault(); close(); }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !panel.hidden) close();
        // The shortcut people already expect from every search field on the web.
        if ((e.key === 'k' || e.key === 'K') && (e.metaKey || e.ctrlKey)) {
            e.preventDefault();
            panel.hidden ? open(null) : close();
        }
    });

    // An empty search would land on the results page with nothing to show.
    panel.querySelector('.search-panel__form').addEventListener('submit', function (e) {
        if (input.value.trim() === '') {
            e.preventDefault();
            input.focus();
        }
    });
})();
</script>
