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
        $widgets = $this->widgetService->getWidget([
            ['keyword' => 'showroom-system','object' => true],
            ['keyword' => 'news-outstanding','object' => true],
        ], $this->language);
        $config = $this->config();
        $system = $this->system;
        $seo = [
            'meta_title' => 'Trang Thông tin liên hệ',
            'meta_description' => 'Thông tin liên hệ của '.$system['homepage_company'],
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
        ));
    }

    private function config(){
        return [
            'language' => $this->language,
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'js' => [
                'backend/library/location.js',
                'frontend/core/library/cart.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ]
        ];
    }

}
