@extends('frontend.homepage.layout')

@section('content')
{{--
    Videos.

    The old page was a five-across grid of items whose thumbnails linked to href="" and
    whose only visual was a coloured wash. This one plays: the featured video sits at the
    top, the rest are shelves, and every card is a real click-to-play.

    Nothing loads an iframe until it is asked to. Eleven embedded players on one page is
    eleven third-party frames, and none of them is watched.
--}}
@php
    $shelves = collect(config('apps.videos.shelves', []));
    $featuredId = $featuredVideoId;
@endphp

<div class="store store-page vid">

    {{-- ── Featured ──────────────────────────────────────────────── --}}
    <section class="vid-hero">
        <div class="uk-container uk-container-center">
            <div class="vid-hero__grid">
                <div class="vid-hero__copy">
                    <p class="vid-eyebrow">Videos</p>
                    <h1 class="vid-title">Xem trước khi hỏi</h1>
                    <p class="vid-lead">Cách chúng tôi làm việc, hướng dẫn dùng trang quản trị, và những câu hỏi khách hay hỏi nhất — trả lời bằng video thay vì bằng email dài.</p>

                    <div class="vid-hero__actions">
                        <a class="store-btn store-btn--ghost" href="{{ write_url('lien-he') }}">Câu hỏi chưa có ở đây?</a>
                    </div>
                </div>

                @if ($featuredId)
                    <div class="vid-player" data-video="{{ $featuredId }}">
                        <button type="button" class="vid-player__poster" data-video-play
                                aria-label="Phát video giới thiệu">
                            <img src="https://i.ytimg.com/vi/{{ $featuredId }}/maxresdefault.jpg"
                                 alt="" loading="lazy"
                                 onerror="this.src='https://i.ytimg.com/vi/{{ $featuredId }}/hqdefault.jpg'">
                            <span class="vid-play" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5.5v13l11-6.5-11-6.5Z"/></svg>
                            </span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ── Shelves ───────────────────────────────────────────────── --}}
    @foreach ($shelves as $shelf)
        <section class="vid-shelf">
            <div class="uk-container uk-container-center">
                <header class="vid-shelf__head">
                    <h2 class="vid-shelf__title">{{ $shelf['name'] }}</h2>
                    @if (!empty($shelf['note']))
                        <p class="vid-shelf__note">{{ $shelf['note'] }}</p>
                    @endif
                </header>

                <ul class="vid-grid">
                    @foreach ($shelf['items'] as $item)
                        <li class="vid-card" data-video="{{ $item['id'] }}">
                            <button type="button" class="vid-card__poster" data-video-play
                                    aria-label="Phát: {{ $item['title'] }}">
                                <img src="https://i.ytimg.com/vi/{{ $item['id'] }}/hqdefault.jpg"
                                     alt="" loading="lazy">
                                <span class="vid-play vid-play--sm" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5.5v13l11-6.5-11-6.5Z"/></svg>
                                </span>
                                @if (!empty($item['length']))
                                    <span class="vid-card__len">{{ $item['length'] }}</span>
                                @endif
                            </button>
                            <p class="vid-card__title">{{ $item['title'] }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endforeach
</div>

<script>
    // Click to play. The poster is replaced by the player only for the one that was
    // asked for, and any other open player is closed so two videos never talk at once.
    document.querySelectorAll('[data-video-play]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var box = btn.closest('[data-video]');
            var id = box.getAttribute('data-video');
            if (!id || box.classList.contains('is-playing')) return;

            document.querySelectorAll('[data-video].is-playing').forEach(function (other) {
                other.classList.remove('is-playing');
                var frame = other.querySelector('iframe');
                if (frame) frame.remove();
            });

            var frame = document.createElement('iframe');
            // nocookie, and no autoplay-related tracking beyond what playing requires.
            frame.src = 'https://www.youtube-nocookie.com/embed/' + id + '?autoplay=1&rel=0';
            frame.title = btn.getAttribute('aria-label') || 'Video';
            frame.allow = 'accelerometer; autoplay; encrypted-media; picture-in-picture';
            frame.allowFullscreen = true;
            frame.loading = 'lazy';

            box.appendChild(frame);
            box.classList.add('is-playing');
        });
    });
</script>
@endsection
