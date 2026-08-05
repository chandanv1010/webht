<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * SEO copy for the template store categories.
 *
 * The dump ships every category with an empty description, which leaves the store
 * with nothing for search engines to read and nothing for a visitor deciding between
 * two categories. This writes a full block per category: what the category is for,
 * who it suits, what is included, and a short FAQ.
 *
 * Written as demo copy — accurate to what HT Việt Nam sells, but meant to be edited
 * in the admin rather than treated as final. `--clean` empties the fields again.
 */
class SeedCategoryCopy extends Command
{
    protected $signature = 'demo:category-copy {--clean : Empty the descriptions instead of writing them}';

    protected $description = 'Write (or remove) SEO copy for the product categories';

    public function handle(): int
    {
        $copy = $this->copy();

        foreach ($copy as $canonical => $block) {
            $id = DB::table('product_catalogue_language')
                ->where('language_id', 1)->where('canonical', $canonical)
                ->value('product_catalogue_id');

            if (!$id) {
                $this->warn("  bỏ qua   {$canonical} (không có trong DB)");
                continue;
            }

            if ($this->option('clean')) {
                DB::table('product_catalogue_language')
                    ->where('language_id', 1)->where('product_catalogue_id', $id)
                    ->update(['description' => '', 'content' => '']);
                $this->line("  xoá     {$canonical}");
                continue;
            }

            DB::table('product_catalogue_language')
                ->where('language_id', 1)->where('product_catalogue_id', $id)
                ->update([
                    'description' => $this->render($block),
                    'meta_title' => $block['meta_title'],
                    'meta_description' => $block['meta_description'],
                    'meta_keyword' => $block['meta_keyword'],
                ]);

            $this->line(sprintf('  %-30s %5d ký tự', $canonical, mb_strlen($this->render($block))));
        }

        $this->newLine();
        $this->info($this->option('clean')
            ? 'Đã xoá mô tả danh mục.'
            : 'Đã ghi mô tả danh mục. Xoá lại: php artisan demo:category-copy --clean');

        return self::SUCCESS;
    }

    /** Builds the HTML the frontend renders inside the read-more block. */
    private function render(array $b): string
    {
        $html = '<p class="lead">'.e($b['lead']).'</p>';

        foreach ($b['sections'] as [$heading, $paras]) {
            $html .= '<h2>'.e($heading).'</h2>';
            foreach ((array) $paras as $p) {
                $html .= is_array($p)
                    ? '<ul>'.implode('', array_map(fn ($li) => '<li>'.e($li).'</li>', $p)).'</ul>'
                    : '<p>'.e($p).'</p>';
            }
        }

        $html .= '<h2>Câu hỏi thường gặp</h2>';
        foreach ($b['faq'] as [$q, $a]) {
            $html .= '<h3>'.e($q).'</h3><p>'.e($a).'</p>';
        }

        return $html;
    }

