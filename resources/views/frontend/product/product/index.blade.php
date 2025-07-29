@php
    $name = $product->name;
    $canonical = write_url($product->canonical);
    $image = image($product->image);
    $price = getPrice($product);
    $catName = $productCatalogue->name;
    $review = getReview($product);
    $description = $product->description;
    $content = $product->content;
    $attributeCatalogue = $product->attributeCatalogue;
    $gallery = json_decode($product->album);
@endphp

@extends('frontend.homepage.layout')
@section('content')


<div class="product-container">
    @include('frontend.component.breadcrumb', ['model' => $product, 'breadcrumb' => $breadcrumb])
    <div class="uk-container uk-container-center">
        <div class="panel-head">
            {{-- @if(!is_null($menu['main-menu_array']))
                @foreach($menu['main-menu_array'] as $key => $val)
                    @if($key !== 2 ) @continue @endif
                    <ul class="children">
                        @foreach($val['children'] as $key2 => $item)
                            @php
                                $name = $item['item']->languages->first()->pivot->name;
                                $canonical = write_url($item['item']->languages->first()->pivot->canonical);
                            @endphp
                        <li>
                            <a href="{{ $canonical }}" title="{{ $name }}" class="{{ $item['item']->languages->first()->pivot->canonical == $productCatalogue->canonical ? 'active' : '' }}">{{ $name }}</a>
                        </li>
                        @endforeach
                    </ul>
                @endforeach
            @endif --}}
            @if(!is_null($children))
                <ul class="children">
                    @foreach($children as $key => $item)
                        @php
                            $name = $item->languages->first()->pivot->name;
                            $canonical = write_url($item->languages->first()->pivot->canonical);
                        @endphp
                        <li>
                            <a href="{{ $canonical }}" title="{{ $name }}" class="{{ $item->languages->first()->pivot->canonical == $productCatalogue->canonical ? 'active' : '' }}">{{ $name }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
            <h1 class="product-detail-name ">{{ $product->name }}</h1>
            <div class="product-detail-container">
                <div class="product-detail-gallery">
                    @include('frontend.product.product.component.gallery')
                </div> <div class="product-detail-info">
                    @include('frontend.product.product.component.info',['voucher_product' => $voucher_product])
                </div>
            </div>
        </div>
        <div class="panel-body">
            @include('frontend.product.product.component.general')
        </div>
    </div>
    <div class="product-related">
        <div class="uk-container uk-container-center">
            <div class="panel-product">
                <div class="main-heading">
                    <div class="panel-head">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between">
                            <h2 class="heading-1"><span>Sản phẩm liên quan</span></h2>
                        </div>
                    </div>
                </div>
                <div class="panel-body list-product">
                    @if(count($productRelated))
                        <div class="uk-grid uk-grid-medium">
                            @foreach($productRelated as $index => $item)
                                @if($item->id != $product->id)
                                    @if($index > 6) @break @endif
                                    <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3 uk-width-large-1-3 mb20">
                                        @include('frontend.component.p-item', ['product' => $item])
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('frontend.component.news')
</div>
@include('frontend.product.product.component.modal')
@include('frontend.product.product.component.hidden')

@endsection
