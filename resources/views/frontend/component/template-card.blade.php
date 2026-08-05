{{--
    One template in the store. Used by both the shelves and the filtered grid, so the
    two views can never drift apart.

    Expects: $product (with languages and product_catalogues.languages eager-loaded)
--}}
@php
    $pivot = $product->languages->first()?->pivot;
    $name = $pivot->name ?? '';
    $href = write_url($pivot->canonical ?? '');
    $poster = image($product->image);
    $price = (int) $product->price;

    $catPivot = $product->product_catalogues->first()?->languages->first()?->pivot;
    $catName = $catPivot->name ?? '';
@endphp

<article class="tpl-card">
    <a class="tpl-card__link" href="{{ $href }}">
        <span class="tpl-card__poster">
            <img src="{{ $poster }}" alt="{{ $name }}" loading="lazy" width="720" height="450">
            {{-- Free templates get the loud badge; a price is information, "free" is an offer. --}}
            @if ($price === 0)
                <span class="tpl-card__badge tpl-card__badge--free">Miễn phí</span>
            @endif
        </span>

        <span class="tpl-card__body">
            @if ($catName !== '')
                <span class="tpl-card__cat">{{ $catName }}</span>
            @endif
            <span class="tpl-card__name">{{ $name }}</span>
            <span class="tpl-card__price">
                @if ($price === 0)
                    Miễn phí
                @else
                    {{ convert_price($price, true) }}<span class="tpl-card__unit">đ</span>
                @endif
            </span>
        </span>

        {{-- Revealed on hover/focus. Not a second link: the whole card is the link, so
             keyboard users get one stop instead of three. --}}
        <span class="tpl-card__hint" aria-hidden="true">Xem chi tiết</span>
    </a>
</article>
