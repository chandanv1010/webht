@extends('frontend.homepage.layout')
@section('content')
    <div class="product-catalogue page-wrapper">
        <div class="pdc-banner">
            <div class="panel-head">
                <div class="uk-container uk-container-center">
                    <h2 class="heading-1">
                        {!! $productCatalogue->description !!}
                    </h2>
                    <div class="content">
                        {!! $productCatalogue->content !!}
                    </div>
                    <div class="block-btn widget-toc">
                        <a href="#kho-giao-dien" class="scroll-down btn-registration">
                            Khám phá kho giao diện
                        </a>
                        <img class="arrow-cr-down" src="/userfiles/image/theme/arrow-btn.png" alt="Giao diện website bán hàng cực đẹp">
                    </div>
                </div>
            </div>
        </div>
        <div id="kho-giao-dien" class="panel-body">
            <div class="uk-container-1905 uk-container-center">
                <div class="uk-grid uk-grid-collapse">
                    <div class="uk-width-medium-1-5">
                        <div class="browse-filters">
                            <div class="search">
                                <div class="control-search">
                                    <form action="" method="post">
                                        <label>
                                            <span class="icon icon-search"></span>
                                            <input type="text" class="terms" name="keyword" value="" placeholder="Tìm kiếm những kết quả này..." autocomplete="off" autocapitalize="off">
                                        </label>
                                    </form>
                                </div>
                            </div>
                            <div class="bucket">
                                <div class="filter">
                                    <span class="name">Chủ đề</span>
                                </div>
                                @if(!is_null($children))
                                    @foreach($children as $item)
                                        @php
                                            $name = $item->languages->first()->pivot->name;
                                            $canonical= write_url($item->languages->first()->pivot->canonical);
                                            $product_count = $item->product_count;
                                        @endphp
                                        <div class="option">
                                            <label class="custom-checkbox">
                                                <input type="checkbox" name="filter[]" value="{{ $item->id }}">
                                                <span class="checkmark"></span>
                                            </label>
                                            <a class="name" href="{{ $canonical }}">
                                                {{ $name }}
                                            </a>
                                            <span class="total">{{ $product_count }}</span>
                                        </div>
                                    @endforeach
                                @endif
                                <button class="ui-button show-more">
                                    <span class="icon icon-more"></span>
                                    <span class="caption">Hiển thị thêm</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-4-5">
                        <div class="browse-items">
                            <div class="browse-tools">
                                <div class="filter-tools">
                                    <button class="button button-outline button-pill toggle-filters">
                                        <span class="icon icon-filters"></span><span class="caption">Ẩn bộ lọc</span>
                                    </button>
                                </div>
                                <div class="dropdown dropdown-align-right sort-options">
                                    <button class="button button-outline button-pill dropdown-toggle" title="Sort" aria-label="Sort">
                                        <span class="overflow">Phổ Biến Nhất</span>
                                        <span class="icon icon-dropdown indicator"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-large dropdown-menu-gap dropdown-menu-span dropdown-menu-icons">
                                        <div class="menu-items">
                                            <div class="menu-item"><a href="/all"><span class="icon icon-check"></span>Phổ biến nhất</a></div>
                                            <div class="menu-item"><a href="/all?sort=sales">Bán chạy nhất</a></div>
                                            <div class="menu-item"><a href="/all?sort=recent">Mới nhất</a></div>
                                            <div class="menu-item"><a href="/all?sort=updated">Cập nhật</a></div>
                                            <div class="menu-item"><a href="/all?sort=price">Giá thấp nhất</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item-grid">
                                @if(isset($products) && !is_null($products))
                                    @foreach($products as $product)
                                        @include('frontend.component.product-item', ['product'=> $product])
                                    @endforeach
                                @endif
                            </div>
                            <div class="uk-flex uk-flex-center full">
                                @include('frontend.component.pagination', ['model' => $products])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    body{
        background: none !important;
    }
</style>