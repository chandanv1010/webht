@php
    $name = $product->name;
    $canonical = write_url($product->languages->first()->pivot->canonical);
    $link_demo = write_url('demo/'.$product->languages->first()->pivot->canonical);
    $image = image($product->image);
    $price = getPrice($product);
    $cat_name = $product->product_catalogues[0]->languages->first()->pivot->name;
    $cat_canonical = write_url($product->product_catalogues[0]->languages->first()->pivot->canonical);
    $price = getPrice($product);
@endphp
<div class="item">
    <a href="{{ $canonical }}" title="{{ $name }}" class="image img-cover">
        <div class="skeleton-loading"></div>
        <img class="lazy-image" data-src="{{ $image }}" alt="{{ $name }}">
    </a>
    <div class="content">
        <div class="name">
            <h3 class="title">
                <a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a>
            </h3>
            <span class="exclusive" title="Sold Exclusively">
                <span class="icon icon-exclusive"></span>
            </span>
            <button class="ui-button bookmark " title="Add to Bookmarks">
                <span class="icon icon-bookmark"></span>
            </button>
        </div>
        <div class="category">
            <a href="{{ $cat_canonical}}" title="{{ $cat_name }}">{{ $cat_name }}</a>
        </div>
        <div class="details">
            <a class="component-user" href="">
                <img class="pfp" src="/userfiles/image/product/2e3dbab80ec85116f17c092a872ce4adfdc2d6198f2c98d88df8269cafe948ef.webp" alt="" loading="lazy">
                <span class="username">HtVietNam</span>
            </a>
            <span class="sales"><span class="icon icon-sales"></span>11.6K</span>
            {!! $price['html'] !!}
        </div>
        <div class="theme-action">
            <div class="button">
                <a href="{{ $link_demo }}" class="view-demo action-preview-theme btn-theme"  target="_blank" title="Xem thử">Xem thử</a>
                <a href="{{ $canonical }}" class="view-detail btn-theme" title="Chi tiết">Chi tiết</a>
            </div>
        </div>
    </div>
</div>
