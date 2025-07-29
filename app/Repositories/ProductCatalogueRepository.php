<?php

namespace App\Repositories;

use App\Models\ProductCatalogue;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class UserService
 * @package App\Services
 */
class ProductCatalogueRepository extends BaseRepository implements ProductCatalogueRepositoryInterface
{
    protected $model;

    public function __construct(
        ProductCatalogue $model
    ){
        $this->model = $model;
        parent::__construct($model);
    }


    public function findByCondition(
        $condition = [] , 
        $flag = false, 
        $relation = [], 
        array $orderBy = ['order', 'asc'],
        array $param = [],
        array $withCount = [],
    )
    {

        $query = $this->model->newQuery();
        foreach($condition as $key => $val){
            $query->where($val[0], $val[1] , $val[2]);
        }
        if(isset($param['whereIn'])){
            $query->whereIn($param['whereInField'], $param['whereIn']);
        }
        
        $query->with($relation);
        $query->withCount($withCount);
        $query->orderBy($orderBy[0], $orderBy[1]);
        return ($flag == false) ? $query->first() : $query->get();
    }

    
    public function getProductCatalogueById(int $id = 0, $language_id = 0){
        return $this->model->select([
                'product_catalogues.id',
                'product_catalogues.parent_id',
                'product_catalogues.lft',
                'product_catalogues.rgt',
                'product_catalogues.image',
                'product_catalogues.icon',
                'product_catalogues.album',
                'product_catalogues.publish',
                'product_catalogues.follow',
                'product_catalogues.attribute',
                'product_catalogues.short_name',
                'tb2.name',
                'tb2.description',
                'tb2.content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
                'tb2.canonical',
            ]
        )
        ->join('product_catalogue_language as tb2', 'tb2.product_catalogue_id', '=','product_catalogues.id')
        ->where('tb2.language_id', '=', $language_id)
        ->find($id);
    }

    public function getChildren($productCatalogue){
        return $this->model->select([
                'product_catalogues.id',
                'product_catalogues.parent_id',
                'product_catalogues.lft',
                'product_catalogues.rgt',
                'product_catalogues.image',
                'product_catalogues.icon',
                'product_catalogues.album',
                'product_catalogues.publish',
                'product_catalogues.follow',
                'product_catalogues.attribute',
            ]
        )
        ->join('product_catalogue_language as tb2', 'tb2.product_catalogue_id', '=','product_catalogues.id')
        ->where('parent_id' , '>=', $productCatalogue->id)
        ->where('lft' , '>=', $productCatalogue->lft)
        ->where('rgt', '<=', $productCatalogue->rgt)
        ->get();
    }

    public function getParent($productCatalogue, $language_id = 0){
        return $this->model->select([
                'product_catalogues.id',
                'product_catalogues.parent_id',
                'product_catalogues.lft',
                'product_catalogues.rgt',
                'product_catalogues.image',
                'product_catalogues.icon',
                'product_catalogues.album',
                'product_catalogues.publish',
                'product_catalogues.follow',
                'product_catalogues.attribute',
                'product_catalogues.short_name',
                'tb2.name',
                'tb2.description',
                'tb2.content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
                'tb2.canonical',
            ]
        )
        ->join('product_catalogue_language as tb2', 'tb2.product_catalogue_id', '=','product_catalogues.id')
        ->where('product_catalogues.lft','<', $productCatalogue->lft)
        ->where('product_catalogues.parent_id', 0)
        ->where('tb2.language_id', '=', $language_id)
        ->first();
    }



}
