<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\OrderServiceInterface  as OrderService;
use App\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use Illuminate\Support\Facades\Auth;
use DB;


class OrderController extends Controller
{
    protected $orderService;
    protected $orderRepository;

    public function __construct(
        OrderService $orderService,
        OrderRepository $orderRepository,
        ProvinceRepository $provinceRepository,
    ){
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
        $this->provinceRepository = $provinceRepository;
    }

    private function getSeller(){
        return Auth::guard('customer')->user();
    }

    public function index(Request $request){
        $seller = $this->getSeller();
        $orders = $this->orderService->paginateSeller($request, $seller);
        $config = [
            'js' => [
                'backend/library/order.js',
                'backend/js/plugins/switchery/switchery.js',
                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js',
                'backend/js/plugins/daterangepicker/daterangepicker.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'backend/css/plugins/daterangepicker/daterangepicker-bs3.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Order'
        ];
        $config['seo'] = __('messages.order');
        $template = 'seller.order.index';
        return view('seller.dashboard.layout', compact(
            'template',
            'config',
            'orders',
            'seller'
        ));
    }

    public function detail(Request $request, $id){
        $seller = $this->getSeller();
        $order = $this->orderRepository->getOrderById($id, 
            [
                'products' => function($query) use  ($seller){
                    $query->where('products.seller_id', $seller->id);
                }
            ]
        );
        $order = $this->orderService->getOrderItemImage($order);

        $orderDetail = DB::table('order_product')->where('order_id', $id)->pluck('option', 'product_id')
        ->toArray();


        $provinces = $this->provinceRepository->all();
        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'js' => [
                'backend/library/order.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
        ];
        
        $config['seo'] = __('messages.order');
        $template = 'seller.order.detail';
        return view('seller.dashboard.layout', compact(
            'template',
            'config',
            'order',
            'provinces',
            'orderDetail',
        ));
    }

}
