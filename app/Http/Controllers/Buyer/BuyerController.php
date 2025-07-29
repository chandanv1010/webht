<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Buyer\ChangePasswordRequest;
use App\Services\Interfaces\CustomerServiceInterface  as CustomerService;
use App\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;
use App\Services\Interfaces\OrderServiceInterface as OrderService;
use GuzzleHttp\Client;
use App\Classes\ViettelPost;

class BuyerController extends FrontendController
{
  
    protected $customerService;
    protected $orderRepository;
    protected $orderService;
    protected $buyer;
    private $token;


    public function __construct(
        CustomerService $customerService,
        OrderRepository $orderRepository,
        OrderService $orderService,
    ){
        $this->customerService = $customerService;
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
        $this->buyer = $this->getBuyer();
        $this->token = getGiaoHangNhanhToken();
        parent::__construct();
    }

    private function getBuyer(){
        return Auth::guard('customer')->user();
    }

    public function profile(Request $request){ 

        $buyer = $this->getBuyer();
        $viettelPost = new ViettelPost(
            $this->system['homepage_viettelpost_email'],
            $this->system['homepage_viettelpost_password']
        );

        $viettelToken = $viettelPost->getToken();
        $provinces = $viettelPost->getProvinces($viettelToken);

        $config = $this->config();
        $system = $this->system;
        $seo = [
            'meta_title' => 'Trang tài khoả - Mua sắm online',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('buyer.profile')
        ];
        return view('buyer.buyer.profile', compact(
            'seo',
            'system',
            'config',
            'provinces'
        ));
    }

    public function updateProfile(Request $request){
        $buyer = $this->getBuyer();
        if($this->customerService->update($buyer->id, $request)){
            return redirect()->route('buyer.profile')->with('success','Cập nhật thông tin thành công');
        }
        return redirect()->route('buyer.profile')->with('error','Cập  nhật không thành công. Hãy thử lại');
    }

    public function password(){
        $config = $this->config();
        $system = $this->system;
        $seo = [
            'meta_title' => 'Trang tài khoả - Mua sắm online',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('buyer.profile.password')
        ];
        return view('buyer.buyer.password', compact(
            'seo',
            'system',
            'config'
        ));
    }

    public function updatePassword(ChangePasswordRequest $request){
        $buyer = $this->getBuyer();
        if($this->customerService->update($buyer->id, $request)){
            return redirect()->route('buyer.profile')->with('success','Cập nhật mật khẩu thành công');
        }
        return redirect()->route('buyer.profile')->with('error','Cập  nhật không thành công. Hãy thử lại');
    }

    
    public function order(){

        $buyer = $this->getBuyer();


        $order = $this->orderRepository->findOrderByBuyer($buyer);
        $config = $this->config();
        $system = $this->system;
        $seo = [
            'meta_title' => 'Trang danh sách đơn hàng - Mua sắm online',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('buyer.order')
        ];
        return view('buyer.buyer.order', compact(
            'seo',
            'system',
            'config',
            'order',
        ));
    }


    public function orderDetail($orderId){

        $buyer = $this->getBuyer();
        $order = $this->orderRepository->findOrderDetailByBuyer($buyer, $orderId);
        $order = $this->orderService->getOrderItemImage($order);
        // dd($order);

        $config = $this->config();
        $system = $this->system;
        $seo = [
            'meta_title' => 'Trang danh sách đơn hàng - Mua sắm online',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('buyer.order.detail', ['id' => $orderId])
        ];
        return view('buyer.buyer.order-detail', compact(
            'seo',
            'system',
            'config',
            'order',
        ));
    }


    private function config(){
        return [
            'css' => [
                'buyer/resources/style.css'
            ],
            'js' => [
                'buyer/resources/buyer.js'
            ]
        ];
    }
   

}
