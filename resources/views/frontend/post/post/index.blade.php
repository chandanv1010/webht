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

    {{-- ── Body ──────────────────────────────────────────────────── --}}
    <section class="article-body">
        <div class="uk-container uk-container-center">
            <div class="article-body__inner tpl-prose">
                @if (trim(strip_tags($body)) !== '')
                    {!! $body !!}
                @else
                    <p>{{ $lead }}</p>
                @endif
            </div>

            <div class="article-foot">
                <a class="store-btn store-btn--ghost" href="{{ $catHref }}">← Quay lại {{ $catName }}</a>
                <a class="store-btn store-btn--primary" href="{{ write_url('lien-he') }}">Cần tư vấn cho trường hợp của bạn?</a>
            </div>
        </div>
    </section>

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
@endsection
