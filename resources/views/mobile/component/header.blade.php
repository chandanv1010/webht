<div class="mobile-header">
    <div class="mobile-upper">
        <div class="uk-container uk-container-center">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="mobile-logo">
                    <a href="." title="{{ $system['seo_meta_title'] }}" class="image img-cover">
                        <img src="{{ $system['homepage_logo'] }}" alt="Mobile Logo">
                    </a>
                    <form action="{{ 'tim-kiem' }}" class="search">
                        <input type="text" name="keyword" placeholder="Tìm kiếm">
                    </form>
                </div>
                <div class="tool">
                    <div class="cart-link">
                        <a href="{{ write_url('gio-hang') }}" title="" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 576 512" class="w-5 h-5 cursor-pointer fill-bottom-nav-mb  box-content"><path d="M0 24C0 10.7 10.7 0 24 0h45.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5l-51.6-271c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24m128 440a48 48 0 1 1 96 0 48 48 0 1 1-96 0m336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96"></path></svg>
                        </a>
                    </div>
                    <div class="menu-link">
                        <a href="#mobileCanvas" class="mobile-menu-button" data-uk-offcanvas>
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 448 512" class="w-6 h-6 cursor-pointer  pl-3 box-content"><path d="M0 88c0-13.3 10.7-24 24-24h400c13.3 0 24 10.7 24 24s-10.7 24-24 24H24c-13.3 0-24-10.7-24-24m0 160c0-13.3 10.7-24 24-24h400c13.3 0 24 10.7 24 24s-10.7 24-24 24H24c-13.3 0-24-10.7-24-24m448 160c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24s10.7-24 24-24h400c13.3 0 24 10.7 24 24"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('mobile.component.navigation')
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