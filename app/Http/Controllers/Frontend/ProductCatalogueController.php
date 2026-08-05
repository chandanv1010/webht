<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use App\Services\Interfaces\ProductCatalogueServiceInterface as ProductCatalogueService;
use App\Services\Interfaces\ProductServiceInterface as ProductService;
use App\Services\Interfaces\WidgetServiceInterface as WidgetService;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use Cart;
use Jenssegers\Agent\Facades\Agent;
use Illuminate\Support\Facades\DB;

class ProductCatalogueController extends FrontendController
{
    protected $language;
    protected $system;
    protected $productCatalogueRepository;
    protected $productCatalogueService;
    protected $productService;
    protected $widgetService;
    protected $productRepository;

    public function __construct(
        ProductCatalogueRepository $productCatalogueRepository,
        ProductCatalogueService $productCatalogueService,
        ProductService $productService,
        ProductRepository $productRepository,
        WidgetService $widgetService,
    ){
        $this->productCatalogueRepository = $productCatalogueRepository;
        $this->productCatalogueService = $productCatalogueService;
        $this->productService = $productService;
        $this->widgetService = $widgetService;
        $this->productRepository = $productRepository;
        parent::__construct(); 
    }


    public function index($id, $request, $page = 1){
        
        $productCatalogue = $this->productCatalogueRepository->getProductCatalogueById($id, $this->language);

        $parent = null;

        $children = null;

        if($productCatalogue->parent_id != 0){
            $parent = $this->productCatalogueRepository->getParent($productCatalogue, $this->language);
            $children =  $this->productCatalogueRepository->getChildren($parent);
        }else{
            $children =  $this->productCatalogueRepository->getChildren($productCatalogue);
        }

        $filters = $this->filter($productCatalogue);

        $breadcrumb = $this->productCatalogueRepository->breadcrumb($productCatalogue, $this->language);

        $products = $this->productService->paginate(
            $request, 
            $this->language, 
            $productCatalogue, 
            $page,
            ['path' => $productCatalogue->canonical],
        );
        
        $products = $this->combineProductValues($products);

        $config = $this->config();

        $widgets = $this->widgetService->getWidget([
            ['keyword' => 'news','object' => true],
            ['keyword' => 'news-outstanding','object' => true],
            ['keyword' => 'projects-feature', 'object' => true],
            ['keyword' => 'design_construction_interior', 'object' => true],
            ['keyword' => 'showroom-system','object' => true],
        ], $this->language);

        $config = $this->config();

        $system = $this->system;

        $seo = seo($productCatalogue, $page);

        if(Agent::isMobile()){
            $template = 'mobile.product.catalogue.index';
        }else{
            $template = 'frontend.product.catalogue.index';
        }

        $schema = $this->schema($productCatalogue, $products, $breadcrumb);

        return view($template, compact(
            'children',
            'config',
            'seo',
            'system',
            'breadcrumb',
            'productCatalogue',
            'products',
            'filters',
            'widgets',
            'schema',
            // 'menus'
        ) + $this->storeBrowse($productCatalogue, $request, $parent ?? $productCatalogue, $children) + [
            // The store canvas is dark, so the floating header has to switch to its
            // white-text mode or the contact strip disappears into the billboard.
            'dark' => true,
        ]);
    }

    private function combineProductValues($products){
        $productId = $products->pluck('id')->toArray();
        if(count($productId) && !is_null($productId)){
            $products = $this->productService->combineProductAndPromotion($productId, $products);
        }

        return $products;
    }

    /**
     * Data for the template store browse page.
     *
     * The store is browsed as one place: whether the visitor lands on the root
     * (kho-giao-dien) or a category, they get the same shelves and the same filter
     * bar, with their category pre-selected. Filtering is done with query
     * parameters and rendered server-side, so it works with JavaScript disabled.
     */
    private function storeBrowse($productCatalogue, $request, $root, $children): array
    {
        // $root and $children are passed in: index() has already resolved the parent
        // and its children, and re-fetching them here meant three identical full
        // selects of product_catalogues per request.
        $categories = collect($children)
            ->filter(fn ($c) => (int) $c->publish === 2)
            ->values();

        $buckets = [
            'mien-phi'  => ['label' => 'Miễn phí',      'range' => [0, 0]],
            'duoi-2'    => ['label' => 'Dưới 2 triệu',  'range' => [1, 1999999]],
            '2-den-4'   => ['label' => '2 – 4 triệu',   'range' => [2000000, 4000000]],
            'tren-4'    => ['label' => 'Trên 4 triệu',  'range' => [4000001, PHP_INT_MAX]],
        ];

        $sorts = [
            'moi-nhat'  => ['label' => 'Mới nhất',      'key' => 'newest'],
            'gia-tang'  => ['label' => 'Giá thấp → cao', 'key' => 'price-asc'],
            'gia-giam'  => ['label' => 'Giá cao → thấp', 'key' => 'price-desc'],
        ];

        $activeCategory = (int) $request->input('dm', 0);
        if ($activeCategory === 0 && $productCatalogue->parent_id != 0) {
            $activeCategory = (int) $productCatalogue->id;
        }

        $activeBucket = (string) $request->input('gia', '');
        $activeBucket = array_key_exists($activeBucket, $buckets) ? $activeBucket : '';

        $activeSort = (string) $request->input('sap-xep', '');
        $activeSort = array_key_exists($activeSort, $sorts) ? $activeSort : 'moi-nhat';

        $isFiltered = $activeCategory > 0 || $activeBucket !== '' || $activeSort !== 'moi-nhat';

        $priceRange = $activeBucket !== '' ? $buckets[$activeBucket]['range'] : null;

        // One query covers both modes: shelves group the same rows client-side-free,
        // and the filtered view just renders them flat.
        $templates = $this->productRepository->storeTemplates(
            $activeCategory > 0 ? [$activeCategory] : $categories->pluck('id')->all(),
            $this->language,
            $priceRange,
            $sorts[$activeSort]['key']
        );

        $shelves = [];
        if (!$isFiltered) {
            foreach ($categories as $category) {
                $items = $templates->filter(
                    fn ($p) => $p->product_catalogues->contains('id', $category->id)
                )->values();

                if ($items->isNotEmpty()) {
                    $shelves[] = ['category' => $category, 'items' => $items];
                }
            }
        }

        return [
            'storeRoot' => $root,
            'storeCategories' => $categories,
            'storeBuckets' => $buckets,
            'storeSorts' => $sorts,
            'storeActiveCategory' => $activeCategory,
            'storeActiveBucket' => $activeBucket,
            'storeActiveSort' => $activeSort,
            'storeIsFiltered' => $isFiltered,
            'storeShelves' => $shelves,
            'storeResults' => $templates,
            'storeFeatured' => $templates->first(),
            'storeTotal' => $templates->count(),
        ];
    }

