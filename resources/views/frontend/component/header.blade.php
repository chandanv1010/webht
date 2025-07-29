<div id="header" class="pc-header uk-visible-large {{ (isset($dark) && $dark === true) ? 'white-text-mode' : '' }}">
    <div class="uk-container uk-container-center">
        <div class="header-upper">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="header-contact uk-flex uk-flex-middle">
                    <a href="to:{{ $system['contact_email'] }}">Email: {{ $system['contact_email'] }}</a>
                    <a href="tel:{{ $system['contact_hotline'] }}">Phone: {{ $system['contact_hotline'] }}</a>
                </div>
                @php
                    $socialList = ['facebook', 'youtube', 'tiktok'];
                @endphp
                <div class="header-social uk-flex uk-flex-middle">
                    @foreach($socialList as $key => $val)
                    <a href="{{ $system["social_{$val}"] }}" title="{{ $val }}" class="img-zoomin">
                        <img src="{{ asset('frontend/resources/img/icon/'.$val) }}.png" alt="">
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="header-middle">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <a href="" class="logo"><img src="{{ $system['homepage_logo'] }}" alt=""></a>
                {{-- <a href="" class="logo"><img src="https://xido-demo.pbminfotech.com/cybersecurity/wp-content/uploads/sites/28/2022/10/cybersecurity-logo.svg" alt=""></a> --}}
                @include('frontend.component.navigation')
                <div class="middle-toolbox uk-flex uk-flex-middle">
                    <form action="">
                        <button type="button"><img src="{{ asset('frontend/resources/img/search-interface-symbol.png') }}" alt=""></button>
                    </form>
                    <div class="middle-hotline">
                        <a class="button-style readmore" href="tel:{{ $system['contact_hotline'] }}">{{ $system['contact_hotline'] }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="mobile-header uk-hidden-large" data-uk-sticky>
    <div class="mobile-upper">
        <div class="uk-container uk-container-center">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="mobile-logo">
                    <a href="." title="{{ $system['seo_meta_title'] }}" class="image img-cover">
                        <img src="{{ $system['homepage_logo'] }}" alt="Mobile Logo">
                    </a>
                </div>
                <div class="tool">
                    <div class="menu-link">
                        <a href="#mobileCanvas" class="mobile-menu-button" data-uk-offcanvas>
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