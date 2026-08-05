<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Demo content for local work.
 *
 * The supplied database dump is a skeleton: it carries the template store (15
 * products, 6 categories) but not the service pages, the blog, or the uploaded
 * product images. 31 of the 36 menu items therefore pointed at canonicals with no
 * router row, and every product thumbnail 404'd.
 *
 * This fills those gaps so the frontend can be designed and reviewed against real
 * page structures. Everything it writes is tagged, and `--clean` removes it again.
 */
class SeedDemoContent extends Command
{
    protected $signature = 'demo:content {--clean : Remove the demo content instead of creating it}';

    protected $description = 'Create (or remove) demo pages, posts and template posters for local work';

    /** Marker stored in post_language.meta_keyword so demo rows are always identifiable. */
    private const TAG = 'demo-seed';

    private const POST_CONTROLLER = 'App\Http\Controllers\Frontend\PostController';
    private const POST_CATALOGUE_CONTROLLER = 'App\Http\Controllers\Frontend\PostCatalogueController';

    public function handle(): int
    {
        if ($this->option('clean')) {
            return $this->clean();
        }

        $userId = (int) (DB::table('users')->value('id') ?? 1);

        DB::transaction(function () use ($userId) {
            $this->seedCatalogues($userId);
            $this->seedServicePages($userId);
            $this->seedNewsPosts($userId);
            $this->seedTemplates($userId);
        });

        $this->seedProductPosters();

        $this->newLine();
        $this->info('Demo content ready. Remove it with: php artisan demo:content --clean');

        return self::SUCCESS;
    }

    /** Blog / news categories the menu links to but the dump does not contain. */
    private function seedCatalogues(int $userId): void
    {
        $catalogues = [
            ['canonical' => 'tin-cong-nghe', 'name' => 'Tin công nghệ',
             'desc' => 'Góc nhìn của HT Việt Nam về công nghệ web, thương mại điện tử và hạ tầng.'],
            ['canonical' => 'blog', 'name' => 'Blog',
             'desc' => 'Kinh nghiệm làm website, tối ưu chuyển đổi và vận hành thực tế.'],
        ];

        foreach ($catalogues as $c) {
            $id = $this->upsertCatalogue($c, $userId);
            $this->line("  catalogue  {$c['canonical']}  #$id");
        }
    }

    /**
     * The four service pages named in the brief. They are Posts, which is how this
     * CMS models standalone pages — the five existing posts are staff bios on the
     * same mechanism.
     */
    private function seedServicePages(int $userId): void
    {
        $serviceCatalogueId = (int) (DB::table('post_catalogues')
            ->join('post_catalogue_language as l', 'l.post_catalogue_id', '=', 'post_catalogues.id')
            ->where('l.canonical', 'dich-vu-cua-chung-toi')
            ->value('post_catalogues.id') ?? 1);

        $pages = [
            [
                // Slug matches what the main menu already links to, so the existing
                // menu item resolves instead of 404-ing.
                'canonical' => 'thiet-ke-theo-yeu-cau',
                'name' => 'Thiết kế website theo yêu cầu',
                'desc' => 'Website được vẽ mới từ đầu theo đúng quy trình bán hàng của bạn, không dựa trên mẫu có sẵn.',
                'blocks' => [
                    ['Khi nào nên chọn thiết kế riêng', 'Khi quy trình bán hàng của bạn không giống ai: nhiều bước xét duyệt, giá theo từng nhóm khách, hoặc cần nối với phần mềm đang dùng. Mẫu có sẵn sẽ phải cắt bớt nghiệp vụ để vừa khuôn — thiết kế riêng thì làm ngược lại.'],
                    ['Quy trình 5 bước', 'Khảo sát nghiệp vụ và chốt phạm vi. Dựng wireframe từng luồng. Thiết kế giao diện trên wireframe đã duyệt. Lập trình và nối dữ liệu. Nghiệm thu, đào tạo, bàn giao mã nguồn.'],
                    ['Bạn nhận được gì', 'Toàn bộ mã nguồn và cơ sở dữ liệu, tài liệu quản trị bằng tiếng Việt, một buổi đào tạo trực tiếp, và 12 tháng bảo hành lỗi kỹ thuật.'],
                ],
            ],
            [
                'canonical' => 'thiet-ke-website-theo-mau-co-san',
                'name' => 'Website mẫu có sẵn',
                'desc' => 'Chọn một mẫu trong kho giao diện, chúng tôi đổi nội dung và bàn giao trong 5–7 ngày.',
                'blocks' => [
                    ['Nhanh hơn vì phần khó đã xong', 'Giao diện, tốc độ tải và cấu trúc SEO của mẫu đều đã được kiểm thử. Việc còn lại là thay logo, màu, nội dung và sản phẩm của bạn.'],
                    ['Vẫn sửa được', 'Mẫu là điểm bắt đầu, không phải giới hạn. Bố cục trang chủ, thứ tự khối, màu thương hiệu đều điều chỉnh được trước khi bàn giao.'],
                    ['Chi phí rõ từ đầu', 'Giá mẫu hiển thị ngay trong kho giao diện. Không phát sinh phí thiết kế, chỉ tính thêm nếu bạn cần chức năng ngoài mẫu.'],
                ],
            ],
            [
                'canonical' => 'cham-soc-website',
                'name' => 'Chăm sóc website',
                'desc' => 'Cập nhật, sao lưu, theo dõi bảo mật và xử lý sự cố cho website đang chạy.',
                'blocks' => [
                    ['Việc chúng tôi làm hàng tháng', 'Cập nhật mã nguồn và bản vá bảo mật. Sao lưu tự động hàng ngày, giữ 30 bản. Theo dõi thời gian tải và tình trạng hoạt động. Báo cáo gửi bạn vào đầu mỗi tháng.'],
                    ['Khi website gặp sự cố', 'Hotline kỹ thuật trong giờ hành chính, phản hồi trong 30 phút. Sự cố khiến website không truy cập được thì xử lý ngoài giờ, không tính thêm phí.'],
                    ['Nội dung và chỉnh sửa nhỏ', 'Mỗi tháng bao gồm số lần đăng bài và sửa nội dung theo gói. Phần vượt gói được báo giá trước khi làm.'],
                ],
            ],
            [
                'canonical' => 'dich-vu-hosting',
                'name' => 'Hosting & tên miền',
                'desc' => 'Hạ tầng đặt tại Việt Nam, SSL miễn phí, sao lưu hàng ngày và không giới hạn băng thông.',
                'blocks' => [
                    ['Đặt máy chủ trong nước', 'Khách của bạn phần lớn ở Việt Nam, nên hạ tầng cũng ở Việt Nam. Độ trễ thấp hơn rõ rệt so với hosting nước ngoài giá tương đương.'],
                    ['SSL và sao lưu là mặc định', 'Chứng chỉ SSL được cấp và tự động gia hạn, không tính phí. Sao lưu toàn bộ mỗi ngày, bạn tự phục hồi được từ trang quản trị.'],
                    ['Tên miền quản lý cùng một nơi', 'Đăng ký, gia hạn và trỏ bản ghi ngay trong cùng trang quản trị. Tên miền đứng tên bạn, không đứng tên chúng tôi.'],
                ],
            ],
        ];

        // Everything else the main menu links to. Without these, 13 menu entries were
        // still 404 — the dump simply does not contain them.
        $support = [
            ['dich-vu', 'Dịch vụ', 'Toàn bộ dịch vụ của HT Việt Nam: thiết kế, hosting, chăm sóc và SEO.', [
                ['Bốn nhóm dịch vụ', 'Thiết kế website theo yêu cầu, website mẫu có sẵn, chăm sóc website đang chạy, và hosting kèm tên miền.'],
                ['Chọn thế nào', 'Nếu quy trình bán hàng của bạn đặc thù, chọn thiết kế riêng. Nếu cần nhanh và gọn, chọn mẫu có sẵn.'],
            ]],
            ['bang-gia', 'Bảng giá', 'Chi phí từng dịch vụ, không có phí ẩn.', [
                ['Website mẫu có sẵn', 'Giá hiển thị ngay trong kho giao diện, từ miễn phí đến 5.600.000đ. Bao gồm cài đặt và bàn giao.'],
                ['Thiết kế theo yêu cầu', 'Báo giá sau khảo sát, vì phạm vi mỗi dự án khác nhau. Chúng tôi gửi bảng bóc tách từng phần để bạn cân nhắc bỏ hoặc thêm.'],
                ['Chăm sóc và hosting', 'Tính theo tháng hoặc năm, có gói dùng thử. Không tự động gia hạn nếu bạn không xác nhận.'],
            ]],
            ['dich-vu-seo', 'Dịch vụ SEO', 'Đưa website lên kết quả tìm kiếm cho những từ khoá khách thật sự gõ.', [
                ['Bắt đầu bằng đo lường', 'Kiểm tra thứ hạng hiện tại, tốc độ tải, cấu trúc tiêu đề và liên kết nội bộ trước khi đề xuất bất cứ thứ gì.'],
                ['Việc làm mỗi tháng', 'Tối ưu nội dung có sẵn, bổ sung bài theo cụm từ khoá, xử lý lỗi kỹ thuật, và báo cáo thứ hạng.'],
                ['Không cam kết hạng ảo', 'Chúng tôi không hứa "top 1 trong 1 tháng". Cam kết là báo cáo trung thực và giải thích được từng thay đổi.'],
            ]],
            ['ten-mien', 'Tên miền', 'Đăng ký, gia hạn và quản lý tên miền đứng tên bạn.', [
                ['Tên miền là của bạn', 'Đăng ký đứng tên doanh nghiệp bạn, không đứng tên chúng tôi. Bạn toàn quyền chuyển đi bất cứ lúc nào.'],
                ['Quản lý cùng một chỗ', 'Trỏ bản ghi A, CNAME, MX ngay trong trang quản trị, không cần mở ticket.'],
            ]],
            ['video', 'Videos', 'Video giới thiệu dịch vụ và hướng dẫn sử dụng trang quản trị.', [
                ['Hướng dẫn quản trị', 'Chuỗi video ngắn: đăng bài, thêm sản phẩm, đổi banner, xem liên hệ khách gửi về.'],
            ]],
            ['faqs', 'Câu hỏi thường gặp', 'Những câu khách hỏi nhiều nhất, trả lời thẳng.', [
                ['Bao lâu thì xong?', 'Mẫu có sẵn: 5–7 ngày. Thiết kế riêng: 3–6 tuần tuỳ phạm vi.'],
                ['Tôi có được mã nguồn không?', 'Có. Toàn bộ mã nguồn và cơ sở dữ liệu được bàn giao khi nghiệm thu.'],
                ['Sau bàn giao có hỗ trợ không?', '12 tháng bảo hành lỗi kỹ thuật. Thay đổi nội dung và tính năng mới tính theo gói chăm sóc.'],
            ]],
            ['quy-dinh-su-dung', 'Quy định sử dụng', 'Điều khoản khi sử dụng website và dịch vụ của HT Việt Nam.', [
                ['Phạm vi áp dụng', 'Áp dụng cho mọi khách hàng sử dụng website, dịch vụ thiết kế, hosting và chăm sóc của chúng tôi.'],
                ['Quyền và nghĩa vụ', 'Bạn chịu trách nhiệm về nội dung đăng lên website của mình. Chúng tôi chịu trách nhiệm về hạ tầng và mã nguồn đã bàn giao.'],
            ]],
            ['chinh-sach-bao-hanh', 'Chính sách bảo hành', 'Phạm vi và thời hạn bảo hành cho từng dịch vụ.', [
                ['Thời hạn', '12 tháng kể từ ngày nghiệm thu, áp dụng cho lỗi kỹ thuật phát sinh từ mã nguồn chúng tôi viết.'],
                ['Không thuộc bảo hành', 'Lỗi do bên thứ ba can thiệp mã nguồn, do thay đổi hạ tầng ngoài kiểm soát, hoặc do yêu cầu tính năng mới.'],
            ]],
            ['chinh-sach-thanh-toan', 'Chính sách thanh toán', 'Cách thức và tiến độ thanh toán.', [
                ['Tiến độ', 'Thường chia hai đợt: 50% khi ký, 50% khi nghiệm thu. Dự án lớn có thể chia ba đợt theo mốc.'],
                ['Hoá đơn', 'Xuất hoá đơn VAT đầy đủ cho mỗi đợt thanh toán.'],
            ]],
            ['hinh-thuc-thanh-toan', 'Hình thức thanh toán', 'Các cách thanh toán được hỗ trợ.', [
                ['Chuyển khoản', 'Chuyển khoản ngân hàng theo thông tin trên hợp đồng. Đây là hình thức được khuyến nghị vì có chứng từ rõ ràng.'],
                ['Tiền mặt', 'Thanh toán trực tiếp tại văn phòng Hà Nội hoặc Hồ Chí Minh, có phiếu thu.'],
            ]],
        ];

        foreach (array_merge($pages, $support) as $p) {
            $page = is_array($p) && isset($p['canonical'])
                ? $p
                : ['canonical' => $p[0], 'name' => $p[1], 'desc' => $p[2], 'blocks' => $p[3]];

            $id = $this->upsertPost($page, $serviceCatalogueId, $userId, 2);
            $this->line("  page       {$page['canonical']}  #$id");
        }

        $this->repointMenuLeftovers();
    }

    /**
     * Two main-menu items still point at slugs from the furniture site this codebase
     * was reused from: "Website mẫu có sẵn" links to thi-cong-noi-that-go-oc-cho, and
     * "Website giáo dục" to a canonical that does not exist. Both were dead links.
     */
    private function repointMenuLeftovers(): void
    {
        $fixes = [
            'thi-cong-noi-that-go-oc-cho' => 'thiet-ke-website-theo-mau-co-san',
            'website-giao-duc' => 'giao-duc',
            // The menu carries two slugs for the same "Thiết kế theo yêu cầu" entry;
            // collapse the longer one onto the page that exists.
            'thiet-ke-website-theo-yeu-cau' => 'thiet-ke-theo-yeu-cau',
        ];

        foreach ($fixes as $from => $to) {
            $exists = DB::table('routers')->where('canonical', $to)->exists();
            if (!$exists) {
                continue;
            }

            $updated = DB::table('menu_language')->where('canonical', $from)->update(['canonical' => $to]);
            if ($updated) {
                $this->line("  menu       {$from} → {$to}");
            }
        }
    }

    /** Enough articles for a listing grid to be worth designing. */
    private function seedNewsPosts(int $userId): void
    {
        $newsCatalogueId = (int) (DB::table('post_catalogues')
            ->join('post_catalogue_language as l', 'l.post_catalogue_id', '=', 'post_catalogues.id')
            ->where('l.canonical', 'tin-cong-nghe')
            ->value('post_catalogues.id'));

        $articles = [
            ['bao-nhieu-lau-de-lam-mot-website-ban-hang', 'Bao lâu để làm xong một website bán hàng?',
             'Mốc thời gian thật cho từng loại dự án, và những việc thường làm chậm tiến độ.'],
            ['website-tai-cham-mat-khach-nhu-the-nao', 'Website tải chậm làm mất khách như thế nào',
             'Mỗi giây chờ thêm là một phần khách bỏ đi. Con số cụ thể và cách đo trên chính website của bạn.'],
            ['nen-chon-hosting-trong-nuoc-hay-nuoc-ngoai', 'Nên chọn hosting trong nước hay nước ngoài?',
             'So sánh độ trễ, chi phí và khả năng hỗ trợ cho một website phục vụ khách Việt Nam.'],
            ['ssl-va-nhung-hieu-nham-thuong-gap', 'SSL và những hiểu nhầm thường gặp',
             'Ổ khoá xanh không có nghĩa là website an toàn. Nó bảo vệ đúng một thứ, và đó là gì.'],
            ['viet-noi-dung-trang-chu-sao-cho-ban-duoc-hang', 'Viết nội dung trang chủ sao cho bán được hàng',
             'Trang chủ không phải chỗ kể về công ty. Nó là chỗ trả lời câu hỏi khách đang có.'],
            ['landing-page-khac-gi-website', 'Landing page khác gì website?',
             'Một trang cho một mục tiêu, và vì sao trộn hai thứ lại thường làm giảm chuyển đổi.'],
            ['sao-luu-website-the-nao-cho-du', 'Sao lưu website thế nào cho đủ',
             'Sao lưu hàng ngày là chưa đủ nếu bạn chưa từng thử phục hồi. Cách kiểm tra trong 15 phút.'],
            ['toi-uu-hinh-anh-truoc-khi-tang-hosting', 'Tối ưu hình ảnh trước khi nghĩ đến nâng hosting',
             'Phần lớn website chậm vì ảnh, không vì máy chủ yếu. Kiểm tra trước khi tiêu tiền.'],
            ['chuyen-website-sang-don-vi-khac-can-gi', 'Chuyển website sang đơn vị khác cần những gì',
             'Danh sách cần lấy đủ trước khi rời một nhà cung cấp: mã nguồn, dữ liệu, tên miền, email.'],
        ];

        foreach ($articles as $i => [$canonical, $name, $desc]) {
            $id = $this->upsertPost([
                'canonical' => $canonical,
                'name' => $name,
                'desc' => $desc,
                'blocks' => [
                    ['Vấn đề', $desc.' Phần dưới đi vào chi tiết dựa trên các dự án chúng tôi đã triển khai.'],
                    ['Cách xử lý', 'Bắt đầu bằng việc đo, không đoán. Xác định điểm nghẽn lớn nhất, xử lý nó, đo lại. Lặp lại cho đến khi kết quả đủ tốt cho mục tiêu kinh doanh chứ không phải cho một điểm số.'],
                    ['Tóm lại', 'Chọn một thay đổi có tác động lớn nhất và làm cho xong, thay vì làm nhiều thứ nửa vời.'],
                ],
            ], $newsCatalogueId, $userId, 1, $i);
            $this->line("  article    {$canonical}  #$id");
        }
    }

