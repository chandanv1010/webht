<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * The detail page's tabs have to be editable.
 *
 * They were not: of the eight rows under "Thông số kỹ thuật" only three came from the
 * record, and the handover list and the terms — commercial promises about warranty,
 * payment and refunds — were written into the Blade file. All 36 templates therefore
 * claimed the same platform whether or not it was true, and no one could correct a word
 * without a deploy.
 */
class TemplateSpecsTest extends TestCase
{
    use DatabaseTransactions;

    /** @return array{0:int,1:string} a published template's id and canonical */
    private function aTemplate(): array
    {
        $row = DB::table('products')
            ->join('product_language as l', 'l.product_id', '=', 'products.id')
            ->where('products.publish', 2)
            ->where('l.language_id', 1)
            ->whereNotNull('l.canonical')
            ->select('products.id', 'l.canonical')
            ->first();

        $this->assertNotNull($row, 'no published template to test with');

        return [(int) $row->id, $row->canonical];
    }

    public function test_specs_typed_on_the_product_appear_on_the_page(): void
    {
        [$id, $canonical] = $this->aTemplate();

        DB::table('products')->where('id', $id)->update([
            'specs' => "Nền tảng: WordPress 6 · PHP 8.2\nSố trang: 9\nĐa ngôn ngữ: Việt / Anh",
        ]);

        $res = $this->get('/'.$canonical.'.html');

        $res->assertStatus(200);
        // The product's own value, and its own extra rows.
        $res->assertSee('WordPress 6 · PHP 8.2', false);
        $res->assertSee('Số trang', false);
        $res->assertSee('Đa ngôn ngữ', false);
        // The default it replaced is gone.
        $res->assertDontSee('Laravel 10 · PHP 8.1+ · MySQL 8.0', false);
    }

    /** With nothing typed, the defaults still fill the tab rather than leaving it empty. */
    public function test_specs_fall_back_to_the_defaults(): void
    {
        [$id, $canonical] = $this->aTemplate();

        DB::table('products')->where('id', $id)->update(['specs' => null]);

        $res = $this->get('/'.$canonical.'.html');

        $res->assertStatus(200);
        $res->assertSee('Laravel 10 · PHP 8.1+ · MySQL 8.0', false);
        $res->assertSee('Mã mẫu', false);
    }

    /** Lines without a colon are ignored rather than rendered as a blank row. */
    public function test_malformed_spec_lines_are_skipped(): void
    {
        [$id, $canonical] = $this->aTemplate();

        DB::table('products')->where('id', $id)->update([
            'specs' => "một dòng không có dấu hai chấm\nSố trang: 5\n\n   \nNhãn rỗng:   ",
        ]);

        $res = $this->get('/'.$canonical.'.html');

        $res->assertStatus(200);
        $res->assertSee('Số trang', false);
        $res->assertDontSee('một dòng không có dấu hai chấm', false);
        $res->assertDontSee('Nhãn rỗng', false);
    }

    /** The handover list and the terms come from the settings, so one edit changes all. */
    public function test_handover_and_terms_come_from_the_settings(): void
    {
        [, $canonical] = $this->aTemplate();

        DB::table('systems')->where('keyword', 'template_handover')->where('language_id', 1)
            ->update(['content' => '<p>Bàn giao thử nghiệm ABC123</p>']);
        DB::table('systems')->where('keyword', 'template_terms')->where('language_id', 1)
            ->update(['content' => '<p>Điều khoản thử nghiệm XYZ789</p>']);

        $res = $this->get('/'.$canonical.'.html');

        $res->assertStatus(200);
        $res->assertSee('Bàn giao thử nghiệm ABC123', false);
        $res->assertSee('Điều khoản thử nghiệm XYZ789', false);
    }

    /** "Cập nhật" was always empty: updated_at was missing from the query's column list. */
    public function test_the_updated_date_is_available_to_the_page(): void
    {
        [, $canonical] = $this->aTemplate();

        $res = $this->get('/'.$canonical.'.html');

        $res->assertStatus(200);
        $res->assertSee('Cập nhật', false);
    }

    /** The admin has somewhere to type all three. */
    public function test_the_admin_exposes_the_fields(): void
    {
        $aside = file_get_contents(
            resource_path('views/backend/product/product/component/aside.blade.php')
        );

        $this->assertStringContainsString('name="specs"', $aside);
        $this->assertStringContainsString('name="iframe"', $aside);

        $config = (new \App\Classes\System())->config();

        $this->assertArrayHasKey('template', $config, 'no settings group for the template pages');
        $this->assertArrayHasKey('handover', $config['template']['value']);
        $this->assertArrayHasKey('terms', $config['template']['value']);
    }

    /** specs has to be fillable, or the admin field is discarded on save in silence. */
    public function test_specs_is_mass_assignable(): void
    {
        $fillable = (new \App\Models\Product())->getFillable();

        $this->assertContains('specs', $fillable);
        $this->assertContains('iframe', $fillable);
    }
}
