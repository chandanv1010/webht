
@include('seller.dashboard.component.breadcrumb', ['title' => $config['seo']['index']['title']])
<div class="row mt20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title uk-flex uk-flex-middle uk-flex-space-between">
                <h5>{{ $config['seo']['index']['table']; }} </h5>
                @include('seller.dashboard.component.toolbox', ['model' => $config['model']])
            </div>
            <div class="ibox-content">
                @include('seller.order.component.filter')
                @include('seller.order.component.table')
            </div>
        </div>
    </div>
</div>

