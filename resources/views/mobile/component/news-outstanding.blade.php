@if(isset($widgets['news-outstanding']))
<div class="news-outstanding">
    <div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-medium">
            @foreach($widgets['news-outstanding']->object as $key => $val)
                <div class="uk-width-medium-1-3">
                    @php
                        $cat_title = $val->languages->name;
                        $cat_image = $val->image;
                    @endphp
                    <div class="news-post">
                        <h2 class="heading-1">
                            <span>{{ $cat_title }}</span>
                        </h2>
                        <a href="" class="image img-cover">
                            <img src="{{ $cat_image }}" alt="">
                        </a>
                        <div class="list-post">
                            @foreach($val->posts as $k => $post)
                                @php
                                    $title = $post->languages->first()->pivot->name;
                                    $canonical = write_url($post->languages->first()->pivot->canonical);
                                @endphp
                               <div class="post-item">
                                  <a href="{{ $canonical }}">{{ $title }}</a>
                               </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif