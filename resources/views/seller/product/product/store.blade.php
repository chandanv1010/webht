@include('seller.dashboard.component.breadcrumb', ['title' => $config['seo'][$config['method']]['title']])
@include('seller.dashboard.component.formError')
@php
    $url = ($config['method'] == 'create') ? route('seller.product.store') : route('seller.product.update', [$product->id, $queryUrl ?? '']);
@endphp
<form action="{{ $url }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{ __('messages.tableHeading') }}</h5>
                    </div>
                    <div class="ibox-content">
                        @include('seller.dashboard.component.content', ['model' => ($product) ?? null])
                    </div>
                </div>
               @include('seller.dashboard.component.album', ['model' => ($product) ?? null])
               @include('seller.product.product.component.variant')
               @include('seller.dashboard.component.seo', ['model' => ($product) ?? null])
            </div>
            <div class="col-lg-3">
                @include('seller.product.product.component.aside')
            </div>
        </div>
        @include('seller.dashboard.component.button')
    </div>
</form>
