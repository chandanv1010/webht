@extends('frontend.homepage.layout')
@section('content')

{{--
    News listing, on the same dark canvas as the template store.

    A billboard for the newest article, then the rest as a grid. Deliberately not
    shelves here: a reader wants to scan headlines and pick one, and a horizontal row
    hides most of them. The shelf pattern is for browsing pictures; this is browsing
    sentences.
--}}

@php
    $catPivot = $postCatalogue->languages->first()?->pivot;
    $catName = $catPivot->name ?? '';
    $catDesc = $catPivot->description ?? '';

    $all = collect($posts->items() ?? []);
    $lead = $all->first();
    $rest = $all->slice(1)->values();

    $leadPivot = $lead?->languages->first()?->pivot;
    $leadName = $leadPivot->name ?? '';
    $leadHref = write_url($leadPivot->canonical ?? '');
    $leadDesc = plain_text($leadPivot->description ?? '');
    $leadImage = trim((string) ($lead->image ?? ''));
@endphp

<div class="store store-page news-page">

    {{-- ── Billboard ─────────────────────────────────────────────── --}}
    <section class="store-hero news-hero">
        @if ($leadImage !== '')
            <div class="store-hero__back" aria-hidden="true">
                <div class="store-hero__back-layer is-on" style="background-image:url('{{ image($leadImage) }}')"></div>
            </div>
        @endif

        <div class="uk-container uk-container-center">
            <div class="news-hero__inner">
                <p class="store-hero__eyebrow">{{ $catName }} · {{ $posts->total() }} bài</p>

                @if ($lead)
                    <h1 class="store-hero__title news-hero__title">
                        <a href="{{ $leadHref }}">{{ $leadName }}</a>
                    </h1>

                    @if ($leadDesc !== '')
                        <p class="store-hero__desc">{{ \Illuminate\Support\Str::limit($leadDesc, 200) }}</p>
                    @endif

                    <p class="store-hero__count">
                        @if ($lead->created_at){{ convertDateTime($lead->created_at, 'd/m/Y') }}@endif
                        @if ($lead->viewed) · {{ number_format($lead->viewed, 0, ',', '.') }} lượt xem @endif
                    </p>

                    <div class="store-hero__actions">
                        <a class="store-btn store-btn--primary" href="{{ $leadHref }}">Đọc bài này</a>
                    </div>
                @else
                    <h1 class="store-hero__title news-hero__title">{{ $catName }}</h1>
                    <p class="store-hero__desc">Chưa có bài viết nào trong mục này.</p>
                @endif
            </div>
        </div>
    </section>

    {{-- ── Sibling categories ────────────────────────────────────── --}}
    @if (isset($postCatalogue->children) && !is_null($postCatalogue->children) && count($postCatalogue->children))
        <nav class="store-filter" aria-label="Chuyên mục">
            <div class="uk-container uk-container-center">
                <div class="store-filter__row">
                    <span class="store-filter__label">Chuyên mục</span>
                    <div class="store-filter__pills">
                        @foreach ($postCatalogue->children as $item)
                            @php
                                $iPivot = $item->languages->first()?->pivot;
                                $iName = $item->short_name ?: ($iPivot->name ?? '');
                            @endphp
                            <a class="store-pill {{ ($iPivot->canonical ?? '') === $postCatalogue->canonical ? 'is-on' : '' }}"
                               href="{{ write_url($iPivot->canonical ?? '') }}">{{ $iName }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </nav>
    @endif

    {{-- ── The rest ──────────────────────────────────────────────── --}}
    @if ($rest->isNotEmpty())
        <section class="news-list">
            <div class="uk-container uk-container-center">
                <div class="news-grid">
                    @foreach ($rest as $item)
                        @include('frontend.component.article-card', ['post' => $item])
                    @endforeach
                </div>

                @if ($posts->hasPages())
                    <div class="news-pager">
                        @include('frontend.component.pagination', ['model' => $posts])
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- ── Category copy ─────────────────────────────────────────── --}}
    @if (trim(strip_tags($catDesc)) !== '')
        <section class="store-about" data-readmore>
            <div class="uk-container uk-container-center">
                <div class="store-about__inner">
                    <h2 class="store-about__title">{{ $catName }}</h2>
                    <div class="store-about__body">{!! $catDesc !!}</div>
                </div>
            </div>
        </section>
    @endif
</div>

<script>
    // Same read-more as the store: shipped expanded, collapsed by script, so the copy
    // is always in the document for search engines and for anyone without JavaScript.
    document.querySelectorAll('[data-readmore]').forEach(function (block) {
        var body = block.querySelector('.store-about__body');
        if (!body) return;

        var COLLAPSED = 250;
        if (body.scrollHeight <= COLLAPSED + 80) return;

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'store-about__more';
        btn.setAttribute('aria-expanded', 'false');

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
            body.style.maxHeight = body.scrollHeight + 'px';
            btn.setAttribute('aria-expanded', 'true');
            label();
        }

        btn.addEventListener('click', function () {
            if (block.classList.contains('is-open')) {
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
