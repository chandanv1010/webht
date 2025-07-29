<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Repositories\Interfaces\SlideRepositoryInterface  as SlideRepository;
use App\Repositories\Interfaces\SystemRepositoryInterface  as SystemRepository;
use App\Services\Interfaces\WidgetServiceInterface  as WidgetService;
use App\Services\Interfaces\SlideServiceInterface  as SlideService;
use App\Enums\SlideEnum;
use Jenssegers\Agent\Facades\Agent;


class HomeController extends FrontendController
{
    protected $language;
    protected $slideRepository;
    protected $systemRepository;
    protected $widgetService;
    protected $slideService;
    protected $system;

    public function __construct(
        SlideRepository $slideRepository,
        WidgetService $widgetService,
        SlideService $slideService,
        SystemRepository $systemRepository,
    ){
        $this->slideRepository = $slideRepository;
        $this->widgetService = $widgetService;
        $this->slideService = $slideService;
        $this->systemRepository = $systemRepository;

        parent::__construct(
           $systemRepository,
        ); 
    }


    public function index(){
        $config = $this->config();
        $widgets = $this->widgetService->getWidget([
            ['keyword' => 'feedback','object' => true],
        ], $this->language);
        // dd($widgets['feedback']);

        $slides = $this->slideService->getSlide(
            [SlideEnum::BANNER, SlideEnum::MAIN, 'mobile-slide' , 'banner-1', 'brand-baochi'],
            $this->language
        );
        $system = $this->system;
        $seo = [
            'meta_title' => $this->system['seo_meta_title'],
            'meta_keyword' => $this->system['seo_meta_keyword'],
            'meta_description' => $this->system['seo_meta_description'],
            'meta_image' => $this->system['seo_meta_images'],
            'canonical' => config('app.url'),
        ];

        $language = $this->language;
  
        $schema = $this->schema($seo);
        
        $ishome = true;

      
        $template = 'frontend.homepage.home.index';

        return view($template, compact(
            'config',
            'slides',
            'widgets',
            'seo',
            'system',
            'language',
            'ishome',
            'schema'
        ));
    }

    public function ckfinder(){
        return view('frontend.homepage.home.ckfinder');
    }


    private function schema($seo){
        $schema = "<script type='application/ld+json'>
            {
                \"@context\": \"https://schema.org\",
                \"@type\": \"WebSite\",
                \"name\": \"" . $seo['meta_title'] . "\",
                \"url\": \"" . $seo['canonical'] . "\",
                \"description\": \"" . $seo['meta_description'] . "\",
                \"publisher\": {
                    \"@type\": \"Organization\",
                    \"name\": \"" . $seo['meta_title'] . "\"
                },
                \"potentialAction\": {
                    \"@type\": \"SearchAction\",
                    \"target\": {
                        \"@type\": \"EntryPoint\",
                        \"urlTemplate\": \"" . $seo['canonical'] . "search?q={search_term_string}\"
                    },
                    \"query-input\": \"required name=search_term_string\"
                }
            }
            </script>";

        return $schema;
    }
  

    private function config(){
        return [
            'language' => $this->language,
            'css' => [
                'frontend/resources/plugins/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css',
                'frontend/resources/plugins/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css'
            ],
            'js' => [
                'frontend/resources/plugins/OwlCarousel2-2.3.4/dist/owl.carousel.min.js',
                'https://getuikit.com/v2/src/js/components/sticky.js'
            ]
        ];
    }

    public function about(){
        $slides = $this->slideService->getSlide(
            [SlideEnum::BANNER, SlideEnum::MAIN, 'mobile-slide' , 'banner-1', 'brand-baochi'],
            $this->language
        );
        $config = $this->config();
        $system = $this->system;
        $seo = [
            'meta_title' => 'Giới thiệu về HT VIỆT NAM - Đơn vị thiết kế Website hàng đầu Việt Nam',
            'meta_keyword' => 'HTVIETNAM, htvietnam',
            'meta_description' => 'HT Việt Nam là đơn vị thiết kế website hàng đầu, chuyên cung cấp giải pháp web chuyên nghiệp, chuẩn SEO, tối ưu giao diện và hiệu quả kinh doanh.',
            'meta_image' => $this->system['seo_meta_images'],
            'canonical' => write_url('ve-chung-toi'),
        ];
        $widgets = $this->widgetService->getWidget([
            ['keyword' => 'feedback','object' => true],
        ], $this->language);

        $dark = true;
        $language = $this->language;
        $template = 'frontend.homepage.home.about';
        return view($template, compact(
            'config',
            'seo',
            'system',
            'language',
            'dark',
            'slides',
            'widgets'
        ));
    }

    public function hosting(){
        $slides = $this->slideService->getSlide(
            [SlideEnum::BANNER, SlideEnum::MAIN, 'mobile-slide' , 'banner-1', 'brand-baochi'],
            $this->language
        );
        $config = $this->config();
        $system = $this->system;
        $seo = [
            'meta_title' => 'Dịch vụ Hosting Chuyên Nghiệp - Tốc độ cao, Bảo mật vượt trội | HT VIỆT NAM',
            'meta_keyword' => 'HTVIETNAM, htvietnam, HTVIETNAM Hosting. hosting',
            'meta_description' => 'HT Việt Nam cung cấp dịch vụ hosting tốc độ cao, ổn định, bảo mật và hỗ trợ 24/7. Giải pháp lưu trữ tối ưu cho website doanh nghiệp, sẵn sàng mở rộng khi cần.',
            'meta_image' => $this->system['seo_meta_images'],
            'canonical' => write_url('dich-vu-hosting'),
        ];
        $widgets = $this->widgetService->getWidget([
            ['keyword' => 'feedback','object' => true],
        ], $this->language);

        // $dark = true;
        $language = $this->language;
        $template = 'frontend.homepage.home.hosting';
        return view($template, compact(
            'config',
            'seo',
            'system',
            'language',
            // 'dark',
            'slides',
            'widgets'
        ));
    }

}
