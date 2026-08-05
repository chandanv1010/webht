<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class UserService
 * @package App\Services
 */
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(
        Product $model
    ){
        $this->model = $model;
        parent::__construct($model);
    }

    public function search($keyword, $language_id){
        return $this->model->select([
                'products.id',
                'products.product_catalogue_id',
                'products.image',
                'products.icon',
                'products.album',
                'products.publish',
                'products.follow',
                'products.price',
                'products.code',
                'products.made_in',
                'products.attributeCatalogue',
                'products.attribute',
                'products.variant',
                // 'products.warranty',
                'tb2.name',
                'tb2.description',
                'tb2.content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
                'tb2.canonical',
            ]
        )
        ->join('product_language as tb2', 'tb2.product_id', '=','products.id')
        ->with([
            // languages and product_catalogues.languages are eager-loaded too: the
            // result cards read $product->languages->first() and the catalogue name,
            // which without this fired two extra queries per row.
            'languages' => function ($query) use ($language_id) {
                $query->where('language_id', '=', $language_id);
            },
            'product_catalogues.languages' => function ($query) use ($language_id) {
                $query->where('language_id', '=', $language_id);
            },
            'product_catalogues',
            'product_variants' => function ($query) use ($language_id) {
                $query->with(['attributes' => function ($query) use ($language_id) {
                    $query->with(['attribute_language' => function ($query) use ($language_id) {
                        $query->where('language_id', '=', $language_id);
                    }]);
                }]);
            },
            'reviews'
        ])
        ->where('tb2.language_id', '=', $language_id)
        ->where('products.publish', '=', 2)
        ->where('tb2.name', 'LIKE', '%'.$keyword.'%')
        // rtrim + explicit slash: concatenating straight onto app.url produced
        // "http://example.comtim-kiem" in every pagination link when APP_URL has no
        // trailing slash.
        ->paginate(21)->withQueryString()->withPath(rtrim(config('app.url'), '/').'/tim-kiem');
    }

    public function findByIds($ids, $language_id){
        return $this->model->select([
                'products.id',
                'products.product_catalogue_id',
                'products.image',
                'products.icon',
                'products.album',
                'products.publish',
                'products.follow',
                'products.price',
                'products.code',
                'products.made_in',
                'products.attributeCatalogue',
                'products.attribute',
                'products.variant',
                'products.seller_id',
                'tb2.name',
                'tb2.description',
                'tb2.content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
                'tb2.canonical',
                
            ]
        )
        ->join('product_language as tb2', 'tb2.product_id', '=','products.id')
        ->with([
            // languages and product_catalogues.languages are eager-loaded too: the
            // result cards read $product->languages->first() and the catalogue name,
            // which without this fired two extra queries per row.
            'languages' => function ($query) use ($language_id) {
                $query->where('language_id', '=', $language_id);
            },
            'product_catalogues.languages' => function ($query) use ($language_id) {
                $query->where('language_id', '=', $language_id);
            },
            'product_catalogues',
            'product_variants' => function ($query) use ($language_id) {
                $query->with(['attributes' => function ($query) use ($language_id) {
                    $query->with(['attribute_language' => function ($query) use ($language_id) {
                        $query->where('language_id', '=', $language_id);
                    }]);
                }]);
            },
            'reviews'
        ])
        ->where('tb2.language_id', '=', $language_id)
        ->where('products.publish', '=', 2)
        ->whereIn('products.id', $ids)
        ->get();
    }


    public function getProductById(int $id = 0, $language_id = 0, $condition = []){
        return $this->model->select([
                'products.id',
                'products.product_catalogue_id',
                'products.image',
                'products.icon',
                'products.album',
                'products.publish',
                'products.follow',
                'products.price',
                'products.code',
                'products.made_in',
                'products.attributeCatalogue',
                'products.attribute',
                'products.variant',
                'products.qrcode',
                'products.warranty',
                'products.iframe',
                'products.seller_id',
                'tb2.name',
                'tb2.description',
                'tb2.content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
                'tb2.canonical',
            ]
        )
        ->join('product_language as tb2', 'tb2.product_id', '=','products.id')
        ->with([
            // languages and product_catalogues.languages are eager-loaded too: the
            // result cards read $product->languages->first() and the catalogue name,
            // which without this fired two extra queries per row.
            'languages' => function ($query) use ($language_id) {
                $query->where('language_id', '=', $language_id);
            },
            'product_catalogues.languages' => function ($query) use ($language_id) {
                $query->where('language_id', '=', $language_id);
            },
            'product_catalogues',
            'product_variants' => function ($query) use ($language_id) {
                $query->with(['attributes' => function ($query) use ($language_id) {
                    $query->with(['attribute_language' => function ($query) use ($language_id) {
                        $query->where('language_id', '=', $language_id);
                    }]);
                }]);
            },
            'reviews' => function ($query) {
                $query->where('status', '=', 1);
            },
        ])
        ->where('tb2.language_id', '=', $language_id)
        ->find($id);
    }

    public function findProductForPromotion($condition = [], $relation = []){
        $query = $this->model->newQuery();
        $query->select([
            'products.id',
            'products.image',
            'products.warranty',
            'tb2.name',
            'tb3.uuid',
            'tb3.id as product_variant_id',
            DB::raw('CONCAT(tb2.name, " - ", COALESCE(tb4.name, " Default")) as variant_name'),
            DB::raw('COALESCE(tb3.sku, products.code) as sku'),
            DB::raw('COALESCE(tb3.price, products.price) as price'),
        ]) ;
        $query->join('product_language as tb2','products.id', '=', 'tb2.product_id');
        $query->leftJoin('product_variants as tb3','products.id', '=', 'tb3.product_id');
        $query->leftJoin('product_variant_language as tb4', 'tb3.id', '=', 'tb4.product_variant_id');

        foreach($condition as $key => $val){
            $query->where($val[0], $val[1], $val[2]);
        }
        if(count($relation)){
            $query->with($relation);
        }
        $query->orderBy('id', 'desc');
        $query->groupBy('products.id');
        return $query->paginate(20);
    }

    public function filter($param, $perpage, $orderBy){
        $query = $this->model->newQuery();

        $query->select(
            'products.id',
            'products.price',
            'products.image',
        );

        if(isset($param['select']) && count($param['select'])){
            foreach($param['select'] as $key => $val){
                if(is_null($val)) continue;
                $query->selectRaw($val);
            }
        }

        if(isset($param['join']) && count($param['join'])){
            foreach($param['join'] as $key => $val){
                if(is_null($val)) continue;
                $query->leftJoin($val[0], $val[1], $val[2], $val[3]);
            }
        }

        $query->where('products.publish', '=', 2);

        if(isset($param['where']) && count($param['where'])){
            foreach($param['where'] as $key => $val){
                $query->where($val);
            }
        }

        if(isset($param['whereRaw']) && count($param['whereRaw'])){
            $query->whereRaw($param['whereRaw'][0][0], $param['whereRaw'][0][1]);
        }

        if(isset($param['having']) && count($param['having'])){
            foreach($param['having'] as $key => $val){
                if(is_null($val)) continue;
                $query->having($val);
            }
        }

        $query->groupBy($orderBy);
        $query->with(['reviews', 'languages', 'product_catalogues']);

        return $query->paginate($perpage);
    }    


    public function findProductForVoucher($condition = [], $relation = []){
        $query = $this->model->newQuery();
        $query->select([
            'products.id',
            'products.code',
            'products.price',
            'products.image',
            'tb2.name',
        ]) ;
        $query->join('product_language as tb2','products.id', '=', 'tb2.product_id');

        foreach($condition as $key => $val){
            $query->where($val[0], $val[1], $val[2]);
        }
        if(count($relation)){
            $query->with($relation);
        }
        $query->orderBy('id', 'desc');
        $query->groupBy('products.id');
        return $query->paginate(20);
    }
    
    public function getRelated($limit = 6, $productCatalogueId = 0, $productId = 0){
        return $this->model->where('publish' , 2)->where('product_catalogue_id', $productCatalogueId)->where('id', '!=', $productId)->orderBy('id', 'desc')->limit($limit)->get();
    }

    /**
     * Published templates for the store browse page.
     *
     * Everything the cards read — name, canonical, category name — is eager-loaded,
     * so one shelf of six cards costs one query for the products and one per
     * relation, not one per card.
     *
     * @param  array      $catalogueIds  restrict to these categories (empty = all)
     * @param  array|null $priceRange    [min, max] inclusive, null for no price filter
     */
    public function storeTemplates(
        array $catalogueIds,
        int $languageId,
        ?array $priceRange = null,
        string $sort = 'newest'
    ) {
        $query = $this->model->newQuery()
            ->where('products.publish', 2)
            ->with([
                'languages' => function ($q) use ($languageId) {
                    $q->where('language_id', '=', $languageId);
                },
                'product_catalogues' => function ($q) {
                    $q->where('product_catalogues.publish', 2);
                },
                'product_catalogues.languages' => function ($q) use ($languageId) {
                    $q->where('language_id', '=', $languageId);
                },
            ]);

        if (!empty($catalogueIds)) {
            $query->whereHas('product_catalogues', function ($q) use ($catalogueIds) {
                $q->whereIn('product_catalogues.id', $catalogueIds);
            });
        }

        if (is_array($priceRange)) {
            $query->whereBetween('products.price', [$priceRange[0], $priceRange[1]]);
        }

        match ($sort) {
            'price-asc' => $query->orderBy('products.price', 'asc'),
            'price-desc' => $query->orderBy('products.price', 'desc'),
            'name' => $query->orderBy('products.code', 'asc'),
            default => $query->orderBy('products.id', 'desc'),
        };

        return $query->get();
    }

}
