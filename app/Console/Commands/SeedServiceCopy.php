<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Fills the service pages with real, SEO-shaped copy.
 *
 * These pages shipped with two or three sentences each, which is not enough for a
 * visitor to decide anything and not enough for a search engine to rank. Each page here
 * gets a lead, headed sections that answer the questions someone actually asks before
 * buying, and a price range — written for this business, not lifted from a template.
 *
 * Like the other seeders this is reversible: --clean puts the original short copy back
 * from the backup column it writes on first run.
 *
 *     php artisan demo:service-copy
 *     php artisan demo:service-copy --clean
 */
class SeedServiceCopy extends Command
{
    protected $signature = 'demo:service-copy {--clean : Restore the original short copy}';

    protected $description = 'Write full SEO copy for the service pages (reversible)';

    /** Where the pre-seed copy is parked so --clean has something to restore. */
    private const BACKUP = 'storage/app/service-copy-backup.json';

    public function handle(): int
    {
        return $this->option('clean') ? $this->restore() : $this->seed();
    }

    private function seed(): int
    {
        $pages = $this->pages();
        $backupPath = base_path(self::BACKUP);

        // Back up once, on the first run, so re-running the seeder never overwrites the
        // backup with already-seeded copy.
        if (!file_exists($backupPath)) {
            $backup = [];
            foreach (array_keys($pages) as $canonical) {
                $row = DB::table('post_language')
                    ->join('posts', 'posts.id', '=', 'post_language.post_id')
                    ->where('post_language.canonical', $canonical)
                    ->select('post_language.post_id', 'post_language.language_id', 'post_language.description', 'post_language.content', 'post_language.meta_title', 'post_language.meta_description')
                    ->first();
                if ($row) {
                    $backup[$canonical] = (array) $row;
                }
            }
            file_put_contents($backupPath, json_encode($backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $this->info('Backed up original copy to '.self::BACKUP);
        }

        $done = 0;
        foreach ($pages as $canonical => $page) {
            $row = DB::table('post_language')->where('canonical', $canonical)->first();
            if (!$row) {
                $this->warn("skip {$canonical} — no post_language row");
                continue;
            }

            DB::table('post_language')
                ->where('post_id', $row->post_id)
                ->where('language_id', $row->language_id)
                ->update([
                    'description' => $page['lead'],
                    'content' => $this->render($page),
                    'meta_title' => $page['meta_title'],
                    'meta_description' => $page['meta_description'],
                ]);

            $done++;
            $this->line(sprintf('  %-38s %6d chars', $canonical, strlen($this->render($page))));
        }

        $this->info("Wrote copy for {$done} service pages.");

        return self::SUCCESS;
    }

    private function restore(): int
    {
        $path = base_path(self::BACKUP);
        if (!file_exists($path)) {
            $this->error('No backup found; nothing to restore.');

            return self::FAILURE;
        }

        $backup = json_decode(file_get_contents($path), true) ?: [];
        foreach ($backup as $canonical => $row) {
            DB::table('post_language')
                ->where('post_id', $row['post_id'])
                ->where('language_id', $row['language_id'])
                ->update([
                    'description' => $row['description'],
                    'content' => $row['content'],
                    'meta_title' => $row['meta_title'],
                    'meta_description' => $row['meta_description'],
                ]);
        }

        unlink($path);
        $this->info('Restored '.count($backup).' service pages.');

        return self::SUCCESS;
    }

    /** Turns a page definition into the HTML the editor would have produced. */
    private function render(array $page): string
    {
        $html = '';

        foreach ($page['sections'] as $section) {
            $html .= '<h2>'.$section['h'].'</h2>';

            foreach ($section['body'] as $block) {
                if (is_array($block)) {
                    $html .= '<ul>';
                    foreach ($block as $li) {
                        $html .= '<li>'.$li.'</li>';
                    }
                    $html .= '</ul>';
                    continue;
                }
                $html .= '<p>'.$block.'</p>';
            }
        }

        return $html;
    }

    /**
     * The copy itself. Written in the register the rest of the site uses: plain verbs,
     * concrete numbers, and no claim we would not stand behind on the phone.
     */
    private function pages(): array
    {
        return [
            'thiet-ke-theo-yeu-cau' => [
                'meta_title' => 'Thiết kế website theo yêu cầu — quy trình, thời gian, chi phí | HT Việt Nam',
                'meta_description' => 'Thiết kế website riêng theo đúng quy trình bán hàng của bạn: khảo sát nghiệp vụ, wireframe, giao diện, lập trình, bàn giao mã nguồn. 25–90 triệu, 4–10 tuần.',
                'lead' => 'Website được vẽ mới từ đầu theo đúng quy trình bán hàng của bạn, không cắt gọt nghiệp vụ để vừa một mẫu có sẵn. Bàn giao toàn bộ mã nguồn và cơ sở dữ liệu.',
                'sections' => [
                    [
                        'h' => 'Khi nào nên chọn thiết kế riêng',
                        'body' => [
                            'Mẫu có sẵn giải quyết rất tốt những website bán hàng hoặc giới thiệu doanh nghiệp thông thường. Nó bắt đầu vướng khi quy trình của bạn không giống ai.',
                            [
                                'Đơn hàng đi qua nhiều bước xét duyệt, mỗi bước một người khác nhìn thấy một phần dữ liệu khác nhau.',
                                'Giá tính theo nhóm khách, theo hợp đồng, theo bậc số lượng, hoặc theo công thức riêng của ngành.',
                                'Website phải nối với phần mềm bạn đang dùng: kế toán, kho, CRM, tổng đài, hoặc một API nội bộ.',
                                'Bạn có một luồng nghiệp vụ là lợi thế cạnh tranh và không muốn nó phải chạy theo khuôn của người khác.',
                            ],
                            'Nếu không có điểm nào ở trên, chúng tôi sẽ nói thẳng là bạn nên chọn mẫu có sẵn và giữ lại phần ngân sách chênh lệch cho quảng cáo. Việc đó có lợi cho bạn hơn.',
                        ],
                    ],
                    [
                        'h' => 'Quy trình 5 bước',
                        'body' => [
                            'Mỗi bước có một sản phẩm bạn xem được và duyệt được. Không có bước nào kết thúc bằng một lời hứa.',
                            [
                                '<strong>Khảo sát nghiệp vụ (3–5 ngày).</strong> Chúng tôi ngồi với người đang làm công việc đó, không chỉ với người quyết định. Kết quả là một tài liệu phạm vi liệt kê từng chức năng, từng vai trò và từng trường dữ liệu.',
                                '<strong>Wireframe (5–7 ngày).</strong> Bố cục từng luồng bằng khối xám, chưa có màu và hình. Giai đoạn này sửa rẻ nhất, nên chúng tôi sửa đến khi bạn duyệt.',
                                '<strong>Giao diện (7–14 ngày).</strong> Thiết kế trên wireframe đã duyệt, đủ cả bản desktop và điện thoại. Bạn nhận file thiết kế, không chỉ ảnh chụp.',
                                '<strong>Lập trình và nối dữ liệu (3–6 tuần).</strong> Bạn có một địa chỉ thử nghiệm ngay từ tuần đầu và xem được tiến độ mỗi tuần.',
                                '<strong>Nghiệm thu và bàn giao (3–5 ngày).</strong> Chạy hết các luồng đã ký trong tài liệu phạm vi, đào tạo trực tiếp một buổi, bàn giao mã nguồn và cơ sở dữ liệu.',
                            ],
                        ],
                    ],
                    [
                        'h' => 'Chi phí và thời gian',
                        'body' => [
                            'Chi phí phụ thuộc vào số luồng nghiệp vụ, không phụ thuộc vào số trang. Một website 40 trang tĩnh rẻ hơn một website 6 trang có luồng xét duyệt nhiều cấp.',
                            [
                                '<strong>25–40 triệu, 4–6 tuần.</strong> Một luồng chính, ví dụ đặt hàng hoặc đăng ký dịch vụ, cùng trang quản trị tương ứng.',
                                '<strong>40–70 triệu, 6–8 tuần.</strong> Nhiều luồng, nhiều vai trò người dùng, giá theo nhóm khách, báo cáo theo yêu cầu.',
                                '<strong>70–90 triệu trở lên, 8–10 tuần.</strong> Có tích hợp với phần mềm bên thứ ba, đồng bộ hai chiều, hoặc yêu cầu bảo mật riêng.',
                            ],
                            'Báo giá được chia theo từng đầu việc và thanh toán theo bốn mốc: 30% khi ký, 30% khi duyệt giao diện, 30% khi nghiệm thu, 10% sau 15 ngày chạy thật.',
                        ],
                    ],
                    [
                        'h' => 'Bạn nhận được gì khi bàn giao',
                        'body' => [
                            [
                                'Toàn bộ mã nguồn và cơ sở dữ liệu, kèm hướng dẫn cài đặt lên máy chủ khác.',
                                'Tài liệu quản trị bằng tiếng Việt, viết theo đúng màn hình bạn đang dùng.',
                                'Một buổi đào tạo trực tiếp, có ghi lại để nhân sự mới xem sau.',
                                'Bảo hành 12 tháng cho lỗi kỹ thuật, không giới hạn số lần.',
                                'Tài khoản quản trị cấp cao nhất thuộc về bạn, không phải thuộc về chúng tôi.',
                            ],
                            'Sau 12 tháng, bạn có thể tự vận hành, thuê người khác, hoặc dùng gói chăm sóc website của chúng tôi. Chúng tôi không giữ khoá nào để bạn buộc phải quay lại.',
                        ],
                    ],
                    [
                        'h' => 'Câu hỏi thường gặp trước khi ký',
                        'body' => [
                            '<strong>Tôi chưa có nội dung thì có làm được không?</strong> Được. Chúng tôi dựng bằng nội dung mẫu và thay dần. Nhưng phần văn bản chính nên do bạn viết vì bạn hiểu khách của mình nhất; chúng tôi biên tập lại.',
                            '<strong>Đang chạy dở giữa đường muốn đổi yêu cầu?</strong> Thay đổi trong phạm vi đã ký thì miễn phí. Thêm luồng mới thì báo giá bổ sung trước khi làm, không tính thêm sau.',
                            '<strong>Website có tự lên Google không?</strong> Không. Chúng tôi làm đúng phần kỹ thuật SEO: tốc độ, cấu trúc, dữ liệu có cấu trúc, sitemap. Còn thứ hạng cần nội dung và thời gian.',
                        ],
                    ],
                ],
            ],

            'thiet-ke-website-theo-mau-co-san' => [
                'meta_title' => 'Thiết kế website theo mẫu có sẵn — bàn giao trong 5–7 ngày | HT Việt Nam',
                'meta_description' => 'Chọn một mẫu trong kho giao diện, đổi logo, màu, nội dung và nhận website chạy thật sau 5–7 ngày. Từ 4,5 triệu, gồm hosting và tên miền năm đầu.',
                'lead' => 'Chọn một mẫu trong kho giao diện, chúng tôi cài đặt, đổi thương hiệu và đưa nội dung của bạn vào. Website chạy thật sau 5–7 ngày làm việc.',
                'sections' => [
                    [
                        'h' => 'Mẫu có sẵn nghĩa là gì',
                        'body' => [
                            'Mỗi mẫu trong kho giao diện là một website hoàn chỉnh đã lập trình xong: đã có trang chủ, danh mục, chi tiết, giỏ hàng hoặc form liên hệ, và trang quản trị. Việc còn lại là mặc thương hiệu của bạn vào.',
                            'Bạn không dùng chung website với ai. Mỗi lần triển khai là một bản cài đặt riêng, cơ sở dữ liệu riêng, tên miền riêng. Mẫu chỉ là điểm bắt đầu.',
                        ],
                    ],
                    [
                        'h' => 'Chúng tôi thay đổi những gì',
                        'body' => [
                            [
                                'Logo, bộ màu và phông chữ theo nhận diện của bạn.',
                                'Toàn bộ nội dung, hình ảnh, thông tin liên hệ, bản đồ, tài khoản mạng xã hội.',
                                'Cấu trúc menu và danh mục theo đúng ngành của bạn.',
                                'Thêm hoặc bỏ khối trên trang chủ để phù hợp với thứ bạn muốn khách nhìn thấy trước.',
                                'Gắn Google Analytics, Google Search Console, Facebook Pixel nếu bạn cần.',
                            ],
                            'Việc không nằm trong gói: đổi bố cục sang một thiết kế khác, thêm luồng nghiệp vụ mới, hoặc nối với phần mềm bên ngoài. Những việc đó thuộc phần thiết kế theo yêu cầu.',
                        ],
                    ],
                    [
                        'h' => 'Chi phí và những gì đã gồm trong đó',
                        'body' => [
                            [
                                '<strong>4,5 triệu.</strong> Website giới thiệu doanh nghiệp hoặc dịch vụ, tối đa 8 trang nội dung.',
                                '<strong>7,5 triệu.</strong> Website bán hàng có giỏ hàng, quản lý đơn, quản lý tồn kho cơ bản.',
                                '<strong>12 triệu.</strong> Website bán hàng nhiều danh mục, nhiều thuộc tính sản phẩm, tích hợp cổng thanh toán.',
                            ],
                            'Cả ba mức đã gồm hosting và tên miền .com hoặc .vn năm đầu, chứng chỉ SSL, và 3 tháng hỗ trợ sửa nội dung không giới hạn. Từ năm thứ hai, phí duy trì hosting và tên miền tính theo bảng giá công khai.',
                        ],
                    ],
                    [
                        'h' => 'Bảy ngày đó diễn ra thế nào',
                        'body' => [
                            [
                                '<strong>Ngày 1.</strong> Bạn chốt mẫu và gửi logo, nội dung, hình ảnh. Chúng tôi mua tên miền và dựng hosting.',
                                '<strong>Ngày 2–3.</strong> Cài mẫu, đổi bộ nhận diện, dựng cấu trúc menu và danh mục.',
                                '<strong>Ngày 4–5.</strong> Đưa nội dung vào, tối ưu ảnh, cấu hình SEO cơ bản cho từng trang.',
                                '<strong>Ngày 6.</strong> Bạn xem trên địa chỉ thử nghiệm và gửi lại danh sách cần sửa.',
                                '<strong>Ngày 7.</strong> Sửa xong, trỏ tên miền, bật SSL, hướng dẫn bạn dùng trang quản trị.',
                            ],
                            'Mốc thường bị trễ nhất là ngày 1, khi nội dung chưa sẵn. Nếu bạn gửi đủ ngay từ đầu, phần còn lại gần như luôn đúng hạn.',
                        ],
                    ],
                ],
            ],

            'cham-soc-website' => [
                'meta_title' => 'Chăm sóc website hằng tháng — cập nhật, sao lưu, bảo mật | HT Việt Nam',
                'meta_description' => 'Gói chăm sóc website: cập nhật bản vá, sao lưu hằng ngày, theo dõi uptime, xử lý sự cố, sửa nội dung theo yêu cầu. Từ 600 nghìn/tháng, không ràng buộc dài hạn.',
                'lead' => 'Website không tự hỏng, nhưng nó tự cũ. Gói chăm sóc giữ cho bản vá được cập nhật, dữ liệu được sao lưu, và có người nhấc máy khi trang không truy cập được.',
                'sections' => [
                    [
                        'h' => 'Vì sao một website đang chạy tốt vẫn cần chăm sóc',
                        'body' => [
                            'Phần lớn sự cố chúng tôi xử lý không đến từ lỗi lập trình. Nó đến từ những thứ đứng im trong khi thế giới bên ngoài thay đổi.',
                            [
                                'Bản vá bảo mật không được cập nhật, đến một ngày bị quét và bị chèn mã.',
                                'Chứng chỉ SSL hết hạn, trình duyệt chặn và khách thấy cảnh báo đỏ.',
                                'Tên miền hết hạn vì email nhắc gửi vào hộp thư của một nhân sự đã nghỉ.',
                                'Ảnh tải lên không nén, sau hai năm trang chủ nặng 12MB và mất 9 giây để mở.',
                                'Không ai sao lưu, đến lúc cần thì không có gì để phục hồi.',
                            ],
                        ],
                    ],
                    [
                        'h' => 'Ba gói và ranh giới giữa chúng',
                        'body' => [
                            [
                                '<strong>Cơ bản — 600 nghìn/tháng.</strong> Sao lưu hằng ngày giữ 30 bản, cập nhật bản vá, theo dõi uptime 5 phút một lần, báo cáo mỗi tháng. Hỗ trợ trong giờ hành chính.',
                                '<strong>Tiêu chuẩn — 1,5 triệu/tháng.</strong> Toàn bộ gói cơ bản, cộng 4 giờ sửa nội dung hoặc chỉnh giao diện mỗi tháng, tối ưu tốc độ mỗi quý, quét mã độc hằng tuần.',
                                '<strong>Ưu tiên — 3,5 triệu/tháng.</strong> Toàn bộ gói tiêu chuẩn, cộng 12 giờ mỗi tháng, hỗ trợ ngoài giờ, và cam kết phản hồi trong 2 giờ với sự cố khiến website không truy cập được.',
                            ],
                            'Giờ công không dùng hết không được cộng dồn sang tháng sau. Chúng tôi nói trước điều này vì nó là câu hỏi thứ hai của gần như mọi khách hàng.',
                        ],
                    ],
                    [
                        'h' => 'Khi có sự cố thì quy trình là gì',
                        'body' => [
                            'Hệ thống theo dõi phát hiện trang không phản hồi và gửi cảnh báo trước khi bạn kịp nhận ra. Với gói ưu tiên, chúng tôi bắt đầu xử lý ngay mà không chờ bạn gọi.',
                            [
                                'Xác định phạm vi: toàn bộ website, một trang, hay chỉ một chức năng.',
                                'Nếu là tấn công hoặc lỗi dữ liệu, phục hồi từ bản sao lưu gần nhất trước, rồi mới tìm nguyên nhân.',
                                'Báo cho bạn nguyên nhân và cách xử lý bằng tiếng Việt, không bằng ảnh chụp log.',
                                'Ghi vào báo cáo tháng để lần sau không lặp lại.',
                            ],
                        ],
                    ],
                    [
                        'h' => 'Ràng buộc hợp đồng',
                        'body' => [
                            'Thanh toán theo tháng hoặc theo năm, đóng năm được giảm 10%. Không có phí khởi tạo và không có cam kết thời hạn tối thiểu: bạn dừng bất cứ tháng nào cũng được, chỉ cần báo trước 15 ngày.',
                            'Khi dừng, chúng tôi giao lại toàn bộ tài khoản, bản sao lưu mới nhất và ghi chú kỹ thuật. Không giữ lại gì để gây khó cho người tiếp nhận sau bạn.',
                        ],
                    ],
                ],
            ],

            'dich-vu-hosting' => [
                'meta_title' => 'Hosting và tên miền cho website doanh nghiệp | HT Việt Nam',
                'meta_description' => 'Hosting SSD đặt tại Việt Nam và Singapore, SSL miễn phí, sao lưu hằng ngày, hỗ trợ tiếng Việt. Từ 55 nghìn/tháng. Tên miền .vn và .com đăng ký đứng tên bạn.',
                'lead' => 'Hosting SSD đặt tại Việt Nam hoặc Singapore, chứng chỉ SSL miễn phí, sao lưu hằng ngày. Tên miền đăng ký đứng tên bạn, không đứng tên chúng tôi.',
                'sections' => [
                    [
                        'h' => 'Chọn nơi đặt máy chủ',
                        'body' => [
                            'Khách của bạn ở đâu thì đặt máy chủ gần đó. Đây là quyết định ảnh hưởng đến tốc độ nhiều hơn mọi thủ thuật tối ưu khác cộng lại.',
                            [
                                '<strong>Việt Nam.</strong> Nhanh nhất cho khách trong nước, thường dưới 20ms. Chọn mặc định nếu bạn bán hàng nội địa.',
                                '<strong>Singapore.</strong> Chậm hơn trong nước khoảng 30–40ms nhưng ổn định hơn khi có khách ở nước ngoài, và không phụ thuộc vào tuyến cáp quốc tế khi cáp gặp sự cố.',
                            ],
                            'Nếu bạn có cả hai nhóm khách, chúng tôi đặt máy chủ tại Việt Nam và bật CDN cho phần hình ảnh. Cách này rẻ hơn thuê hai máy chủ.',
                        ],
                    ],
                    [
                        'h' => 'Các gói hosting',
                        'body' => [
                            [
                                '<strong>Khởi đầu — 55 nghìn/tháng.</strong> 3GB SSD, 1 website, 30GB băng thông. Đủ cho website giới thiệu doanh nghiệp dưới 300 lượt xem mỗi ngày.',
                                '<strong>Doanh nghiệp — 145 nghìn/tháng.</strong> 10GB SSD, 3 website, băng thông không giới hạn. Đủ cho website bán hàng vài nghìn lượt xem mỗi ngày.',
                                '<strong>Cao cấp — 390 nghìn/tháng.</strong> 30GB SSD, không giới hạn website, tài nguyên CPU riêng. Dành cho website nhiều sản phẩm hoặc có lúc tăng tải đột ngột.',
                            ],
                            'Cả ba gói đều có SSL Let\'s Encrypt tự động gia hạn, sao lưu hằng ngày giữ 14 bản, email theo tên miền, và bảng quản trị cPanel tiếng Việt.',
                        ],
                    ],
                    [
                        'h' => 'Tên miền',
                        'body' => [
                            [
                                '<strong>.com</strong> — 320 nghìn năm đầu, 350 nghìn từ năm thứ hai.',
                                '<strong>.vn</strong> — 830 nghìn năm đầu, 480 nghìn từ năm thứ hai. Cần giấy tờ doanh nghiệp hoặc căn cước.',
                                '<strong>.com.vn</strong> — 700 nghìn năm đầu, 380 nghìn từ năm thứ hai.',
                            ],
                            'Tên miền đăng ký đứng tên bạn hoặc doanh nghiệp của bạn, và bạn nhận thông tin đăng nhập nhà đăng ký. Đây là điều nên kiểm tra với bất kỳ đơn vị nào bạn làm việc: tên miền đứng tên nhà cung cấp là rủi ro lớn nhất mà chủ website thường không biết mình đang mang.',
                        ],
                    ],
                    [
                        'h' => 'Chuyển website đang chạy sang đây',
                        'body' => [
                            'Chuyển miễn phí, và làm theo cách khách của bạn không nhận ra có gì xảy ra.',
                            [
                                'Sao chép toàn bộ mã nguồn và dữ liệu sang máy chủ mới, chạy thử trên địa chỉ tạm.',
                                'Bạn kiểm tra và xác nhận bản chạy thử đúng.',
                                'Hạ thời gian sống của bản ghi DNS xuống 5 phút, rồi mới trỏ tên miền.',
                                'Giữ máy chủ cũ chạy song song 7 ngày để không mất đơn hàng nào trong lúc DNS lan truyền.',
                            ],
                        ],
                    ],
                ],
            ],

            'dich-vu-seo' => [
                'meta_title' => 'Dịch vụ SEO cho website doanh nghiệp — làm gì và không hứa gì | HT Việt Nam',
                'meta_description' => 'SEO kỹ thuật, nội dung và đo lường cho website doanh nghiệp. Báo cáo theo lưu lượng và chuyển đổi, không theo thứ hạng từ khoá lẻ. Từ 6 triệu/tháng.',
                'lead' => 'Tối ưu để website được tìm thấy bởi người đang cần thứ bạn bán. Chúng tôi báo cáo theo lưu lượng và số liên hệ thực, không theo thứ hạng của một từ khoá lẻ.',
                'sections' => [
                    [
                        'h' => 'Điều chúng tôi không hứa',
                        'body' => [
                            'Không ai kiểm soát được thuật toán của Google, nên bất kỳ ai cam kết top 1 trong 30 ngày đều đang bán cho bạn một trong hai thứ: từ khoá không có người tìm, hoặc một cách làm sẽ khiến website bị phạt về sau.',
                            'Chúng tôi cam kết những thứ nằm trong tầm kiểm soát: khối lượng công việc mỗi tháng, chất lượng kỹ thuật, và một báo cáo trung thực kể cả khi số liệu đi xuống.',
                        ],
                    ],
                    [
                        'h' => 'Ba việc thực sự làm mỗi tháng',
                        'body' => [
                            [
                                '<strong>Kỹ thuật.</strong> Tốc độ tải, Core Web Vitals, dữ liệu có cấu trúc, sitemap, thẻ canonical, xử lý trang trùng nội dung, sửa liên kết hỏng.',
                                '<strong>Nội dung.</strong> Nghiên cứu từ khoá theo ý định tìm kiếm, dựng cấu trúc chủ đề, viết hoặc biên tập bài, tối ưu trang danh mục và trang dịch vụ đang có.',
                                '<strong>Đo lường.</strong> Cấu hình theo dõi chuyển đổi, đọc Search Console mỗi tuần, và quyết định tháng sau làm gì dựa trên dữ liệu chứ dựa trên cảm giác.',
                            ],
                        ],
                    ],
                    [
                        'h' => 'Chi phí và mốc thời gian thực tế',
                        'body' => [
                            [
                                '<strong>6 triệu/tháng.</strong> SEO kỹ thuật và tối ưu nội dung đang có, 4 bài mới mỗi tháng.',
                                '<strong>12 triệu/tháng.</strong> Thêm nghiên cứu chủ đề theo cụm, 8 bài mỗi tháng, tối ưu trang đích cho quảng cáo.',
                                '<strong>20 triệu/tháng trở lên.</strong> Cho ngành cạnh tranh cao, có thêm xây dựng liên kết và tối ưu cho nhiều tỉnh thành.',
                            ],
                            'Mốc hợp lý để đánh giá: tháng 1–2 gần như không thấy gì, tháng 3–4 bắt đầu tăng lượt hiển thị, tháng 5–6 mới thấy lưu lượng và liên hệ tăng rõ. Nếu bạn cần khách trong 30 ngày thì nên chạy quảng cáo song song, chúng tôi sẽ nói vậy ngay từ buổi đầu.',
                        ],
                    ],
                ],
            ],

            'bang-gia' => [
                'meta_title' => 'Bảng giá thiết kế website, hosting và chăm sóc website | HT Việt Nam',
                'meta_description' => 'Bảng giá công khai: website mẫu từ 4,5 triệu, thiết kế riêng từ 25 triệu, hosting từ 55 nghìn/tháng, chăm sóc website từ 600 nghìn/tháng.',
                'lead' => 'Giá công khai cho toàn bộ dịch vụ, kèm những gì đã gồm trong mỗi mức và những gì tính thêm. Không có mức giá nào phải nhấc máy mới biết.',
                'sections' => [
                    [
                        'h' => 'Thiết kế website',
                        'body' => [
                            [
                                '<strong>Website mẫu có sẵn — từ 4,5 triệu.</strong> Bàn giao 5–7 ngày, gồm hosting và tên miền năm đầu.',
                                '<strong>Website bán hàng theo mẫu — từ 7,5 triệu.</strong> Có giỏ hàng, quản lý đơn và tồn kho cơ bản.',
                                '<strong>Thiết kế riêng — từ 25 triệu.</strong> Vẽ mới theo quy trình của bạn, 4–10 tuần tuỳ số luồng nghiệp vụ.',
                            ],
                        ],
                    ],
                    [
                        'h' => 'Vận hành hằng tháng',
                        'body' => [
                            [
                                '<strong>Hosting — từ 55 nghìn/tháng.</strong> SSD, SSL miễn phí, sao lưu hằng ngày.',
                                '<strong>Chăm sóc website — từ 600 nghìn/tháng.</strong> Cập nhật, sao lưu, theo dõi, xử lý sự cố.',
                                '<strong>SEO — từ 6 triệu/tháng.</strong> Kỹ thuật, nội dung và đo lường.',
                            ],
                        ],
                    ],
                    [
                        'h' => 'Những khoản tính thêm',
                        'body' => [
                            'Nói trước để bạn không gặp con số lạ trên hoá đơn.',
                            [
                                'Tên miền từ năm thứ hai, theo giá nhà đăng ký công bố.',
                                'Viết nội dung ngoài phạm vi đã ký: 350 nghìn cho mỗi bài 800 từ.',
                                'Chụp ảnh sản phẩm: báo giá theo số lượng, tối thiểu 30 ảnh.',
                                'Thêm luồng nghiệp vụ sau khi đã duyệt phạm vi: báo giá trước khi làm.',
                            ],
                            'Giá trên chưa gồm thuế giá trị gia tăng. Cần hoá đơn thì cộng 8% theo quy định hiện hành.',
                        ],
                    ],
                ],
            ],
        ];
    }
}
