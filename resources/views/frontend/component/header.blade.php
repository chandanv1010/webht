{{--
    Site header.

    Two rows. The upper one carries the slogan and nothing else — it used to hold the
    email and phone, which duplicated the CTA button directly below it. The main row is
    logo, menu, search, the call button, and the social links.

    The search field is its own element rather than a magnifier glued into the toolbox.
    The old one expanded on hover, which flickered without end: expanding moved the button
    out from under the cursor, the form lost hover, it collapsed, the button came back
    under the cursor, and it expanded again. It is now always open.

    Social icons are inline monochrome SVG. The previous PNGs were the platforms' own
    brand colours at full saturation, three bright squares pulling attention away from
    everything the header exists for.
--}}
@php
    $slogan = trim(strip_tags($system['homepage_slogan'] ?? ''));
    $hotline = $system['contact_hotline'] ?? '';

    $socials = array_values(array_filter([
        !empty($system['social_facebook']) ? ['key' => 'facebook', 'label' => 'Facebook', 'url' => $system['social_facebook']] : null,
        !empty($system['social_youtube']) ? ['key' => 'youtube', 'label' => 'YouTube', 'url' => $system['social_youtube']] : null,
        !empty($system['social_tiktok']) ? ['key' => 'tiktok', 'label' => 'TikTok', 'url' => $system['social_tiktok']] : null,
    ]));
@endphp

<header id="header" class="site-header uk-visible-large {{ (isset($dark) && $dark === true) ? 'white-text-mode' : '' }}">

    {{-- ── Slogan, and search on its own row ─────────────────────── --}}
    <div class="site-header__upper">
        <div class="uk-container uk-container-center">
            <div class="site-header__upper-row">
                <p class="site-header__slogan">{{ $slogan }}</p>

                {{-- Search lives up here rather than in the toolbox below: the menu needs
                     every pixel of the main row, and a search field wedged between the
                     menu and the call button read as an afterthought. --}}
                <form action="{{ route('product.catalogue.search') }}" method="get"
                      class="site-search" role="search">
                    <label class="uk-hidden" for="header-search-input">Tìm kiếm giao diện</label>
                    <input
                        id="header-search-input"
                        type="search"
                        name="keyword"
                        value="{{ request('keyword') }}"
                        placeholder="Tìm giao diện, mẫu website…"
                        autocomplete="off">
                    <button type="submit" aria-label="Tìm kiếm">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" aria-hidden="true">
                            <circle cx="10.5" cy="10.5" r="6.5"/>
                            <path d="m15.4 15.4 4.1 4.1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Main row ──────────────────────────────────────────────── --}}
    <div class="site-header__main">
        <div class="uk-container uk-container-center">
            <div class="site-header__row">

                <a href="{{ url('/') }}" class="site-header__logo" title="{{ $system['homepage_company'] ?? '' }}">
                    <img src="{{ $system['homepage_logo'] }}" alt="{{ $system['homepage_brand'] ?? '' }}">
                </a>

                @include('frontend.component.navigation')

                <div class="site-header__tools">

                    <a class="site-header__call" href="{{ tel_href($hotline) }}">{{ $hotline }}</a>

                    <button type="button" class="site-header__cta" data-lead-open
                            data-lead-subject="Nút tư vấn trên header">Tư vấn</button>

                    @if (count($socials))
                        <ul class="site-social">
                            @foreach ($socials as $social)
                                <li>
                                    <a href="{{ $social['url'] }}" title="{{ $social['label'] }}"
                                       target="_blank" rel="noopener" aria-label="{{ $social['label'] }}">
                                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                            @switch($social['key'])
                                                @case('facebook')
                                                    <path d="M13.5 21v-8h2.7l.4-3.1h-3.1V7.9c0-.9.25-1.5 1.55-1.5h1.65V3.6c-.3-.04-1.3-.13-2.45-.13-2.43 0-4.1 1.48-4.1 4.2v2.34H7.4V13h2.2v8h3.9Z"/>
                                                    @break
                                                @case('youtube')
                                                    <path d="M21.2 7.8a2.6 2.6 0 0 0-1.83-1.84C17.74 5.5 12 5.5 12 5.5s-5.74 0-7.37.46A2.6 2.6 0 0 0 2.8 7.8C2.35 9.43 2.35 12 2.35 12s0 2.57.45 4.2a2.6 2.6 0 0 0 1.83 1.84c1.63.46 7.37.46 7.37.46s5.74 0 7.37-.46a2.6 2.6 0 0 0 1.83-1.83c.45-1.64.45-4.21.45-4.21s0-2.57-.45-4.2ZM10.15 15.1V8.9L15.5 12l-5.35 3.1Z"/>
                                                    @break
                                                @default
                                                    <path d="M16.6 5.82A4.28 4.28 0 0 1 15.54 3h-3.09v12.4a2.59 2.59 0 1 1-1.84-2.48V9.8a5.64 5.64 0 1 0 4.68 5.56V8.99a7.2 7.2 0 0 0 4.21 1.35V7.25a4.26 4.26 0 0 1-2.9-1.43Z"/>
                                            @endswitch
                                        </svg>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>


