@extends('frontend.homepage.layout')
@section('content')
    <div class="product-catalogue page-wrapper">
        @include('frontend.component.breadcrumb', ['model' => $productCatalogue, 'breadcrumb' => $breadcrumb])
        <div class="product-catalogue-wrapper">
            <div class="uk-container uk-container-center">
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
                <h1 class="page-heading">{{ $productCatalogue->languages->first()->pivot->name }}</h1>
            </div>
        </div>
        <div class="panel-body mb30">
            <div class="uk-container uk-container-center mt20">
                <div class="wrapper ">
                    <div class="gray-box mb20">
                        <h1 class="heading-2"><span></span></h1>
                    </div>
                    @if(!is_null($products))
                        <div class="product-list">
                            <div class="uk-grid uk-grid-medium">
                                @foreach($products as $product)
                                    <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3 mb20">
                                        @include('frontend.component.p-item', ['product'  => $product])
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="uk-flex uk-flex-center">
                            @include('frontend.component.pagination', ['model' => $products])
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="uk-container uk-container-center">
            <div class="description">
                {!! $productCatalogue->languages->first()->pivot->description !!}
            </div>
        </div>
    </div>
    <div class="mt--80">
        @include('frontend.component.news')
    </div>
@endsection
