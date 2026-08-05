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

        // Counted, not typed: a number on a hero that nobody can check is worth less than
        // no number at all.
        $templateCount = \App\Models\Product::where('publish', 2)->count();
        $heroStats = [
            ['value' => $templateCount.'+', 'label' => 'mẫu trong kho giao diện'],
            ['value' => '5', 'label' => 'nhóm dịch vụ'],
            ['value' => '12', 'label' => 'tháng bảo hành'],
        ];

        // The way most people enter a library: by their own industry.
        $heroCategories = \App\Models\ProductCatalogue::query()
            ->with(['languages' => fn ($q) => $q->where('language_id', $this->language)])
            ->where('publish', 2)
            ->where('parent_id', '!=', 0)
            ->orderBy('order')
            ->limit(6)
            ->get()
            ->map(fn ($c) => [
                'name' => $c->short_name ?: ($c->languages->first()?->pivot->name ?? ''),
                'canonical' => $c->languages->first()?->pivot->canonical ?? '',
            ])
            ->filter(fn ($c) => $c['name'] !== '' && $c['canonical'] !== '')
            ->values()
            ->all();

        $heroCovers = \App\Models\Product::query()
            ->where('publish', 2)
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->orderByDesc('id')
            ->limit(12)
            ->pluck('image');

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
            'schema',
            'heroStats',
            'heroCategories',
            'heroCovers'
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

    /**
     * One landing page per service, each with its own layout.
     *
     * They shared a template at first and the four pages came out indistinguishable. Each
     * now has its own view, built around the thing that decision actually turns on: a
     * process for bespoke work, a gallery for ready-made, a failure list for maintenance,
     * a month-by-month timeline for SEO. Shared copy stays in config/apps/services.php.
     */
    public function service(string $key)
    {
        $service = config('apps.services.'.$key);

        if (is_null($service)) {
            abort(404);
        }

        $slides = $this->slideService->getSlide(
            [SlideEnum::BANNER, SlideEnum::MAIN, 'mobile-slide', 'banner-1', 'brand-baochi'],
            $this->language
        );

        // The four landings share one stylesheet; the hosting page keeps style.css alone.
        $config = $this->config();
        $config['css'][] = 'frontend/resources/service.css';

        $system = $this->system;
        $language = $this->language;

        $seo = [
            'meta_title' => $service['meta_title'],
            'meta_keyword' => $service['meta_keyword'] ?? '',
            'meta_description' => $service['meta_description'],
            'meta_image' => $this->system['seo_meta_images'],
            'canonical' => write_url($service['canonical']),
        ];

        $widgets = $this->widgetService->getWidget([
            ['keyword' => 'feedback', 'object' => true],
        ], $this->language);

        // The ready-made page is a gallery, so it needs real templates rather than a
        // description of them. Only that page pays for the query.
        $templates = collect();
        if ($key === 'template') {
            $templates = \App\Models\Product::query()
                ->with(['languages' => fn ($q) => $q->where('language_id', $this->language)])
                ->where('publish', 2)
                ->whereNotNull('image')
                ->where('image', '!=', '')
                ->orderByDesc('id')
                ->limit(8)
                ->get();
        }

        // One view per service, not one shared template: each page is laid out around
        // what its own decision hinges on — a process, a gallery, a failure list, a
        // timeline — so they stop reading as four copies of the same brochure.
        return view('frontend.homepage.home.services.'.$key, compact(
            'config',
            'seo',
            'system',
            'language',
            'slides',
            'widgets',
            'service',
            'templates'
        ));
    }

    /**
     * The services index the menu points at.
     *
     * Browsing, not searching, so it takes the shape the store page takes: a billboard and
     * rows. The summary of each service lives here rather than in config/apps/services.php
     * because it exists only to help someone choose between them — the landing pages carry
     * the full argument.
     */
    public function serviceHub()
    {
        $config = $this->config();
        $config['css'][] = 'frontend/resources/store.css';
        $config['css'][] = 'frontend/resources/hub.css';

        $system = $this->system;
        $language = $this->language;

        $seo = [
            'meta_title' => 'Dịch vụ website — thiết kế, chăm sóc, hosting, SEO | HT Việt Nam',
            'meta_keyword' => 'dịch vụ thiết kế website, chăm sóc website, hosting, SEO',
            'meta_description' => 'Bốn cách làm website với cùng một đội: mẫu có sẵn từ 4,5 triệu, thiết kế riêng từ 25 triệu, chăm sóc từ 600 nghìn/tháng, SEO từ 6 triệu/tháng.',
            'meta_image' => $this->system['seo_meta_images'],
            'canonical' => write_url('dich-vu'),
        ];

        $services = collect([
            [
                'key' => 'template',
                'canonical' => 'thiet-ke-website-theo-mau-co-san',
                'name' => 'Website mẫu có sẵn',
                'price' => 'Từ 4,5 triệu',
                'when' => 'Bàn giao 5–7 ngày',
                'cta' => 'Xem mẫu',
                'lead' => 'Chọn một mẫu đã lập trình xong, chúng tôi mặc thương hiệu của bạn vào và đưa nội dung lên.',
                'points' => [
                    'Đã gồm hosting và tên miền năm đầu.',
                    'Không dùng chung bản cài đặt với ai.',
                    'Không đổi được bố cục sang thiết kế khác.',
                ],
            ],
            [
                'key' => 'custom',
                'canonical' => 'thiet-ke-theo-yeu-cau',
                'name' => 'Thiết kế theo yêu cầu',
                'price' => '25–90 triệu',
                'when' => '4–10 tuần',
                'cta' => 'Xem quy trình',
                'lead' => 'Vẽ mới từ đầu theo quy trình bán hàng thật của bạn, không cắt bớt nghiệp vụ để vừa một khuôn.',
                'points' => [
                    'Bàn giao toàn bộ mã nguồn và cơ sở dữ liệu.',
                    'Nối được với kế toán, kho, CRM, tổng đài.',
                    'Bảo hành lỗi kỹ thuật 12 tháng.',
                ],
            ],
            [
                'key' => 'care',
                'canonical' => 'cham-soc-website',
                'name' => 'Chăm sóc website',
                'price' => 'Từ 600 nghìn/tháng',
                'when' => 'Dừng lúc nào cũng được',
                'cta' => 'Xem ba gói',
                'lead' => 'Cập nhật bản vá, sao lưu hằng ngày, theo dõi 5 phút một lần, và có người nhấc máy khi trang sập.',
                'points' => [
                    'Sao lưu giữ 30 bản gần nhất.',
                    'Cam kết phản hồi 2 giờ với gói ưu tiên.',
                    'Không phí khởi tạo, không cam kết thời hạn.',
                ],
            ],
            [
                'key' => 'seo',
                'canonical' => 'dich-vu-seo',
                'name' => 'Dịch vụ SEO',
                'price' => 'Từ 6 triệu/tháng',
                'when' => 'Đánh giá sau 5–6 tháng',
                'cta' => 'Xem cách làm',
                'lead' => 'Kỹ thuật, nội dung và đo lường. Báo cáo theo lưu lượng và số liên hệ thực, không theo thứ hạng từ khoá lẻ.',
                'points' => [
                    'Không hứa top 1 trong 30 ngày.',
                    'Báo cáo trung thực cả khi số liệu đi xuống.',
                    'Cần nội dung và thời gian, không có đường tắt.',
                ],
            ],
            [
                'key' => 'hosting',
                'canonical' => 'dich-vu-hosting',
                'name' => 'Hosting & tên miền',
                'price' => 'Từ 55 nghìn/tháng',
                'when' => 'Chuyển sang miễn phí',
                'cta' => 'Xem gói hosting',
                'lead' => 'SSD tại Việt Nam hoặc Singapore, SSL miễn phí, sao lưu hằng ngày. Tên miền đứng tên bạn.',
                'points' => [
                    'Chuyển website đang chạy không mất dữ liệu.',
                    'Giữ máy chủ cũ song song 7 ngày.',
                    'Bạn nhận thông tin đăng nhập nhà đăng ký.',
                ],
            ],
        ]);

        // Real template covers behind the billboard, the same mosaic the store uses. It is
        // the only honest picture of what this company makes.
        $posters = \App\Models\Product::query()
            ->where('publish', 2)
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->orderByDesc('id')
            ->limit(18)
            ->pluck('image');

        $dark = true;

        return view('frontend.homepage.home.services.hub', compact(
            'config', 'seo', 'system', 'language', 'services', 'posters', 'dark'
        ));
    }

    /**
     * The video page.
     *
     * The old one was a five-across grid whose thumbnails linked to href="" — nothing on
     * it played. The featured video comes from the "Video youtube(pc)" setting so the
     * client controls it; the shelves come from config/apps/videos.php, which is honest
     * about there being no admin screen for a video list yet.
     */
    public function video()
    {
        $config = $this->config();
        $config['css'][] = 'frontend/resources/store.css';
        $config['css'][] = 'frontend/resources/video.css';

        $system = $this->system;
        $language = $this->language;

        // The setting holds a whole <iframe> snippet; take the id out of it.
        $featuredVideoId = null;
        $embed = (string) ($this->system['homepage_video_youtube_pc'] ?? $this->system['homepage_video_youtube'] ?? '');
        if (preg_match('~(?:embed/|v=|youtu\.be/)([A-Za-z0-9_-]{6,})~', $embed, $m)) {
            $featuredVideoId = $m[1];
        }

        $seo = [
            'meta_title' => 'Video hướng dẫn và giới thiệu | HT Việt Nam',
            'meta_keyword' => 'video hướng dẫn website, HTVIETNAM',
            'meta_description' => 'Cách chúng tôi làm việc, hướng dẫn dùng trang quản trị, và những câu hỏi khách hay hỏi nhất — trả lời bằng video.',
            'meta_image' => $this->system['seo_meta_images'],
            'canonical' => write_url('video'),
        ];

        $dark = true;

        return view('frontend.homepage.home.video', compact(
            'config', 'seo', 'system', 'language', 'featuredVideoId', 'dark'
        ));
    }

    /**
     * Bảng giá.
     *
     * It resolved to a Post whose body was a short list. The packages now live in
     * config/apps/pricing.php, which keeps the numbers in one place and out of the markup.
     */
    public function pricing()
    {
        $config = $this->config();
        $config['css'][] = 'frontend/resources/pricing.css';

        $system = $this->system;
        $language = $this->language;
        $pricing = config('apps.pricing');

        $seo = [
            'meta_title' => 'Bảng giá thiết kế website — ba gói, giá công khai | HT Việt Nam',
            'meta_keyword' => 'bảng giá thiết kế website, giá làm website',
            'meta_description' => 'Ba gói từ 4,5 triệu đến 11,9 triệu, đã gồm hosting và tên miền năm đầu. Kèm danh sách những khoản tính thêm, nói trước thay vì để bạn phát hiện sau.',
            'meta_image' => $this->system['seo_meta_images'],
            'canonical' => write_url('bang-gia'),
        ];

        return view('frontend.homepage.home.pricing', compact(
            'config', 'seo', 'system', 'language', 'pricing'
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

        $language = $this->language;
        $template = 'frontend.homepage.home.hosting';
        return view($template, compact(
            'config',
            'seo',
            'system',
            'language',
            'slides',
            'widgets'
        ));
    }

}
