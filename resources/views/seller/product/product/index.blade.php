
@include('seller.dashboard.component.breadcrumb', ['title' => $config['seo']['index']['title']])
<div class="row mt20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{ $config['seo']['index']['table']; }} </h5>
                @include('seller.dashboard.component.toolbox', ['model' => 'productCatalogue'])
            </div>
            <div class="ibox-content">
                @include('seller.product.product.component.filter')
                @include('seller.product.product.component.table')
            </div>
        </div>
    </div>
</div>

