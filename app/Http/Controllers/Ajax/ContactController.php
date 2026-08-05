<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\ContactServiceInterface as ContactService;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{

    protected $contactService;
    
    public function __construct(
        ContactService $contactService
    ){
        $this->contactService = $contactService;
    }

    public function requestConsult(Request $request){
        $flag = $this->contactService->create($request);
        return response()->json([
            'status' => $flag['code'] == 10 ? true : false,
            'messages' => 'Gửi yêu cầu thành công , chúng tôi sẽ sớm liên hệ với bạn',
        ]);
    }

    public function quickConsult(Request $request){
        $flag = $this->contactService->create($request);
        return response()->json([
            'status' => $flag['code'] == 10 ? true : false,
            'messages' => 'Gửi yêu cầu thành công , chúng tôi sẽ sớm liên hệ với bạn',
        ]);
    }

    public function advise(Request $request){
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            // Optional, but validated when given: the contact page now stores this and
            // the team replies to it, so a typo costs a lead.
            'email' => 'nullable|email',
        ];

        $errorMessages = [
            'name.required' => 'Bạn chưa nhập họ tên.',
            'phone.required' => 'Bạn chưa nhập số điện thoại.',
            'email.email' => 'Email chưa đúng định dạng.',
        ];

        $validator = Validator::make($request->all(), $rules, $errorMessages);

        if($validator->fails()) {
            $errors = $validator->errors();
            $response = [
                'status' => 422,
                'messages' => [
                    'name' => $errors->first('name'),
                    'phone' => $errors->first('phone'),
                    'email' => $errors->first('email'),
                ],
            ];
        
            return response()->json($response);
        }

        $result = $this->contactService->create($request);

        // Report the service's actual code. This used to be `(!$flag) ? 11 : 10` on an
        // array that is always truthy, so a failed insert still told the visitor "thành
        // công" and their enquiry vanished silently.
        $ok = ($result['code'] ?? 11) === 10;

        return response()->json([
            'code' => $result['code'] ?? 11,
            'messages' => $result['message'] ?? 'Có vấn đề xảy ra! Hãy thử lại',
        ], $ok ? 200 : 500);
    }

    
}
