@if($widgets['categories'])
    <div class="panel-categories page">
        <div class="uk-container uk-container-center">
            <div class="panel-head">
                <h2 class="heading-2"><span>{{ $widgets['categories']->name }}</span></h2>
            </div>
            @if(count($widgets['categories']->object))
            <div class="panel-body">
                <div class="uk-grid uk-grid-medium">
                    @foreach($widgets['categories']->object as $key => $val)
                    @php
                        $name = $val->languages->first()->pivot->name;
                        $canonical = write_url($val->languages->first()->pivot->canonical);
                        $image = $val->image;
                        $description = $val->description;
                    @endphp
                    <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3 mb20">
                        <div class="categories-item">
                            <span class="image img-cover img-zoomin"><img src="{{ $image }}" alt="{{ $name }}"></span>
                            <div class="info">
                                <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
                                <div class="description">
                                    {{ $description ?? "Pellentesque cosmo dinciduntos" }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif