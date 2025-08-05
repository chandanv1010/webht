<div class="buyer-task">
    <ul class="uk-list uk-clearfix">
        @foreach(__('buyer.module') as $key => $val)
        <li>
            <span>{{ $val['title'] }}</span>
            @if(isset($val['subModule']))
            <ul class="uk-list uk-clearfix main-task">
                @foreach($val['subModule'] as $module)
                <li>
                    <a href="{{ $module['route'] }}">
                        <i class="{{ $module['icon'] }}"></i>
                        <span>{{ $module['title'] }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
            @endif
        </li>
        @endforeach
    </ul>
</div>