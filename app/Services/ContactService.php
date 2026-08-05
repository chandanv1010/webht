<?php

namespace App\Services;
use App\Services\Interfaces\ContactServiceInterface;
use App\Repositories\Interfaces\ContactRepositoryInterface as ContactRepository;
use Illuminate\Support\Facades\DB;
use App\Mail\ContactMail;
use App\Support\TelegramNotifier;
use Illuminate\Support\Facades\Log;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;

class ContactService extends BaseService implements ContactServiceInterface 
{
    protected $contactRepository;
    protected $productRepository;
    protected $postRepository;

    public function __construct(
        ContactRepository $contactRepository,
        ProductRepository $productRepository,
        PostRepository $postRepository
    ){
        $this->contactRepository = $contactRepository;
        $this->productRepository = $productRepository;
        $this->postRepository = $postRepository;
    }

    public function paginate($request){
        $condition['keyword'] = addslashes($request->input('keyword'));
        $perPage = $request->integer('perpage');
        $contacts = $this->contactRepository->pagination(
            $this->paginateSelect(), 
            $condition, 
            $perPage,
            ['path' => 'contact/index'], 
        );
        return $contacts;
    }

    public function create($request){
        // The enquiry is committed on its own. Notifications happen afterwards,
        // because they used to sit inside this transaction: an SMTP timeout rolled
        // the row back and the customer was lost entirely, while still being told
        // "gửi thành công".
        try {
            $contact = DB::transaction(function () use ($request) {
                $payload = $request->except('_token');
                $payload['name'] = $request->input('name') ?? $request->input('fullname');

                return $this->contactRepository->create($payload);
            });
        } catch (\Throwable $e) {
            Log::error('Không lưu được liên hệ: '.$e->getMessage());

            return [
                'code' => 11,
                'message' => 'Có vấn đề xảy ra! Hãy thử lại'
            ];
        }

        $this->notify($contact, $request);

        return [
            'code' => 10,
            'message' => 'Gửi liên hệ thành công , Chúng tôi sẽ sớm phản hồi lại bạn'
        ];
    }

    /**
     * Tell the team about a saved enquiry. Every failure in here is logged and
     * swallowed — the row is already committed and the visitor has been thanked.
     */
    private function notify($contact, $request): void
    {
        $productName = ($contact->product_id != null)
            ? optional($this->productRepository->getProductById($contact->product_id, 1))->name
            : null;
        $postName = ($contact->post_id != null)
            ? optional($this->postRepository->getPostById($contact->post_id, 1))->name
            : null;

        TelegramNotifier::lead('🔔 Liên hệ mới từ website', [
            'Họ tên' => $contact->name,
            'Điện thoại' => $contact->phone,
            'Email' => $contact->email ?? null,
            'Địa chỉ' => $contact->address,
            'Quan tâm' => $productName ?? $postName,
            'Nội dung' => $request->input('content') ?? $request->input('note'),
        ], $request->headers->get('referer'));

        // Recipients come from the site's own settings. They used to be hardcoded to
        // a furniture company and a developer's personal Gmail, both left over from
        // the project this codebase was reused from.
        $to = config('mail.lead_recipient')
            ?: DB::table('systems')->where('keyword', 'contact_email')->where('language_id', 1)->value('content');

        if (empty($to)) {
            return;
        }

        try {
            \Mail::to($to)->send(new ContactMail([
                'name' => $contact->name,
                'created_at' => $contact->created_at,
                'phone' => $contact->phone,
                'address' => $contact->address,
                'type' => $contact->type ?? null,
                'product_id' => $request->product_id,
                'product_name' => $productName ?? $postName,
                'post_id' => $postName,
            ]));
        } catch (\Throwable $e) {
            Log::warning('Không gửi được email thông báo liên hệ: '.$e->getMessage());
        }
    }

    public function update($id, $request){
        DB::beginTransaction();
        try{
            $payload = $request->except(['_token','send']);
            $contact = $this->contactRepository->update($id, $payload);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    public function destroy($id){
        DB::beginTransaction();
        try{
            $contact = $this->contactRepository->delete($id);
            DB::commit();
            return true;
        }catch(\Exception $e ){
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();die();
            return false;
        }
    }

    private function paginateSelect(){
        return [
            'id',
            'name',
            'address',
            'phone',
            'product_id',
            'post_id',
            'gender',
            'publish',
            'created_at',
            'type'
        ];
    }
}
