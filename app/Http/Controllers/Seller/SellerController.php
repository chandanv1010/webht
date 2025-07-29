<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\CustomerRepositoryInterface  as CustomerRepository;
use App\Services\Interfaces\ProductServiceInterface as ProductService;


class SellerController extends FrontendController
{
   
    protected $customerRepository;
    protected $productService;

    public function __construct(
        CustomerRepository $customerRepository,
        ProductService $productService,
    ){
        $this->customerRepository = $customerRepository;
        $this->productService = $productService;
        parent::__construct();
    }

    

    public function shop($account = ''){
        
        $seller = $this->customerRepository->findByField($account, 'phone');
        if(!$seller){
            return redirect()->route('home.index')->with('error', 'Shop không tồn tại');
        }

        $products = $this->productService->paginateShop($seller);

        
        $config = $this->config();
        $system = $this->system;
        $seo = [
            'meta_title' => 'Shop - Mua sắm online',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('seller.shop', ['account' => $account])
        ];
        return view('seller.shop', compact(
           'seo',
           'system',
           'seller',
           'products',
        ));
    }


    private function config(){

    }

}
