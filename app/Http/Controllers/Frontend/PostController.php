<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Services\Interfaces\PostCatalogueServiceInterface as PostCatalogueService;
use App\Services\Interfaces\PostServiceInterface as PostService;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use App\Services\Interfaces\WidgetServiceInterface  as WidgetService;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\DB;
use App\Models\Post;

class postController extends FrontendController
{
    protected $language;
    protected $system;
    protected $postCatalogueRepository;
    protected $postCatalogueService;
    protected $postService;
    protected $postRepository;
    protected $widgetService;

    public function __construct(
        PostCatalogueRepository $postCatalogueRepository,
        PostCatalogueService $postCatalogueService,
        PostService $postService,
        PostRepository $postRepository,
        WidgetService $widgetService,
    ){
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->postCatalogueService = $postCatalogueService;
        $this->postService = $postService;
        $this->postRepository = $postRepository;
        $this->widgetService = $widgetService;
        parent::__construct(); 
    }


    public function index($id, $request){
        $language = $this->language;
        $post = $this->postRepository->getPostById($id, $this->language, config('apps.general.defaultPublish'));
        $viewed = $post->viewed;
        $updateViewed = Post::where('id', $id)->update(['viewed' => $viewed + 1]); 
        if(is_null($post)){
            abort(404);
        }
        $postCatalogue = $this->postCatalogueRepository->getPostCatalogueById($post->post_catalogue_id, $this->language);
        if($postCatalogue->id == 22 || $postCatalogue->id == 24 || $postCatalogue->id === 44){
            $postCatalogue->children = $this->postCatalogueRepository->findByCondition(
                [
                    ['publish' , '=', 2],
                    ['parent_id', '=', 21]
                ],
                true,
                [],
                ['order', 'desc']
            );
        }

        // dd(123);

        $breadcrumb = $this->postCatalogueRepository->breadcrumb($postCatalogue, $this->language);

        $config = $this->config();
        $system = $this->system;
        $seo = seo($post);

        // template 2 marks a standalone service page; anything else is an article.
        // This used to send template 1 to post.design and everything else to
        // post.index, which had it backwards: articles got the landing-page layout and
        // service pages got the article layout.
        if (Agent::isMobile()) {
            $template = 'mobile.post.post.index';
        } elseif ((int) $post->template === 2) {
            $template = 'frontend.post.post.service';
        } else {
            $template = 'frontend.post.post.index';
        }

        // Only the article templates show "bài viết khác"; a service page builds its own
        // row from the menu, so this 15-post query is skipped there.
        $asidePost = ($template === 'frontend.post.post.service')
            ? collect()
            : $this->postService->paginate(
                $request,
                $this->language,
                $postCatalogue,
                1,
                ['path' => $postCatalogue->canonical],
            );

        // Only the mobile template reads these. The desktop pages were loading six
        // widgets and their posts on every article and never rendering one of them.
        $widgets = str_starts_with($template, 'mobile.')
            ? $this->widgetService->getWidget([
                ['keyword' => 'news-feature'],
                ['keyword' => 'projects-feature'],
                ['keyword' => 'news'],
                ['keyword' => 'news-outstanding','object' => true],
                ['keyword' => 'design_construction_interior', 'object' => true],
                ['keyword' => 'showroom-system','object' => true],
            ], $this->language)
            : [];

        $schema = $this->schema($post, $postCatalogue, $breadcrumb);

        $extra = ['dark' => true];
        if ($template === 'frontend.post.post.service') {
            $extra['serviceSiblings'] = $this->serviceSiblings($post->id);
        }

        return view($template, compact(
            'config',
            'seo',
            'system',
            'breadcrumb',
            'postCatalogue',
            'post',
            'asidePost',
            'widgets',
            'schema'
        ) + $extra);
    }

