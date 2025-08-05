@extends('frontend.homepage.layout')
@section('content')
    @php
        $canonical = write_url($product->languages->first()->pivot->canonical);
        $link = $product->link;
    @endphp
    <div id="view-demo" class="view-demo">
        <div class="demo-header">
            <div class="uk-container uk-container-center">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-medium-1-3">
                        <a href="{{ $canonical }}" class="view-back">
                            <i class="icon-view-back"></i>
                            Quay về xem chi tiết
                        </a>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="view-type">
                            <a class="type-item desktop current" href="javascript:void()">
                                <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14 0H2C.897 0 0 .897 0 2v8c0 1.103.897 2 2 2h4.667v2h-2c-.552 0-1 .447-1 1 0 .553.448 1 1 1h6.667c.552 0 1-.447 1-1 0-.553-.448-1-1-1h-2v-2H14c1.104 0 2-.897 2-2V2c0-1.103-.896-2-2-2zM2 10V2h12v8H2z"></path>
                                </svg>
                                Desktop
                            </a>
                            <a class="type-item mobile" href="javascript:void()">
                                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.7 0H6.3C5.6 0 5 .6 5 1.3v21.3c0 .8.6 1.4 1.3 1.4h12.3c.7 0 1.4-.587 1.4-1.287V1.3c0-.7-.6-1.3-1.3-1.3zm-6.2 22.6c-.7 0-1.3-.6-1.3-1.3 0-.7.6-1.3 1.3-1.3.7 0 1.3.6 1.3 1.3 0 .7-.6 1.3-1.3 1.3zm4.5-4c0 .2-.2.4-.4.4H8.4c-.2 0-.4-.2-.4-.4V3.4c0-.2.2-.4.4-.4h8.1c.3 0 .5.2.5.4v15.2z"></path>
                                </svg>
                                Mobile
                            </a>
                            <a class="type-item tablet" href="javascript:void()">
                                <svg height="48" viewBox="0 0 48 48" width="48" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M37 0h-28c-2.76 0-5 2.24-5 5v38c0 2.76 2.24 5 5 5h28c2.76 0 5-2.24 5-5v-38c0-2.76-2.24-5-5-5zm-14 46c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm15-8h-30v-32h30v32z"></path>
                                </svg>
                                Tablet
                            </a>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    #header{
        display: none;
    }
    .footer{
        display: none;
    }
    .copyright{
        display: none;
    }
</style>