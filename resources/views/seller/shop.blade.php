
@extends('frontend.homepage.layout')

@section('content')
    <div class="shop-container">
        <div class="uk-container uk-container-center">
            <h2 class="heading-2"><span>Shop của {{ $seller->name }}</span></h2>
            <div class="panel-body">
                <div class="uk-grid uk-grid-medium">
                    @foreach($products as $product)
                    <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3 uk-width-large-1-4 mb20">
                        @include('frontend.component.product-item', ['product'  => $product])
                    </div>
                     @endforeach
                </div>
            </div>
            <div class="uk-flex uk-flex-center">
                @include('frontend.component.pagination', ['model' => $products])
            </div>
        </div>
    </div>
@endsection