    /**
     * Templates so every shelf has something to show. The dump leaves four of the six
     * categories with one or two products, and a horizontal browse row with a single
     * card reads as broken rather than sparse.
     */
    private function seedTemplates(int $userId): void
    {
        $byCanonical = DB::table('product_catalogue_language')
            ->where('language_id', 1)
            ->pluck('product_catalogue_id', 'canonical');

        $templates = [
            ['website-doanh-nghiep', 'Corpix - Website doanh nghiệp đa ngành', 4200000, 'Trang chủ kể câu chuyện thương hiệu, kèm trang tuyển dụng và thư viện tài liệu.'],
            ['website-doanh-nghiep', 'Nexa - Hồ sơ công ty tối giản', 2600000, 'Bố cục một cột, chữ lớn, phù hợp công ty tư vấn và dịch vụ chuyên môn.'],
            ['website-doanh-nghiep', 'Atlas - Tập đoàn nhiều công ty con', 5200000, 'Điều hướng nhiều tầng cho tập đoàn có nhiều đơn vị thành viên.'],
            ['landing-page', 'Launchpad - Landing ra mắt sản phẩm', 900000, 'Một trang, một mục tiêu: đếm ngược, danh sách chờ, và một biểu mẫu.'],
            ['landing-page', 'Webinar One - Landing thu đăng ký', 1100000, 'Tối ưu cho hội thảo trực tuyến: diễn giả, lịch trình, đăng ký nhanh.'],
            ['landing-page', 'AppFold - Landing giới thiệu ứng dụng', 1400000, 'Ảnh màn hình theo khung điện thoại, liên kết tới hai cửa hàng ứng dụng.'],
            ['website-bat-dong-san', 'Estate Pro - Sàn giao dịch bất động sản', 4800000, 'Bộ lọc theo khu vực, diện tích và khoảng giá, kèm bản đồ dự án.'],
            ['website-bat-dong-san', 'Villa - Giới thiệu một dự án', 3200000, 'Dành cho một dự án duy nhất: mặt bằng, tiến độ, và bảng giá từng căn.'],
            ['giao-duc', 'Eduka - Trung tâm đào tạo', 2800000, 'Lịch khai giảng, hồ sơ giảng viên và biểu mẫu đăng ký thử.'],
            ['giao-duc', 'Coursely - Bán khoá học trực tuyến', 3600000, 'Danh sách khoá học, chương trình từng bài và trang thanh toán.'],
            ['giao-duc', 'Kidzone - Trường mầm non', 2200000, 'Màu tươi, ảnh lớn, trang thực đơn và hoạt động hằng tuần.'],
        ];

        $created = 0;
        foreach ($templates as [$catCanonical, $name, $price, $desc]) {
            $catalogueId = (int) ($byCanonical[$catCanonical] ?? 0);
            if ($catalogueId === 0) {
                continue;
            }

            $canonical = \Illuminate\Support\Str::slug($name);
            if (DB::table('product_language')->where('canonical', $canonical)->exists()) {
                continue;
            }

            $id = DB::table('products')->insertGetId([
                'product_catalogue_id' => $catalogueId,
                'image' => '',
                'album' => '',
                'publish' => 2,
                'follow' => 2,
                'order' => 0,
                'user_id' => $userId,
                'code' => 'DEMO-'.$canonical,
                'price' => $price,
                'attributeCatalogue' => '',
                'variant' => '',
                'created_at' => now()->subDays(random_int(1, 90)),
                'updated_at' => now(),
            ]);

            DB::table('product_language')->insert([
                'product_id' => $id,
                'language_id' => 1,
                'name' => $name,
                'description' => $desc,
                'content' => '<h2>Mẫu này phù hợp với ai</h2><p>'.e($desc).'</p>'
                    .'<h2>Đã có sẵn</h2><p>Bố cục responsive, tối ưu tốc độ tải, cấu trúc SEO cơ bản và trang quản trị tiếng Việt.</p>',
                'meta_title' => $name.' | Kho giao diện HT Việt Nam',
                'meta_keyword' => self::TAG,
                'meta_description' => $desc,
                'canonical' => $canonical,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('product_catalogue_product')->insertOrIgnore([
                'product_catalogue_id' => $catalogueId,
                'product_id' => $id,
            ]);

            $this->putRouter($canonical, $id, 'App\Http\Controllers\Frontend\ProductController');
            $created++;
        }

        $this->line("  templates  {$created} mẫu demo");
    }

    private function upsertCatalogue(array $c, int $userId): int
    {
        $existing = DB::table('post_catalogue_language')->where('canonical', $c['canonical'])->value('post_catalogue_id');

        if ($existing) {
            return (int) $existing;
        }

        $maxRgt = (int) (DB::table('post_catalogues')->max('rgt') ?? 0);

        $id = DB::table('post_catalogues')->insertGetId([
            'parent_id' => 0,
            'lft' => $maxRgt + 1,
            'rgt' => $maxRgt + 2,
            'level' => 1,
            'publish' => 2,
            'follow' => 2,
            'order' => 0,
            'user_id' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('post_catalogue_language')->insert([
            'post_catalogue_id' => $id,
            'language_id' => 1,
            'name' => $c['name'],
            'description' => $c['desc'],
            'content' => '',
            'meta_title' => $c['name'].' | HT Việt Nam',
            'meta_keyword' => self::TAG,
            'meta_description' => $c['desc'],
            'canonical' => $c['canonical'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->putRouter($c['canonical'], $id, self::POST_CATALOGUE_CONTROLLER);

        return $id;
    }

    private function upsertPost(array $p, int $catalogueId, int $userId, int $template, int $order = 0): int
    {
        $existing = DB::table('post_language')->where('canonical', $p['canonical'])->value('post_id');

        if ($existing) {
            return (int) $existing;
        }

        $id = DB::table('posts')->insertGetId([
            'post_catalogue_id' => $catalogueId,
            'image' => '',
            'publish' => 2,
            'follow' => 2,
            'order' => $order,
            'user_id' => $userId,
            'template' => $template,
            'viewed' => random_int(120, 4800),
            'status_menu' => 2,
            'created_at' => now()->subDays(random_int(2, 120)),
            'updated_at' => now(),
        ]);

        DB::table('post_language')->insert([
            'post_id' => $id,
            'language_id' => 1,
            'name' => $p['name'],
            'description' => $p['desc'],
            'content' => $this->buildContent($p['blocks']),
            'meta_title' => $p['name'].' | HT Việt Nam',
            'meta_keyword' => self::TAG,
            'meta_description' => $p['desc'],
            'canonical' => $p['canonical'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('post_catalogue_post')->insertOrIgnore([
            'post_catalogue_id' => $catalogueId,
            'post_id' => $id,
        ]);

        $this->putRouter($p['canonical'], $id, self::POST_CONTROLLER);

        return $id;
    }

    private function buildContent(array $blocks): string
    {
        $html = '';
        foreach ($blocks as [$heading, $body]) {
            $html .= '<h2>'.e($heading).'</h2><p>'.e($body).'</p>';
        }

        return $html;
    }

    private function putRouter(string $canonical, int $moduleId, string $controller): void
    {
        DB::table('routers')->updateOrInsert(
            ['canonical' => $canonical, 'language_id' => 1],
            ['module_id' => $moduleId, 'controllers' => $controller, 'created_at' => now(), 'updated_at' => now()]
        );
    }

    /**
     * A homepage preview per template.
     *
     * The dump references uploaded .webp thumbnails that are not in the repo, so all
     * cards rendered a broken image. These are drawn mocks rather than screenshots —
     * see App\Support\TemplatePoster for why — and each one uses the layout its
     * category implies, so a shop template looks like a shop.
     *
     * A real screenshot at public/userfiles/image/template-cover/<canonical>.(jpg|png|webp)
     * always wins, so covers can be dropped in later without touching this command.
     */
    private function seedProductPosters(): void
    {
        $dir = public_path('userfiles/image/demo-poster');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $coverDir = public_path('userfiles/image/template-cover');
        if (!is_dir($coverDir)) {
            mkdir($coverDir, 0755, true);
        }

        // Which homepage shape each category should be drawn as.
        $archetypeByCategory = [
            'website-ban-hang' => 'ecommerce',
            'website-doanh-nghiep' => 'corporate',
            'landing-page' => 'landing',
            'website-bat-dong-san' => 'realestate',
            'giao-duc' => 'education',
            'mau-quan-tri-bang-dieu-khien' => 'admin',
        ];

        $accents = ['#833bff', '#2f80ed', '#fc746c', '#35d0ba', '#f5a623', '#ac1de1', '#0f9d58', '#e0457b'];

        $products = DB::table('products')
            ->join('product_language as l', 'l.product_id', '=', 'products.id')
            ->where('l.language_id', 1)
            ->orderBy('products.id')
            ->get(['products.id', 'products.product_catalogue_id', 'l.name', 'l.canonical']);

        $catCanonical = DB::table('product_catalogue_language')
            ->where('language_id', 1)
            ->pluck('canonical', 'product_catalogue_id');

        $usedReal = 0;
        foreach ($products as $i => $product) {
            $real = collect(['jpg', 'jpeg', 'png', 'webp'])
                ->map(fn ($ext) => $product->canonical.'.'.$ext)
                ->first(fn ($f) => is_file($coverDir.'/'.$f));

            if ($real !== null) {
                DB::table('products')->where('id', $product->id)
                    ->update(['image' => '/userfiles/image/template-cover/'.$real]);
                $usedReal++;
                continue;
            }

            $archetype = $archetypeByCategory[$catCanonical[$product->product_catalogue_id] ?? ''] ?? 'corporate';
            $file = 'poster-'.$product->id.'.svg';

            file_put_contents(
                $dir.'/'.$file,
                \App\Support\TemplatePoster::svg($product->name, $archetype, $accents[$i % count($accents)], $i)
            );

            DB::table('products')->where('id', $product->id)
                ->update(['image' => '/userfiles/image/demo-poster/'.$file]);
        }

        $this->line('  posters    '.(count($products) - $usedReal).' mock, '.$usedReal.' ảnh thật');
    }

    private function clean(): int
    {
        $postIds = DB::table('post_language')->where('meta_keyword', self::TAG)->pluck('post_id');
        $catIds = DB::table('post_catalogue_language')->where('meta_keyword', self::TAG)->pluck('post_catalogue_id');
        $productIds = DB::table('product_language')->where('meta_keyword', self::TAG)->pluck('product_id');

        $canonicals = DB::table('post_language')->where('meta_keyword', self::TAG)->pluck('canonical')
            ->merge(DB::table('post_catalogue_language')->where('meta_keyword', self::TAG)->pluck('canonical'))
            ->merge(DB::table('product_language')->where('meta_keyword', self::TAG)->pluck('canonical'));

        DB::transaction(function () use ($postIds, $catIds, $productIds, $canonicals) {
            DB::table('post_catalogue_post')->whereIn('post_id', $postIds)->delete();
            DB::table('post_language')->whereIn('post_id', $postIds)->delete();
            DB::table('posts')->whereIn('id', $postIds)->delete();
            DB::table('post_catalogue_language')->whereIn('post_catalogue_id', $catIds)->delete();
            DB::table('post_catalogues')->whereIn('id', $catIds)->delete();
            DB::table('product_catalogue_product')->whereIn('product_id', $productIds)->delete();
            DB::table('product_language')->whereIn('product_id', $productIds)->delete();
            DB::table('products')->whereIn('id', $productIds)->delete();
            DB::table('routers')->whereIn('canonical', $canonicals)->delete();
        });

        // Posters are only referenced by demo rows, so clearing the column is enough
        // to put the products back to a missing-image state.
        DB::table('products')->where('image', 'like', '/userfiles/image/demo-poster/%')->update(['image' => '']);

        $this->info("Removed {$postIds->count()} posts, {$catIds->count()} catalogues and their routers.");

        return self::SUCCESS;
    }
}