<div class="mobile-header uk-hidden-large" data-uk-sticky>
    <div class="mobile-upper">
        <div class="uk-container uk-container-center">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="mobile-logo">
                    <a href="{{ url('/') }}" title="{{ $system['seo_meta_title'] ?? '' }}" class="image img-cover">
                        <img src="{{ $system['homepage_logo'] }}" alt="{{ $system['homepage_brand'] ?? '' }}">
                    </a>
                </div>
                <div class="tool uk-flex uk-flex-middle">
                    <a class="mobile-call" href="{{ tel_href($hotline) }}" aria-label="Gọi {{ $hotline }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                             stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4.5 3.5h3l1.6 4-2 1.4a11.5 11.5 0 0 0 6 6l1.4-2 4 1.6v3a1.5 1.5 0 0 1-1.7 1.5C9.7 18.3 5.7 14.3 3 6.2A1.5 1.5 0 0 1 4.5 3.5Z"/>
                        </svg>
                    </a>
                    <div class="menu-link">
                        <a href="#mobileCanvas" class="mobile-menu-button" data-uk-offcanvas aria-label="Mở menu">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 448 512" class="w-6 h-6 cursor-pointer  pl-3 box-content"><path d="M0 88c0-13.3 10.7-24 24-24h400c13.3 0 24 10.7 24 24s-10.7 24-24 24H24c-13.3 0-24-10.7-24-24m0 160c0-13.3 10.7-24 24-24h400c13.3 0 24 10.7 24 24s-10.7 24-24 24H24c-13.3 0-24-10.7-24-24m448 160c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24s10.7-24 24-24h400c13.3 0 24 10.7 24 24"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="mobileCanvas" class="uk-offcanvas offcanvas" >
    <div class="uk-offcanvas-bar" >
        <form action="{{ route('product.catalogue.search') }}" method="get" class="offcanvas-search" role="search">
            <label class="uk-hidden" for="mobile-search-input">Tìm kiếm giao diện</label>
            <input id="mobile-search-input" type="search" name="keyword" placeholder="Tìm giao diện…" autocomplete="off">
            <button type="submit" aria-label="Tìm kiếm">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                    <circle cx="10.5" cy="10.5" r="6.5"/><path d="m15.4 15.4 4.1 4.1"/>
                </svg>
            </button>
        </form>

        @if(isset($menu['mobile']))
            <ul class="l1 uk-nav uk-nav-offcanvas uk-nav uk-nav-parent-icon" data-uk-nav>
                @foreach ($menu['mobile'] as $key => $val)
                    @php
                        $name = $val['item']->languages->first()->pivot->name;
                        $canonical = ($name == 'Trang chủ') ?  '' : write_url($val['item']->languages->first()->pivot->canonical, true, true);
                    @endphp
                    <li class="l1 {{ (count($val['children']))?'uk-parent uk-position-relative':'' }}">
                        <?php echo (isset($val['children']) && is_array($val['children']) && count($val['children']))?'<a href="#" title="" class="dropicon"></a>':''; ?>
                        <a href="{{ $canonical }}" title="{{ $name }}" class="l1">{{ $name }}</a>
                        @if(count($val['children']))
                        <ul class="l2 uk-nav-sub">
                            @foreach ($val['children'] as $keyItem => $valItem)
                            @php
                                $name_2 = $valItem['item']->languages->first()->pivot->name;
                                $canonical_2 = write_url($valItem['item']->languages->first()->pivot->canonical, true, true);
                            @endphp
                            <li class="l2">
                                <a href="{{ $canonical_2 }}" title="{{ $name_2 }}" class="l2">{{ $name_2 }}</a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
		@endif
	</div>
</div>