    private function copy(): array
    {
        // Shared closing sections — every category answers these, and repeating the
        // wording by hand would drift.
        $included = ['Mọi mẫu trong danh mục này đã có sẵn', [[
            'Bố cục chạy tốt trên điện thoại, máy tính bảng và máy tính.',
            'Tối ưu tốc độ tải: ảnh nén đúng định dạng, CSS và JS gộp lại.',
            'Cấu trúc SEO cơ bản: thẻ tiêu đề, mô tả, dữ liệu có cấu trúc và sơ đồ site.',
            'Trang quản trị tiếng Việt, không cần biết code để đăng nội dung.',
            'SSL, sao lưu hằng ngày và hosting đặt tại Việt Nam trong năm đầu.',
        ]]];

        $process = ['Từ lúc chọn mẫu đến lúc website chạy', [
            'Bạn chọn mẫu và gửi nội dung: logo, màu thương hiệu, hình ảnh, danh sách sản phẩm hoặc dịch vụ. Nếu chưa có, chúng tôi dùng nội dung mẫu để bạn hình dung rồi thay sau.',
            'Chúng tôi cài đặt, thay nội dung và tinh chỉnh màu trong 5–7 ngày làm việc. Bạn xem trên đường dẫn thử nghiệm và góp ý.',
            'Sau khi bạn nghiệm thu, website lên tên miền chính thức. Chúng tôi bàn giao mã nguồn, tài khoản quản trị và một buổi hướng dẫn sử dụng.',
        ]];

        return [
            'kho-giao-dien' => [
                'meta_title' => 'Kho giao diện website — 36 mẫu sẵn dùng | HT Việt Nam',
                'meta_description' => 'Kho giao diện website của HT Việt Nam: mẫu bán hàng, doanh nghiệp, landing page, bất động sản, giáo dục và quản trị. Xem trước, chọn mẫu, bàn giao trong 5–7 ngày.',
                'meta_keyword' => 'kho giao diện website, mẫu website, thiết kế website theo mẫu, template website',
                'lead' => 'Toàn bộ mẫu website HT Việt Nam đang có, chia theo lĩnh vực. Xem trước từng mẫu, so sánh theo mức giá, chọn cái gần nhất với việc bạn đang làm rồi chúng tôi đổi nội dung thành của bạn.',
                'sections' => [
                    ['Chọn mẫu có sẵn hay thiết kế riêng?', [
                        'Mẫu có sẵn phù hợp khi cách bạn bán hàng giống phần lớn doanh nghiệp cùng ngành: giới thiệu, danh mục, chi tiết, liên hệ hoặc đặt hàng. Phần khó nhất — bố cục, tốc độ, cấu trúc SEO — đã được làm và kiểm thử sẵn, nên bạn tiết kiệm cả thời gian và chi phí.',
                        'Thiết kế riêng đáng tiền khi quy trình của bạn khác biệt thật: nhiều bước xét duyệt, giá theo từng nhóm khách, hoặc cần nối với phần mềm kế toán và kho đang dùng. Khi đó mẫu có sẵn sẽ phải cắt bớt nghiệp vụ để vừa khuôn.',
                        'Không chắc thuộc nhóm nào thì gọi cho chúng tôi trước khi chọn. Mất mười phút để nói rõ, hơn là làm xong mới phát hiện thiếu.',
                    ]],
                    $included,
                    $process,
                    ['Giá trong kho có phải giá cuối cùng?', [
                        'Đúng. Giá hiển thị trên mỗi mẫu là giá bàn giao website hoàn chỉnh, đã bao gồm cài đặt và thay nội dung. Chỉ phát sinh thêm khi bạn cần chức năng ngoài phạm vi mẫu — và luôn được báo giá trước khi làm.',
                    ]],
                ],
                'faq' => [
                    ['Tôi sửa được nội dung sau khi bàn giao không?', 'Được. Bài viết, sản phẩm, banner, thông tin liên hệ đều tự sửa trong trang quản trị. Chúng tôi hướng dẫn trực tiếp một buổi khi bàn giao.'],
                    ['Mẫu miễn phí khác gì mẫu có phí?', 'Mẫu miễn phí ít trang và ít khối nội dung hơn, phù hợp để thử hoặc làm website giới thiệu đơn giản. Mẫu có phí có nhiều trang chuyên biệt hơn và được hỗ trợ cài đặt đầy đủ.'],
                    ['Sau này muốn đổi sang mẫu khác thì sao?', 'Nội dung nằm trong cơ sở dữ liệu, không nằm trong giao diện, nên đổi mẫu không mất bài viết hay sản phẩm. Chúng tôi báo phí chuyển giao diện tuỳ mức độ khác nhau giữa hai mẫu.'],
                ],
            ],

            'website-ban-hang' => [
                'meta_title' => 'Mẫu website bán hàng, thương mại điện tử | HT Việt Nam',
                'meta_description' => 'Mẫu website bán hàng có giỏ hàng, bộ lọc sản phẩm và thanh toán. Đồng bộ tồn kho, tối ưu tốc độ và SEO. Bàn giao 5–7 ngày, kèm mã nguồn.',
                'meta_keyword' => 'website bán hàng, mẫu web thương mại điện tử, thiết kế web bán hàng',
                'lead' => 'Mẫu dành cho việc bán hàng trực tuyến: danh mục sản phẩm, bộ lọc theo thuộc tính, giỏ hàng và thanh toán. Dùng được cho cả cửa hàng vài chục mã và cửa hàng vài nghìn mã.',
                'sections' => [
                    ['Phù hợp với ai', [
                        'Cửa hàng đang bán trên sàn hoặc mạng xã hội và muốn có kênh riêng, không phải chia hoa hồng và không bị đổi thuật toán.',
                        'Doanh nghiệp bán buôn cần hiển thị giá khác nhau cho khách lẻ và khách đại lý.',
                        'Thương hiệu muốn kiểm soát cách sản phẩm được trình bày, thay vì theo khuôn của sàn.',
                    ]],
                    ['Những gì thường quyết định website bán hàng có chạy hay không', [
                        'Tốc độ tải trang danh mục. Khách bỏ đi trước khi thấy sản phẩm là mất tiền, và trang danh mục là trang nặng nhất. Mọi mẫu ở đây đều tải danh mục dưới ba giây trên 3G.',
                        'Bộ lọc dùng được thật. Lọc theo giá, kích cỡ, màu, thương hiệu — và giữ lại lựa chọn khi khách bấm quay lại. Nghe nhỏ nhưng đây là chỗ nhiều website tự làm khó khách.',
                        'Luồng thanh toán ngắn. Càng nhiều bước càng nhiều người rơi. Các mẫu ở đây gộp thông tin giao hàng và thanh toán vào một trang.',
                    ]],
                    $included,
                    $process,
                ],
                'faq' => [
                    ['Có nối được với vận chuyển và thanh toán không?', 'Có. Giao Hàng Nhanh, Viettel Post, VNPay và PayPal đều đã có sẵn kết nối. Cổng khác thì báo trước để chúng tôi xác nhận.'],
                    ['Đồng bộ tồn kho với phần mềm đang dùng được không?', 'Được nếu phần mềm đó có API. Đây là phần ngoài phạm vi mẫu nên sẽ báo giá riêng sau khi xem tài liệu API.'],
                    ['Bao nhiêu sản phẩm thì website bắt đầu chậm?', 'Các mẫu này chạy tốt tới khoảng năm nghìn mã trên hosting tiêu chuẩn. Nhiều hơn thì cần nâng hạ tầng, chúng tôi sẽ nói rõ trước.'],
                ],
            ],

            'website-doanh-nghiep' => [
                'meta_title' => 'Mẫu website doanh nghiệp, giới thiệu công ty | HT Việt Nam',
                'meta_description' => 'Mẫu website doanh nghiệp: giới thiệu công ty, lĩnh vực hoạt động, dự án, tuyển dụng và liên hệ. Chuẩn SEO, đa ngôn ngữ, bàn giao kèm mã nguồn.',
                'meta_keyword' => 'website doanh nghiệp, web giới thiệu công ty, thiết kế website công ty',
                'lead' => 'Mẫu dành cho website giới thiệu doanh nghiệp: hồ sơ công ty, lĩnh vực hoạt động, dự án đã làm, tuyển dụng và liên hệ. Mục tiêu là để đối tác và khách hàng tin, không phải để bán trực tiếp trên web.',
                'sections' => [
                    ['Phù hợp với ai', [
                        'Công ty đi thầu hoặc làm B2B, cần một nơi để đối tác kiểm tra năng lực trước khi làm việc.',
                        'Doanh nghiệp sản xuất muốn trình bày nhà máy, dây chuyền và chứng nhận.',
                        'Công ty tư vấn và dịch vụ chuyên môn, nơi uy tín của đội ngũ là thứ khách mua.',
                    ]],
                    ['Điều khách hàng doanh nghiệp thật sự tìm trên website của bạn', [
                        'Bằng chứng bạn đã làm việc tương tự. Trang dự án có ảnh, quy mô và thời gian thực hiện thuyết phục hơn mọi lời giới thiệu.',
                        'Thông tin pháp lý và liên hệ rõ ràng. Mã số doanh nghiệp, địa chỉ thật, số điện thoại có người nghe.',
                        'Hồ sơ năng lực tải về được. Người quyết định thường cần một tệp PDF để gửi cho cấp trên.',
                    ]],
                    $included,
                    $process,
                ],
                'faq' => [
                    ['Có làm được website hai ngôn ngữ không?', 'Có. Hệ thống hỗ trợ nhiều ngôn ngữ sẵn, bạn nhập nội dung cho từng thứ tiếng trong cùng trang quản trị.'],
                    ['Chúng tôi chưa có ảnh dự án thì sao?', 'Chúng tôi dựng trước bằng ảnh mẫu để bạn thấy bố cục, rồi thay dần khi có ảnh thật. Việc thay ảnh bạn tự làm được.'],
                    ['Website có kèm email theo tên miền không?', 'Có, năm địa chỉ email dạng ten@congty.vn trong gói hosting năm đầu.'],
                ],
            ],

            'landing-page' => [
                'meta_title' => 'Mẫu landing page bán hàng, thu khách hàng tiềm năng | HT Việt Nam',
                'meta_description' => 'Mẫu landing page một trang cho chiến dịch quảng cáo: tối ưu chuyển đổi, form đăng ký, đếm ngược và tải nhanh. Phù hợp chạy Google Ads và Facebook Ads.',
                'meta_keyword' => 'landing page, mẫu landing page, trang đích quảng cáo',
                'lead' => 'Một trang, một mục tiêu. Landing page tồn tại để khách làm đúng một việc: để lại số điện thoại, đăng ký, hoặc mua. Mọi thứ không phục vụ việc đó đều bị bỏ ra.',
                'sections' => [
                    ['Phù hợp với ai', [
                        'Đang chạy Google Ads hoặc Facebook Ads và cần trang đích riêng cho từng chiến dịch.',
                        'Ra mắt sản phẩm mới, cần thu danh sách khách quan tâm trước khi bán.',
                        'Tổ chức hội thảo, khoá học hoặc sự kiện cần trang đăng ký.',
                    ]],
                    ['Vì sao không nên dùng trang chủ làm trang đích', [
                        'Trang chủ có nhiều đường ra: menu, danh mục, bài viết. Mỗi đường ra là một cách để khách rời khỏi việc bạn muốn họ làm. Landing page cố tình không có menu.',
                        'Nội dung quảng cáo và nội dung trang đích phải khớp nhau. Khách bấm vào quảng cáo nói về một thứ mà vào trang thấy thứ khác thì thoát ngay, và chi phí quảng cáo đó mất trắng.',
                        'Đo lường dễ hơn. Một trang một mục tiêu thì tỷ lệ chuyển đổi là một con số rõ ràng, không phải suy đoán.',
                    ]],
                    $included,
                    $process,
                ],
                'faq' => [
                    ['Một chiến dịch cần mấy landing page?', 'Ít nhất một trang cho mỗi nhóm khách hàng bạn nhắm tới. Nội dung khác nhau thì trang đích nên khác nhau.'],
                    ['Gắn được mã theo dõi quảng cáo không?', 'Có. Google Analytics, Google Tag Manager và Facebook Pixel đều gắn được trong trang quản trị, không cần sửa code.'],
                    ['Khách điền form thì thông tin về đâu?', 'Lưu vào trang quản trị và đồng thời gửi thông báo về email hoặc Telegram của bạn, nên không bỏ sót khách nào.'],
                ],
            ],

            'website-bat-dong-san' => [
                'meta_title' => 'Mẫu website bất động sản, sàn giao dịch nhà đất | HT Việt Nam',
                'meta_description' => 'Mẫu website bất động sản: đăng tin nhà đất, bộ lọc theo khu vực và khoảng giá, bản đồ dự án, mặt bằng từng căn. Chuẩn SEO local, bàn giao 5–7 ngày.',
                'meta_keyword' => 'website bất động sản, web nhà đất, sàn giao dịch bất động sản',
                'lead' => 'Mẫu cho môi giới và chủ đầu tư: danh sách bất động sản, bộ lọc theo khu vực, diện tích và khoảng giá, bản đồ dự án và mặt bằng từng căn.',
                'sections' => [
                    ['Phù hợp với ai', [
                        'Sàn giao dịch có nhiều tin đăng, cần bộ lọc và tìm kiếm để khách không phải cuộn hết trang.',
                        'Chủ đầu tư một dự án, cần trang riêng cho dự án đó với mặt bằng, tiến độ và bảng giá theo đợt.',
                        'Môi giới cá nhân muốn tin đăng của mình xuất hiện trên Google thay vì chỉ nằm trong nhóm Facebook.',
                    ]],
                    ['Điều khiến website bất động sản ra khách', [
                        'Bộ lọc theo khu vực phải đúng cách người Việt tìm nhà: theo quận, theo phường, theo trục đường. Lọc theo bán kính km nghe hiện đại nhưng ít ai dùng.',
                        'Ảnh lớn và nhiều. Khách xem nhà bằng mắt trước khi gọi. Mẫu ở đây để ảnh chiếm phần lớn diện tích thẻ tin đăng.',
                        'Số điện thoại luôn trong tầm mắt. Khách quyết định gọi trong lúc đang xem ảnh, không phải sau khi cuộn xuống cuối trang.',
                    ]],
                    $included,
                    $process,
                ],
                'faq' => [
                    ['Nhiều môi giới cùng đăng tin được không?', 'Được. Mỗi người một tài khoản, tin đăng gắn với người đăng, và quản trị viên duyệt trước khi hiển thị.'],
                    ['Có gắn bản đồ vị trí không?', 'Có, dùng Google Maps. Bạn nhập địa chỉ hoặc kéo ghim trong trang quản trị.'],
                    ['Tin đăng hết hạn thì xử lý thế nào?', 'Bạn đặt thời hạn cho từng tin. Hết hạn tin tự ẩn khỏi danh sách nhưng vẫn còn trong quản trị để đăng lại.'],
                ],
            ],

            'giao-duc' => [
                'meta_title' => 'Mẫu website giáo dục, trung tâm đào tạo, khoá học online | HT Việt Nam',
                'meta_description' => 'Mẫu website cho trường học, trung tâm đào tạo và khoá học trực tuyến: lịch khai giảng, hồ sơ giảng viên, đăng ký học thử và thanh toán học phí.',
                'meta_keyword' => 'website giáo dục, web trung tâm đào tạo, website khoá học online',
                'lead' => 'Mẫu cho trường học, trung tâm đào tạo và khoá học trực tuyến: chương trình học, lịch khai giảng, hồ sơ giảng viên và biểu mẫu đăng ký.',
                'sections' => [
                    ['Phù hợp với ai', [
                        'Trung tâm ngoại ngữ, tin học, kỹ năng — nơi phụ huynh và học viên cần thấy lịch học và học phí trước khi gọi.',
                        'Trường mầm non và phổ thông, cần trang thông báo, thực đơn và hoạt động hằng tuần.',
                        'Người bán khoá học trực tuyến, cần trang chương trình từng bài và thanh toán.',
                    ]],
                    ['Điều phụ huynh và học viên tìm đầu tiên', [
                        'Học phí. Website không ghi giá làm người ta nghi ngờ và đi tìm chỗ khác. Nếu học phí phụ thuộc trình độ thì ghi khoảng giá, đừng để trống.',
                        'Lịch khai giảng và thời khoá biểu. Người đi làm cần biết có lớp buổi tối hay cuối tuần trước khi quan tâm đến bất cứ điều gì khác.',
                        'Giảng viên là ai. Ảnh thật, kinh nghiệm thật. Đây là thứ phân biệt trung tâm với nhau rõ nhất.',
                    ]],
                    $included,
                    $process,
                ],
                'faq' => [
                    ['Có thu học phí trực tuyến được không?', 'Được. Kết nối VNPay hoặc chuyển khoản có đối chiếu tự động, tuỳ cách bạn muốn quản lý.'],
                    ['Học viên xem được tiến độ học của mình chứ?', 'Với mẫu khoá học trực tuyến thì có: mỗi học viên một tài khoản, xem bài đã học và bài còn lại.'],
                    ['Đăng ký học thử thì thông tin về đâu?', 'Vào trang quản trị và gửi thông báo ngay cho bộ phận tuyển sinh, kèm khoá học mà người đó quan tâm.'],
                ],
            ],

            'mau-quan-tri-bang-dieu-khien' => [
                'meta_title' => 'Mẫu admin dashboard, giao diện quản trị hệ thống | HT Việt Nam',
                'meta_description' => 'Mẫu giao diện quản trị và bảng điều khiển: biểu đồ, bảng dữ liệu, phân quyền và báo cáo. Dùng cho phần mềm nội bộ, CRM và hệ thống quản lý.',
                'meta_keyword' => 'admin dashboard, mẫu giao diện quản trị, template admin, bảng điều khiển',
                'lead' => 'Mẫu giao diện cho phần bên trong hệ thống: bảng điều khiển, biểu đồ, bảng dữ liệu, phân quyền và báo cáo. Đây là phần người dùng nội bộ nhìn mỗi ngày, không phải phần khách hàng nhìn.',
                'sections' => [
                    ['Phù hợp với ai', [
                        'Đội phát triển cần giao diện sẵn cho phần mềm nội bộ, để tập trung vào nghiệp vụ thay vì dựng lại bảng và biểu đồ.',
                        'Doanh nghiệp làm CRM hoặc hệ thống quản lý riêng, muốn phần quản trị trông chuyên nghiệp ngay từ bản đầu.',
                        'Đơn vị nhận gia công phần mềm, cần bộ giao diện dùng lại được cho nhiều dự án.',
                    ]],
                    ['Điều tạo khác biệt giữa một dashboard dùng được và một dashboard đẹp', [
                        'Bảng dữ liệu chịu được nhiều dòng. Sắp xếp, lọc, phân trang và cố định cột đầu — thiếu những thứ này thì bảng chỉ đẹp khi có mười dòng.',
                        'Biểu đồ nói được một điều. Ba biểu đồ trả lời ba câu hỏi cụ thể có ích hơn mười hai biểu đồ trang trí.',
                        'Trạng thái rỗng và trạng thái lỗi được thiết kế. Người dùng nội bộ gặp hai trạng thái này thường xuyên hơn bạn nghĩ.',
                    ]],
                    $included,
                    $process,
                ],
                'faq' => [
                    ['Mẫu này có kèm phần backend không?', 'Không. Đây là giao diện. Nếu bạn cần cả phần xử lý nghiệp vụ thì đó là thiết kế theo yêu cầu, chúng tôi báo giá riêng.'],
                    ['Dùng được với framework nào?', 'Các mẫu ở đây là HTML, CSS và JavaScript nên ghép được vào Laravel, .NET, Node hay React. Chúng tôi ghi rõ công nghệ trong từng mẫu.'],
                    ['Có tối tuỳ chỉnh màu theo thương hiệu không?', 'Có. Màu và font khai báo bằng biến CSS, đổi ở một chỗ là toàn hệ thống theo.'],
                ],
            ],
        ];
    }
}
