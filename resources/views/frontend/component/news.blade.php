
 @if(isset($widgets['news']))
        <div class="panel-news fix">
            <div class="uk-container uk-container-center">
                <div class="panel-head uk-text-center">
                    <div class="top-heading-1">Tin tức</div>
                    <h2 class="heading-5"><span>{{ $widgets['news']->name }}</span></h2>
                </div>
                <div class="panel-body">
                    <div class="uk-grid uk-grid-medium">
                        @foreach($widgets['news']->object as $key => $post)
                            @php
                                $name = $post->languages->name;
                                $canonical = write_url($post->languages->canonical);
                                $image = thumb($post->image, 600, 400);
                            @endphp
                            <div class="uk-width-medium-1-3 ">
                                <div class="news-item">
                                    <a href="{{ $canonical }}" title="{{ $name }}" class="image img-cover img-zoomin">
                                        <div class="skeleton-loading"></div>
                                        <img class="lazy-image" data-src="{{ $image }}" alt="{{ $name }}">
                                    </a>
                                    <div class="info">
                                        <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }} </a></h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
@endif