    /**
     * The other service pages, for the row at the foot of a service page.
     *
     * Which pages count as services comes from the menu, not from the catalogue: every
     * standalone page — services, policies, FAQs — sits in the same catalogue, so
     * "other posts here" would offer someone reading about hosting a link to the payment
     * policy. Reading the menu means editing the menu keeps this row correct.
     *
     * Fetched by canonical rather than filtered out of the paginated aside list, so the
     * row is complete regardless of where those posts land in the pagination.
     */
    private function serviceSiblings(int $currentPostId)
    {
        // Two menu groups list the services: the header dropdown, which links to
        // /dich-vu.html, and the footer column, which is a heading with no link of its
        // own. Match on either so both sets of children count.
        $parents = DB::table('menu_language')
            ->where('language_id', $this->language)
            ->where(fn ($q) => $q
                ->where('canonical', 'dich-vu')
                ->orWhere('name', 'Dịch vụ'))
            ->pluck('menu_id');

        if ($parents->isEmpty()) {
            return collect();
        }

        $canonicals = DB::table('menus')
            ->join('menu_language', 'menu_language.menu_id', '=', 'menus.id')
            ->whereIn('menus.parent_id', $parents)
            ->where('menu_language.language_id', $this->language)
            ->whereNotNull('menu_language.canonical')
            ->distinct()
            ->pluck('menu_language.canonical');

        if ($canonicals->isEmpty()) {
            return collect();
        }

        return Post::query()
            ->with([
                'languages' => fn ($q) => $q->where('language_id', $this->language),
                'post_catalogues.languages' => fn ($q) => $q->where('language_id', $this->language),
            ])
            // config('apps.general.defaultPublish') is the ['publish','=',2] triple the
            // repositories expect, not a value — spelled out here because this is a plain
            // Eloquent query.
            ->where('posts.publish', 2)
            ->where('posts.id', '!=', $currentPostId)
            // Qualified: whereHas on `languages` joins the pivot, so both columns exist
            // twice in the subquery.
            ->whereHas('languages', fn ($q) => $q
                ->where('post_language.language_id', $this->language)
                ->whereIn('post_language.canonical', $canonicals))
            ->get();
    }

    private function schema($post, $postCatalogue, $breadcrumb){

        $image = $post->image;

        $name = $post->languages->first()->pivot->name;

        $description = plain_text($post->languages->first()->pivot->description);

        $canonical = write_url($post->languages->first()->pivot->canonical);

        $itemBreadcrumbElements = '';

        $positionBreadcrumb = 2;

        foreach ($breadcrumb as $key => $item) {

            $name = $item->languages->first()->pivot->name;

            $canonical = write_url($item->languages->first()->pivot->canonical);

            $itemBreadcrumbElements .= "
                {
                    \"@type\": \"ListItem\",
                    \"position\": $positionBreadcrumb,
                    \"name\": \"" . $name . "\",
                    \"item\": \"" . $canonical . "\",
                },";
            $positionBreadcrumb++;
        }

        $itemBreadcrumbElements = rtrim($itemBreadcrumbElements, ',');

        $schema = "
            <script type=\"application/ld+json\">
                {
                    \"@type\": \"BreadcrumbList\",
                    \"itemListElement\": [
                        {
                            \"@type\": \"ListItem\",
                            \"position\": 1,
                            \"name\": \" Trang chủ  \",
                            \"item\": \" ". config('app.url') . " \"
                        },
                        $itemBreadcrumbElements
                    ]
                },
                {
                    \"@context\": \"https://schema.org\",
                    \"@type\": \"BlogPosting\",
                    \"headline\": \" " . $name .  " \",
                    \"description\": \"  " . $description .  "  \",
                    \"image\": \"  " . $image .  "  \",
                    \"url\": \"  " . $canonical .  "  \",
                    \"datePublished\": \"  " . convertDateTime($post->created_at, 'd-m-y') .  "  \",
                    \"dateModified\": \"  " . convertDateTime($post->created_at, 'd-m-y') .  "  \",
                    \"author\": [
                        \"@type\": \"Person\",
                        \"name\": \"\",
                        \"url\": \"\",
                    ],
                    \"publisher\": [
                        \"@type\": \"Organization\",
                        \"name\": \" An Hưng  \",
                        \"logo\": [
                            \"@type\": \"ImageObject\",
                            \"url\": \"   \",
                        ],
                    ],
                    \"mainEntityOfPage\": [
                        \"@type\": \"Organization\",
                        \"@id\": \" " . $canonical . " \",
                    ],
                    \"articleSection\": \"  " . $postCatalogue->languages->first()->pivot->name .  "  \",
                    \" keywords \": \"  \",
                    \" timeRequired \": \"  \",
                    \"about\": [
                        \"@type\": \"Thing\",
                        \"name\": \" \",
                    ],
                    \"mentions\": [
                        {
                            \"@type\": \"Product\",
                            \"name\": \" \",
                        }
                    ],
                }
            </script>
        ";
        return $schema;

    } 

    private function config(){
        return [
            'language' => $this->language,
            'js' => [
                'frontend/core/library/cart.js',
                'frontend/core/library/product.js',
                'frontend/core/library/review.js',
                // Vendored. This was loaded from prohousevn.com — the site this codebase was
                // reused from. That host stopped answering, and a blocking <script>
                // from a dead host leaves the page loading until the browser gives
                // up, which is what made these pages hang.
                'frontend/resources/vendor/fancybox/jquery.fancybox.min.js'
            ],
            'css' => [
                'frontend/core/css/product.css',
                'frontend/resources/store.css',
                'frontend/resources/news.css',
                'frontend/resources/vendor/fancybox/jquery.fancybox.min.css'
            ]
        ];
    }

}
