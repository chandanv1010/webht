<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Services\Interfaces\WidgetServiceInterface  as WidgetService;
use Jenssegers\Agent\Facades\Agent;

class ContactController extends FrontendController
{
    protected $language;
    protected $system;
    protected $widgetService;

    public function __construct(
        WidgetService $widgetService,
    ){
        $this->widgetService = $widgetService;
        parent::__construct(); 
    }


    public function index(Request $request){
        // The old page rendered a showroom grid and a "tin nổi bật" column left over from
        // a furniture site. Neither belongs on a contact page, and loading them cost two
        // widget lookups plus their posts on every visit.
        $widgets = [];
        $config = $this->config();
        $system = $this->system;
        $seo = [
            'meta_title' => 'Liên hệ HT Việt Nam — gọi '.($system['contact_hotline'] ?? '').' hoặc để lại yêu cầu',
            'meta_description' => 'Liên hệ '.($system['homepage_company'] ?? '').': hotline '
                .($system['contact_hotline'] ?? '').', email '.($system['contact_email'] ?? '')
                .'. Để lại yêu cầu, chúng tôi gọi lại trong 1 giờ làm việc.',
            'meta_keyword' => '',
            'meta_image' => '',
            'canonical' => write_url('lien-he')
        ];
        if(Agent::isMobile()){
            $template = 'mobile.contact.index';
        }else{
            $template = 'frontend.contact.index';
        }
        return view($template, compact(
            'widgets',
            'config',
            'seo',
            'system',
        ) + ['dark' => true]);
    }

    private function config(){
        return [
            'language' => $this->language,
            // select2 and location.js were loaded for a province/ward picker this page no
            // longer has, and cart.js for a cart the site does not use. The page now needs
            // only the store theme it shares with the rest of the site.
            'css' => [
                'frontend/resources/store.css',
                'frontend/resources/contact.css',
            ],
            'js' => []
        ];
    }

}