    private function filter($productCatalogue){
        $filters = null;
        $children = $this->productCatalogueRepository->getChildren($productCatalogue);
        $groupedAttributes = [];
        foreach ($children as $child) {
            if (isset($child->attribute) && !is_null($child->attribute) && count($child->attribute)) {
                foreach ($child->attribute as $key => $value) {
                    if (!isset($groupedAttributes[$key])) {
                        $groupedAttributes[$key] = [];
                    }
                    $groupedAttributes[$key][] = $value;
                }
            }
        }
        foreach ($groupedAttributes as $key => $value) {
            $groupedAttributes[$key] = array_merge(...$value);
        }

        if(isset($groupedAttributes) && !is_null($groupedAttributes) &&  count($groupedAttributes)){
            $filters = $this->productCatalogueService->getFilterList($groupedAttributes, $this->language);
        }
        return $filters;
    }

    
    public function search(Request $request){

        $products = $this->productRepository->search($request->input('keyword'), $this->language);

        $productId = $products->pluck('id')->toArray();

        if(count($productId) && !is_null($productId)){
            $products = $this->productService->combineProductAndPromotion($productId, $products);
        }

        $config = $this->config();

        $system = $this->system;

        $widgets = $this->widgetService->getWidget([
            ['keyword' => 'news-outstanding','object' => true],
        ], $this->language);

        $seo = [
            'meta_title' => 'Tìm kiếm cho từ khóa: '.$request->input('keyword'),
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            // No .html suffix: the search route is /tim-kiem, so the default suffix
            // made the canonical point at a 404.
            'canonical' => write_url('tim-kiem', true, false)
        ];

        if(Agent::isMobile()){
            $template = 'mobile.product.catalogue.search';
        }else{
            $template = 'frontend.product.catalogue.search';
        }


        return view($template , compact(
            'config',
            'seo',
            'system',
            'products',
            'widgets'
        ));
    }

    public function wishlist(Request $request){
        $id = Cart::instance('wishlist')->content()->pluck('id')->toArray();
        $products = $this->productRepository->findByIds($id, $this->language);
        $productId = $products->pluck('id')->toArray();
        if(count($productId) && !is_null($productId)){
            $products = $this->productService->combineProductAndPromotion($productId, $products);
        }

        $config = $this->config();
        $system = $this->system;
        $seo = [
            'meta_title' => 'Danh sách yêu thích',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            // No .html suffix: the search route is /tim-kiem, so the default suffix
            // made the canonical point at a 404.
            'canonical' => write_url('tim-kiem', true, false)
        ];
        return view('frontend.product.catalogue.search', compact(
            'config',
            'seo',
            'system',
            'products',
        ));
    }

    private function schema($productCatalogue, $products, $breadcrumb){

        $cat_name = $productCatalogue->languages->first()->pivot->name;

        $cat_canonical = write_url($productCatalogue->languages->first()->pivot->canonical);

        $cat_description = strip_tags($productCatalogue->languages->first()->pivot->description);

        $totalProducts = $products->total();

        $itemListElements = '';

        $position = 1;

        foreach ($products as $product) {
            $image = $product->image;
            $name = $product->languages->first()->pivot->name;
            $canonical = write_url($product->languages->first()->pivot->canonical);
            $itemListElements .= "
                {
                    \"@type\": \"ListItem\",
                    \"position\": $position,
                    \"item\": {
                        \"@type\": \"Product\",
                        \"name\": \"" . $name . "\",
                        \"url\": \"" . $canonical .  "\",
                        \"image\": \"" . $image .  "\"
                    }
                },";
            $position++;
        }

        $itemListElements = rtrim($itemListElements, ',');

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

        $schema = "<script type='application/ld+json'>
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
                \"@type\": \"CollectionPage\",
                \"name\": \"" . $cat_name . "\",
                \"description\": \" " . $cat_description . " \",
                \"url\": \"" . $cat_canonical . "\",
                \"mainEntity\": {
                    \"@type\": \"ItemList\",
                    \"name\": \" " .$cat_name. " \",
                    \"numberOfItems\": $totalProducts,
                    \"itemListElement\": [
                        $itemListElements
                    ]
                }
            }
            </script>";
        return $schema;
    }

    private function config(){
        return [
            'language' => $this->language,
            // store.css is loaded per page rather than site-wide: it is a dark theme
            // scoped to .store and only the catalogue pages use it.
            'css' => [
                'frontend/resources/store.css',
            ],
            'externalJs' => [
                '//code.jquery.com/ui/1.11.4/jquery-ui.js'
            ],
            'js' => [
                'frontend/core/library/filter.js',
            ],

        ];
    }

}
