{{--
    Site header.

    Two rows, both square-cornered, and the header takes its place in the layout instead of
    floating over the hero — so no page has to guess its height and pad around it.

    The upper row is a thin violet strip: slogan on the left, social links on the right.
    The main row is logo, menu, a search button, and one call to action.

    The phone number is gone from here. It was in the upper strip, on the button next to
    it, and in the footer; three copies of the same number is not three chances to call.
--}}
@php
    $slogan = trim(strip_tags($system['homepage_slogan'] ?? ''));

    // Every channel that has been filled in, in a fixed order. Nothing is hard-coded:
    // an empty setting simply does not appear.
    $socialMap = [
        'facebook' => 'Facebook',
        'messenger' => 'Messenger',
        'zalo' => 'Zalo',
        'youtube' => 'YouTube',
        'tiktok' => 'TikTok',
        'instagram' => 'Instagram',
        'twitter' => 'X',
    ];

    $socials = [];
    foreach ($socialMap as $key => $label) {
        $value = trim((string) ($system['social_'.$key] ?? ''));
        if ($value === '') {
            continue;
        }

        // Zalo and Messenger are usually stored as a phone number, not a URL.
        $url = $value;
        if (!preg_match('~^https?://~i', $value)) {
            $digits = preg_replace('/\D+/', '', $value);
            $url = match ($key) {
                'zalo' => $digits !== '' ? 'https://zalo.me/'.$digits : null,
                'messenger' => 'https://m.me/'.ltrim($value, '@'),
                default => null,
            };
        }

        if ($url) {
            $socials[] = ['key' => $key, 'label' => $label, 'url' => $url];
        }
    }
@endphp

<header id="header" class="site-header uk-visible-large">

    {{-- ── Slogan and social ─────────────────────────────────────── --}}
    <div class="site-header__upper">
        <div class="uk-container uk-container-center">
            <div class="site-header__upper-row">
                <p class="site-header__slogan">{{ $slogan }}</p>

                @if (count($socials))
                    <ul class="site-social">
                        @foreach ($socials as $social)
                            <li>
                                <a href="{{ $social['url'] }}" title="{{ $social['label'] }}"
                                   target="_blank" rel="noopener" aria-label="{{ $social['label'] }}">
                                    @include('frontend.component.social-icon', ['key' => $social['key']])
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
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
                    {{-- One button, not a field. The form took the width of three menu
                         items to sit idle; the panel it opens has room for the suggestions
                         that make searching useful. --}}
                    <button type="button" class="site-search-open" data-search-open aria-label="Tìm kiếm">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" aria-hidden="true">
                            <circle cx="10.5" cy="10.5" r="6.5"/>
                            <path d="m15.4 15.4 4.1 4.1"/>
                        </svg>
                    </button>

                    <button type="button" class="site-header__cta" data-lead-open
                            data-lead-subject="TƯ VẤN THIẾT KẾ">Tư vấn ngay</button>
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
                    <button type="button" class="mobile-search" data-search-open aria-label="Tìm kiếm">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" aria-hidden="true">
                            <circle cx="10.5" cy="10.5" r="6.5"/><path d="m15.4 15.4 4.1 4.1"/>
                        </svg>
                    </button>
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
        @if(isset($menu['mobile']))
            <ul class="l1 uk-nav uk-nav-offcanvas uk-nav uk-nav-parent-icon" data-uk-nav>
                @foreach ($menu['mobile'] as $key => $val)
                    @php
                        $name = $val['item']->languages->first()->pivot->name;
                        // url('/') rather than '': an empty href reloads whatever page you are on, so the
                        // home link in the mobile menu never went home.
                        $canonical = ($name == 'Trang chủ') ? url('/') : write_url($val['item']->languages->first()->pivot->canonical, true, true);
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
