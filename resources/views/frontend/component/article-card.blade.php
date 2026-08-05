{{--
    One article. Used by the news listing and by the related shelf on an article page,
    so the two can never drift apart.

    Expects: $post
--}}
@php
    $pv = $post->languages->first()?->pivot;
    $aName = $pv->name ?? '';
    $aHref = write_url($pv->canonical ?? '');
    $aDesc = plain_text($pv->description ?? '');
    $aImage = trim((string) $post->image);
    $aCat = $post->post_catalogues->first()?->languages->first()?->pivot->name ?? '';

    // A stable accent per article, so a wall of image-less cards still has rhythm
    // instead of being one flat colour.
    $accents = ['#833bff', '#2f80ed', '#fc746c', '#35d0ba', '#f5a623', '#e0457b'];
    $accent = $accents[$post->id % count($accents)];
@endphp

<article class="art-card">
    <a class="art-card__link" href="{{ $aHref }}">
        @if ($aImage !== '')
            <span class="art-card__media">
                <img src="{{ image($aImage) }}" alt="{{ $aName }}" loading="lazy" width="800" height="500">
            </span>
        @else
            {{-- No image: set the title in the panel rather than showing a broken frame
                 or a grey placeholder. The article has a headline; use it. --}}
            <span class="art-card__media art-card__media--type"
                  style="--art-accent: {{ $accent }}">
                <span class="art-card__type">{{ \Illuminate\Support\Str::limit($aName, 64) }}</span>
            </span>
        @endif

        <span class="art-card__body">
            <span class="art-card__meta">
                @if ($aCat !== '')<span class="art-card__cat">{{ $aCat }}</span>@endif
                @if ($post->created_at)
                    <span class="art-card__date">{{ convertDateTime($post->created_at, 'd/m/Y') }}</span>
                @endif
            </span>

            {{-- When there is no cover image the panel above already sets the headline,
                 so repeating it here would print the same words twice on one card. --}}
            @if ($aImage !== '')
                <span class="art-card__title">{{ $aName }}</span>
            @endif

            @if ($aDesc !== '')
                <span class="art-card__desc">{{ \Illuminate\Support\Str::limit($aDesc, 110) }}</span>
            @endif

            <span class="art-card__more">Đọc bài</span>
        </span>
    </a>
</article>
