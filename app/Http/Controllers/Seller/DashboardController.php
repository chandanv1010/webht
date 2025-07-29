<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\OrderServiceInterface as OrderService;
use App\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;
use App\Services\Interfaces\CustomerServiceInterface as CustomerService;

class DashboardController extends Controller
{


    protected $orderService;
    protected $customerService;
    protected $orderRepository;

    public function __construct(
        OrderService $orderService,
        CustomerService $customerService,
        OrderRepository $orderRepository,
    ){
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
        $this->customerService = $customerService;
    }

    public function index(){
      
        $config = $this->config();
        $template = 'seller.dashboard.home.index';
        return view('seller.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    private function config(){
        return [
            'js' => [
                'backend/js/plugins/chartJs/Chart.min.js',
                'backend/library/dashboard.js',
            ]
        ];
    }

}
