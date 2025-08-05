<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Buyer\StoreBuyerRequest;
use App\Http\Requests\Buyer\AuthBuyerRequest;
use App\Services\Interfaces\CustomerServiceInterface  as CustomerService;
use App\Repositories\Interfaces\CustomerRepositoryInterface as CustomerRepository;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; 
use App\Models\Customer;


class BuyerAuthController extends FrontendController
{
  
    protected $customerService;
    protected $customerRepository;

    public function __construct(
        CustomerService $customerService,
        CustomerRepository $customerRepository
    ){
        $this->customerService = $customerService;
        $this->customerRepository = $customerRepository;
        parent::__construct();
    }

    public function login(){
        $system = $this->system;
        $config = $this->config();
        $seo = [
            'meta_title' => 'Trang đăng nhập tài khoản - Mua sắm online',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('buyer.login')
        ];
        return view('buyer.auth.login', compact(
            'seo',
            'system',
            'config',
        ));
    }

    public function authenticate(Request $request){


        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
        if(Auth::guard('customer')->attempt($credentials)){
            $customer = Auth::guard('customer')->user();
            $request->session()->regenerate();
            return redirect()->route('home.index')->with('success', 'Đăng nhập thành công');
        }
        return redirect()->route('buyer.login')->with('error','Email hoặc Mật khẩu không chính xác');
    }

    public function signup(){

        $config = $this->config();
        $system = $this->system;
        $seo = [
            'meta_title' => 'Trang đăng ký tài khoản - Mua sắm online',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => route('buyer.signup')
        ];
        return view('buyer.auth.signup', compact(
            'seo',
            'system',
            'config'
        ));
    }

    public function register(StoreBuyerRequest $request){
        if($this->customerService->create($request)){
            return redirect()->route('buyer.login')->with('success','Đăng ký tài khoản thành công. Hãy tiến hành đăng nhập');
        }
        return redirect()->route('buyer.register')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function redirectToGoogle() {

        return Socialite::driver('google')->with(['prompt' => 'select_account'])->redirect();

    }

    public function handleGoogleCallback(Request $request){

        $googleUser = Socialite::driver('google')->user();

        $existUser = $this->customerRepository->findByCondition([
            ['google_id','=', $googleUser->id]
        ]);

        if(is_null($existUser)){

            $payload = [
                'google_id' => $googleUser->id,
                'customer_catalogue_id' => config('apps.general.retail_customer'),
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => Hash::make(Str::random()),
                'remember_token' => $googleUser->token,
            ];

            $customer = $this->customerRepository->create($payload);

            Auth::guard('customer')->login($customer);

            $request->session()->regenerate();
            
            return redirect()->route('home.index')->with('success','Đăng nhập thành công');
     
        }else{

            Auth::guard('customer')->login($existUser);

            $request->session()->regenerate();

            return redirect()->route('home.index')->with('success','Đăng nhập thành công');

        }
        
    }

    public function redirectToFacebook() {

        return Socialite::driver('facebook')->scopes(['public_profile', 'email'])->redirect();

    }

    public function handleFacebookCallback(Request $request){

        $facebookUser = Socialite::driver('facebook')->user();

        $existUser = $this->customerRepository->findByCondition([
            ['facebook_id','=', $facebookUser->id]
        ]);

        if(is_null($existUser)){

            $payload = [
                'facebook_id' => $facebookUser->id,
                'customer_catalogue_id' => config('apps.general.retail_customer'),
                'name' => $facebookUser->name,
                'email' => $facebookUser->email,
                'password' => Hash::make(Str::random()),
                'remember_token' => $facebookUser->token,
            ];

            $customer = $this->customerRepository->create($payload);

            Auth::guard('customer')->login($customer);

            $request->session()->regenerate();
            
            return redirect()->route('home.index')->with('success','Đăng nhập thành công');
     
        }else{

            Auth::guard('customer')->login($existUser);

            $request->session()->regenerate();

            return redirect()->route('home.index')->with('success','Đăng nhập thành công');

        }
        
    }

    private function config(){
        return [
            'css' => [
                'buyer/resources/style.css'
            ]
        ];
    }

    public function logout(Request $request){

        Auth::guard('customer')->logout();

        $request->session()->forget("session_customer");

        $request->session()->regenerateToken();

        return redirect()->route('home.index');

    }
    
}
