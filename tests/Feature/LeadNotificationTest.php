<?php

namespace Tests\Feature;

use App\Support\TelegramNotifier;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * A customer enquiry must survive anything that goes wrong after it is saved.
 *
 * Notifications used to run inside the same transaction as the insert, so an SMTP
 * timeout rolled the enquiry back while the visitor was still told "gửi thành công".
 */
class LeadNotificationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_enquiry_is_saved_and_telegram_is_notified(): void
    {
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => true], 200)]);

        $res = $this->postJson('/ajax/contact/advise', [
            'name' => 'Nguyễn Văn Test',
            'phone' => '0912345678',
            'content' => 'Tôi muốn tư vấn mẫu Kidzone',
        ]);

        $res->assertStatus(200);

        $row = DB::table('contacts')->where('phone', '0912345678')->first();
        $this->assertNotNull($row, 'enquiry was not saved');
        $this->assertSame('Nguyễn Văn Test', $row->name);

        // Http::recorded() rather than assertSent(): a closure inside assertSent trips
        // a deprecation in this PHPUnit/Collision combination and the printer dies
        // while rendering the result, hiding whatever actually happened.
        $calls = Http::recorded();

        $this->assertCount(1, $calls, 'expected exactly one Telegram call');
        $this->assertStringContainsString('api.telegram.org', $calls[0][0]->url());
        $this->assertStringContainsString('/sendMessage', $calls[0][0]->url());
        $this->assertStringContainsString('0912345678', urldecode((string) $calls[0][0]->body()));
    }

    /** The whole point: a dead notification API must not cost us the customer. */
    public function test_enquiry_survives_a_failing_telegram_api(): void
    {
        Http::fake(['api.telegram.org/*' => Http::response(['ok' => false, 'description' => 'boom'], 500)]);

        $res = $this->postJson('/ajax/contact/advise', [
            'name' => 'Trần Thị Test',
            'phone' => '0987654321',
            'content' => 'Test API lỗi',
        ]);

        $res->assertStatus(200);
        $this->assertNotNull(
            DB::table('contacts')->where('phone', '0987654321')->first(),
            'enquiry was rolled back when the notifier failed'
        );
    }

    public function test_validation_still_rejects_an_empty_form(): void
    {
        $res = $this->postJson('/ajax/contact/advise', ['name' => '', 'phone' => '']);

        $res->assertStatus(200);
        $res->assertJsonPath('status', 422);
        $this->assertSame(0, DB::table('contacts')->where('name', '')->count());
    }

    /** With no credentials the notifier must be a silent no-op, not an error. */
    public function test_notifier_is_disabled_without_credentials(): void
    {
        config(['services.telegram.token' => '', 'services.telegram.chat_id' => '']);

        $this->assertFalse(TelegramNotifier::enabled());
        $this->assertFalse(TelegramNotifier::lead('x', ['a' => 'b']));
    }
}
