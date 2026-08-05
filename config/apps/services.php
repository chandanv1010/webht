<?php

/*
|--------------------------------------------------------------------------
| Service landing pages
|--------------------------------------------------------------------------
|
| One entry per service. Each renders through frontend.homepage.home.service,
| which follows the layout the hosting page established: hero, three promises,
| a "why us" block, the offer as cards, then feedback and a way to get in touch.
|
| The copy lives here rather than in four near-identical Blade files so it can be
| edited in one place — and so a new service is a new array, not a new template.
|
| Keys per service:
|   canonical, meta_*        the route it answers on and its SEO
|   hero                     eyebrow / title / lead / illustration name
|   promises[]               three cards: icon image, title, text
|   why                      illustration + heading + lead + numbered points
|   offer                    label + heading + three cards of rows
|   note                     the honest caveat under the offer
|   steps[]                  optional: shown when the service has a real sequence
|
*/

return [

    /*
    |----------------------------------------------------------------------
    | Thiết kế website theo yêu cầu
    |----------------------------------------------------------------------
    */
    'custom' => [
        'canonical' => 'thiet-ke-theo-yeu-cau',
        'meta_title' => 'Thiết kế website theo yêu cầu — quy trình, thời gian, chi phí | HT Việt Nam',
        'meta_keyword' => 'thiết kế website theo yêu cầu, thiết kế web riêng, HTVIETNAM',
        'meta_description' => 'Website vẽ mới từ đầu theo đúng quy trình bán hàng của bạn: khảo sát nghiệp vụ, wireframe, giao diện, lập trình, bàn giao mã nguồn. 25–90 triệu, 4–10 tuần.',

        'hero' => [
            'eyebrow' => 'Dịch vụ',
            'title' => 'Website <strong>theo <em>đúng</em> cách bạn bán hàng</strong>',
            'lead' => 'Chúng tôi vẽ mới từ đầu theo quy trình thật của bạn, không cắt bớt nghiệp vụ để vừa một mẫu có sẵn. Bàn giao toàn bộ mã nguồn và cơ sở dữ liệu.',
            'illustration' => 'build',
            'primary' => ['label' => 'Nhận tư vấn miễn phí', 'action' => 'popup'],
            'secondary' => ['label' => 'Xem kho giao diện', 'url' => 'kho-giao-dien'],
        ],

        'promises' => [
            [
                'icon' => 'frontend/resources/img/icon-img-01.png',
                'title' => 'Đúng nghiệp vụ của bạn',
                'text' => 'Chúng tôi ngồi với người đang làm công việc đó, không chỉ với người quyết định. Từng chức năng, từng vai trò, từng trường dữ liệu đều được ghi vào tài liệu phạm vi trước khi lập trình.',
            ],
            [
                'icon' => 'frontend/resources/img/icon-img-02.png',
                'title' => 'Mã nguồn thuộc về bạn',
                'text' => 'Bàn giao đầy đủ mã nguồn, cơ sở dữ liệu và hướng dẫn cài đặt lên máy chủ khác. Tài khoản quản trị cấp cao nhất là của bạn, không phải của chúng tôi.',
            ],
            [
                'icon' => 'frontend/resources/img/icon-img-03.png',
                'title' => 'Bảo hành 12 tháng',
                'text' => 'Lỗi kỹ thuật được sửa không giới hạn số lần trong 12 tháng. Sau đó bạn tự vận hành, thuê người khác, hoặc dùng gói chăm sóc — chúng tôi không giữ khoá nào.',
            ],
        ],

        'why' => [
            'illustration' => 'process',
            'label' => 'Khi nào nên chọn thiết kế riêng',
            'heading' => 'Mẫu có sẵn tốt, cho đến khi <br> quy trình của bạn khác người',
            'lead' => 'Nếu không có điểm nào dưới đây, chúng tôi sẽ nói thẳng là bạn nên chọn mẫu có sẵn và giữ phần ngân sách chênh lệch cho quảng cáo.',
            'points' => [
                'Đơn hàng đi qua nhiều bước xét duyệt, mỗi bước một người thấy một phần dữ liệu khác nhau.',
                'Giá tính theo nhóm khách, theo hợp đồng, theo bậc số lượng, hoặc theo công thức riêng của ngành.',
                'Website phải nối với phần mềm bạn đang dùng: kế toán, kho, CRM, tổng đài, hoặc API nội bộ.',
            ],
        ],

        'steps' => [
            'label' => 'Quy trình',
            'heading' => 'Năm bước, mỗi bước có thứ bạn xem được',
            'lead' => 'Không bước nào kết thúc bằng một lời hứa.',
            'items' => [
                ['when' => '3–5 ngày', 'title' => 'Khảo sát nghiệp vụ', 'text' => 'Kết quả là tài liệu phạm vi liệt kê từng chức năng và từng vai trò.'],
                ['when' => '5–7 ngày', 'title' => 'Wireframe', 'text' => 'Bố cục bằng khối xám, chưa có màu. Giai đoạn này sửa rẻ nhất nên sửa đến khi bạn duyệt.'],
                ['when' => '7–14 ngày', 'title' => 'Giao diện', 'text' => 'Thiết kế trên wireframe đã duyệt, đủ desktop và điện thoại. Bạn nhận file thiết kế.'],
                ['when' => '3–6 tuần', 'title' => 'Lập trình', 'text' => 'Có địa chỉ thử nghiệm ngay tuần đầu, xem tiến độ mỗi tuần.'],
                ['when' => '3–5 ngày', 'title' => 'Nghiệm thu', 'text' => 'Chạy hết các luồng đã ký, đào tạo trực tiếp, bàn giao mã nguồn.'],
            ],
        ],

        'offer' => [
            'label' => 'Chi phí',
            'heading' => 'Tính theo số luồng nghiệp vụ, không theo số trang',
            'cards' => [
                [
                    'name' => 'Một luồng',
                    'price' => '25–40 triệu',
                    'per' => '4–6 tuần',
                    'rows' => [
                        ['Luồng nghiệp vụ chính', '01'],
                        ['Trang quản trị tương ứng', 'Có'],
                        ['Vai trò người dùng', '2'],
                        ['Báo cáo', 'Cơ bản'],
                        ['Tích hợp bên thứ ba', '—'],
                        ['Bàn giao mã nguồn', 'Có'],
                    ],
                    'rating' => 3,
                ],
                [
                    'name' => 'Nhiều luồng',
                    'price' => '40–70 triệu',
                    'per' => '6–8 tuần',
                    'featured' => true,
                    'rows' => [
                        ['Luồng nghiệp vụ chính', '02–04'],
                        ['Trang quản trị tương ứng', 'Có'],
                        ['Vai trò người dùng', 'Không giới hạn'],
                        ['Báo cáo', 'Theo yêu cầu'],
                        ['Tích hợp bên thứ ba', '01'],
                        ['Bàn giao mã nguồn', 'Có'],
                    ],
                    'rating' => 4,
                ],
                [
                    'name' => 'Hệ thống',
                    'price' => 'Từ 70 triệu',
                    'per' => '8–10 tuần',
                    'rows' => [
                        ['Luồng nghiệp vụ chính', 'Không giới hạn'],
                        ['Trang quản trị tương ứng', 'Có'],
                        ['Vai trò người dùng', 'Không giới hạn'],
                        ['Báo cáo', 'Theo yêu cầu'],
                        ['Tích hợp bên thứ ba', 'Đồng bộ hai chiều'],
                        ['Bàn giao mã nguồn', 'Có'],
                    ],
                    'rating' => 5,
                ],
            ],
        ],

        'note' => 'Thanh toán theo bốn mốc: 30% khi ký, 30% khi duyệt giao diện, 30% khi nghiệm thu, 10% sau 15 ngày chạy thật. Thay đổi trong phạm vi đã ký thì miễn phí; thêm luồng mới thì báo giá trước khi làm.',
    ],

    /*
    |----------------------------------------------------------------------
    | Website mẫu có sẵn
    |----------------------------------------------------------------------
    */
    'template' => [
        'canonical' => 'thiet-ke-website-theo-mau-co-san',
        'meta_title' => 'Thiết kế website theo mẫu có sẵn — bàn giao 5–7 ngày | HT Việt Nam',
        'meta_keyword' => 'website mẫu có sẵn, thiết kế website nhanh, HTVIETNAM',
        'meta_description' => 'Chọn một mẫu trong kho giao diện, đổi logo, màu và nội dung, nhận website chạy thật sau 5–7 ngày. Từ 4,5 triệu, gồm hosting và tên miền năm đầu.',

        'hero' => [
            'eyebrow' => 'Dịch vụ',
            'title' => 'Chọn mẫu hôm nay, <strong>chạy thật <em>tuần</em> sau</strong>',
            'lead' => 'Mỗi mẫu trong kho là một website đã lập trình xong. Việc còn lại là mặc thương hiệu của bạn vào và đưa nội dung lên.',
            'illustration' => 'welcome',
            'primary' => ['label' => 'Chọn mẫu ngay', 'url' => 'kho-giao-dien'],
            'secondary' => ['label' => 'Nhận tư vấn chọn mẫu', 'action' => 'popup'],
        ],

        'promises' => [
            [
                'icon' => 'frontend/resources/img/icon-img-01.png',
                'title' => 'Bàn giao trong 5–7 ngày',
                'text' => 'Mốc hay trễ nhất là ngày đầu, khi nội dung chưa sẵn. Bạn gửi đủ ngay từ đầu thì phần còn lại gần như luôn đúng hạn.',
            ],
            [
                'icon' => 'frontend/resources/img/icon-img-02.png',
                'title' => 'Không dùng chung với ai',
                'text' => 'Mỗi lần triển khai là một bản cài đặt riêng, cơ sở dữ liệu riêng, tên miền riêng. Mẫu chỉ là điểm bắt đầu.',
            ],
            [
                'icon' => 'frontend/resources/img/icon-img-03.png',
                'title' => 'Đã gồm hosting năm đầu',
                'text' => 'Hosting, tên miền .com hoặc .vn, chứng chỉ SSL và 3 tháng sửa nội dung không giới hạn đều nằm trong giá.',
            ],
        ],

        'why' => [
            'illustration' => 'speed',
            'label' => 'Chúng tôi thay những gì',
            'heading' => 'Mặc thương hiệu của bạn <br> lên một bộ khung đã chạy tốt',
            'lead' => 'Việc không nằm trong gói: đổi bố cục sang thiết kế khác, thêm luồng nghiệp vụ mới, hoặc nối với phần mềm bên ngoài. Những việc đó thuộc phần thiết kế theo yêu cầu.',
            'points' => [
                'Logo, bộ màu, phông chữ, toàn bộ nội dung và hình ảnh theo nhận diện của bạn.',
                'Cấu trúc menu và danh mục theo đúng ngành, không giữ menu mẫu.',
                'Gắn Google Analytics, Search Console, Facebook Pixel nếu bạn cần.',
            ],
        ],

        'offer' => [
            'label' => 'Bảng giá',
            'heading' => 'Ba mức, khác nhau ở phần bán hàng',
            'cards' => [
                [
                    'name' => 'Giới thiệu',
                    'price' => '4.500.000đ',
                    'per' => 'một lần',
                    'rows' => [
                        ['Số trang nội dung', 'Tối đa 8'],
                        ['Giỏ hàng & quản lý đơn', '—'],
                        ['Quản lý tồn kho', '—'],
                        ['Cổng thanh toán', '—'],
                        ['Hosting + tên miền năm đầu', 'Có'],
                        ['Hỗ trợ sửa nội dung', '3 tháng'],
                    ],
                    'rating' => 3,
                ],
                [
                    'name' => 'Bán hàng',
                    'price' => '7.500.000đ',
                    'per' => 'một lần',
                    'featured' => true,
                    'rows' => [
                        ['Số trang nội dung', 'Không giới hạn'],
                        ['Giỏ hàng & quản lý đơn', 'Có'],
                        ['Quản lý tồn kho', 'Cơ bản'],
                        ['Cổng thanh toán', '—'],
                        ['Hosting + tên miền năm đầu', 'Có'],
                        ['Hỗ trợ sửa nội dung', '3 tháng'],
                    ],
                    'rating' => 4,
                ],
                [
                    'name' => 'Bán hàng nâng cao',
                    'price' => '12.000.000đ',
                    'per' => 'một lần',
                    'rows' => [
                        ['Số trang nội dung', 'Không giới hạn'],
                        ['Giỏ hàng & quản lý đơn', 'Có'],
                        ['Quản lý tồn kho', 'Nhiều thuộc tính'],
                        ['Cổng thanh toán', 'Có'],
                        ['Hosting + tên miền năm đầu', 'Có'],
                        ['Hỗ trợ sửa nội dung', '3 tháng'],
                    ],
                    'rating' => 5,
                ],
            ],
        ],

        'note' => 'Từ năm thứ hai, phí duy trì hosting và tên miền tính theo bảng giá công khai. Viết nội dung ngoài phạm vi: 350 nghìn cho mỗi bài 800 từ.',
    ],

    /*
    |----------------------------------------------------------------------
    | Chăm sóc website
    |----------------------------------------------------------------------
    */
    'care' => [
        'canonical' => 'cham-soc-website',
        'meta_title' => 'Chăm sóc website hằng tháng — cập nhật, sao lưu, bảo mật | HT Việt Nam',
        'meta_keyword' => 'chăm sóc website, bảo trì website, HTVIETNAM',
        'meta_description' => 'Cập nhật bản vá, sao lưu hằng ngày, theo dõi uptime, xử lý sự cố, sửa nội dung theo yêu cầu. Từ 600 nghìn/tháng, không ràng buộc thời hạn.',

        'hero' => [
            'eyebrow' => 'Dịch vụ',
            'title' => 'Website không tự hỏng, <strong>nhưng nó tự <em>cũ</em></strong>',
            'lead' => 'Giữ cho bản vá được cập nhật, dữ liệu được sao lưu, và có người nhấc máy khi trang không truy cập được.',
            'illustration' => 'support',
            'primary' => ['label' => 'Nhận báo giá gói phù hợp', 'action' => 'popup'],
            'secondary' => ['label' => 'Xem bảng giá', 'url' => 'bang-gia'],
        ],

        'promises' => [
            [
                'icon' => 'frontend/resources/img/icon-img-01.png',
                'title' => 'Sao lưu mỗi ngày',
                'text' => 'Giữ 30 bản gần nhất. Khi có sự cố dữ liệu, chúng tôi phục hồi từ bản gần nhất trước, rồi mới đi tìm nguyên nhân.',
            ],
            [
                'icon' => 'frontend/resources/img/icon-img-02.png',
                'title' => 'Theo dõi 5 phút một lần',
                'text' => 'Hệ thống phát hiện trang không phản hồi và gửi cảnh báo trước khi bạn kịp nhận ra. Gói ưu tiên thì chúng tôi xử lý ngay không chờ bạn gọi.',
            ],
            [
                'icon' => 'frontend/resources/img/icon-img-03.png',
                'title' => 'Dừng lúc nào cũng được',
                'text' => 'Không phí khởi tạo, không cam kết thời hạn tối thiểu. Báo trước 15 ngày là dừng, và nhận lại toàn bộ tài khoản kèm bản sao lưu mới nhất.',
            ],
        ],

        'why' => [
            'illustration' => 'company',
            'label' => 'Vì sao trang đang chạy tốt vẫn cần chăm sóc',
            'heading' => 'Phần lớn sự cố không đến từ <br> lỗi lập trình',
            'lead' => 'Nó đến từ những thứ đứng im trong khi thế giới bên ngoài thay đổi.',
            'points' => [
                'Bản vá bảo mật không cập nhật, đến một ngày bị quét và bị chèn mã.',
                'SSL hoặc tên miền hết hạn vì email nhắc gửi vào hộp thư của nhân sự đã nghỉ.',
                'Ảnh tải lên không nén, sau hai năm trang chủ nặng 12MB và mất 9 giây để mở.',
            ],
        ],

        'offer' => [
            'label' => 'Ba gói',
            'heading' => 'Khác nhau ở giờ công và thời gian phản hồi',
            'cards' => [
                [
                    'name' => 'Cơ bản',
                    'price' => '600.000đ',
                    'per' => '/ tháng',
                    'rows' => [
                        ['Sao lưu hằng ngày', '30 bản'],
                        ['Cập nhật bản vá', 'Có'],
                        ['Theo dõi uptime', '5 phút'],
                        ['Giờ công mỗi tháng', '—'],
                        ['Quét mã độc', '—'],
                        ['Phản hồi sự cố', 'Trong giờ hành chính'],
                    ],
                    'rating' => 3,
                ],
                [
                    'name' => 'Tiêu chuẩn',
                    'price' => '1.500.000đ',
                    'per' => '/ tháng',
                    'featured' => true,
                    'rows' => [
                        ['Sao lưu hằng ngày', '30 bản'],
                        ['Cập nhật bản vá', 'Có'],
                        ['Theo dõi uptime', '5 phút'],
                        ['Giờ công mỗi tháng', '4 giờ'],
                        ['Quét mã độc', 'Hằng tuần'],
                        ['Phản hồi sự cố', 'Trong giờ hành chính'],
                    ],
                    'rating' => 4,
                ],
                [
                    'name' => 'Ưu tiên',
                    'price' => '3.500.000đ',
                    'per' => '/ tháng',
                    'rows' => [
                        ['Sao lưu hằng ngày', '30 bản'],
                        ['Cập nhật bản vá', 'Có'],
                        ['Theo dõi uptime', '5 phút'],
                        ['Giờ công mỗi tháng', '12 giờ'],
                        ['Quét mã độc', 'Hằng tuần'],
                        ['Phản hồi sự cố', 'Trong 2 giờ, kể cả ngoài giờ'],
                    ],
                    'rating' => 5,
                ],
            ],
        ],

        'note' => 'Giờ công không dùng hết không cộng dồn sang tháng sau — chúng tôi nói trước vì đây là câu hỏi thứ hai của gần như mọi khách hàng. Đóng theo năm được giảm 10%.',
    ],

    /*
    |----------------------------------------------------------------------
    | Dịch vụ SEO
    |----------------------------------------------------------------------
    */
    'seo' => [
        'canonical' => 'dich-vu-seo',
        'meta_title' => 'Dịch vụ SEO cho website doanh nghiệp — làm gì và không hứa gì | HT Việt Nam',
        'meta_keyword' => 'dịch vụ SEO, SEO website, HTVIETNAM',
        'meta_description' => 'SEO kỹ thuật, nội dung và đo lường cho website doanh nghiệp. Báo cáo theo lưu lượng và số liên hệ thực, không theo thứ hạng từ khoá lẻ. Từ 6 triệu/tháng.',

        'hero' => [
            'eyebrow' => 'Dịch vụ',
            'title' => 'Được tìm thấy bởi <strong>người <em>đang</em> cần</strong>',
            'lead' => 'Chúng tôi báo cáo theo lưu lượng và số liên hệ thực, không theo thứ hạng của một từ khoá lẻ mà không ai tìm.',
            'illustration' => 'speed',
            'primary' => ['label' => 'Nhận audit miễn phí', 'action' => 'popup'],
            'secondary' => ['label' => 'Đọc bài về SEO', 'url' => 'tin-cong-nghe'],
        ],

        'promises' => [
            [
                'icon' => 'frontend/resources/img/icon-img-01.png',
                'title' => 'Không hứa top 1 trong 30 ngày',
                'text' => 'Ai cam kết điều đó đang bán cho bạn một trong hai thứ: từ khoá không có người tìm, hoặc một cách làm sẽ khiến website bị phạt về sau.',
            ],
            [
                'icon' => 'frontend/resources/img/icon-img-02.png',
                'title' => 'Cam kết phần trong tầm tay',
                'text' => 'Khối lượng công việc mỗi tháng, chất lượng kỹ thuật, và một báo cáo trung thực kể cả khi số liệu đi xuống.',
            ],
            [
                'icon' => 'frontend/resources/img/icon-img-03.png',
                'title' => 'Quyết định bằng dữ liệu',
                'text' => 'Đọc Search Console mỗi tuần và chọn việc tháng sau dựa trên số liệu, không dựa trên cảm giác.',
            ],
        ],

        'why' => [
            'illustration' => 'process',
            'label' => 'Ba việc thực sự làm mỗi tháng',
            'heading' => 'Kỹ thuật, nội dung <br> và đo lường',
            'lead' => 'Mốc hợp lý để đánh giá: tháng 1–2 gần như không thấy gì, tháng 3–4 tăng lượt hiển thị, tháng 5–6 mới thấy lưu lượng và liên hệ tăng rõ.',
            'points' => [
                'Kỹ thuật: tốc độ tải, Core Web Vitals, dữ liệu có cấu trúc, sitemap, canonical, trang trùng nội dung.',
                'Nội dung: nghiên cứu từ khoá theo ý định tìm kiếm, dựng cấu trúc chủ đề, tối ưu trang danh mục đang có.',
                'Đo lường: cấu hình theo dõi chuyển đổi để biết bài nào ra khách, không chỉ bài nào ra lượt xem.',
            ],
        ],

        'offer' => [
            'label' => 'Chi phí',
            'heading' => 'Theo khối lượng nội dung mỗi tháng',
            'cards' => [
                [
                    'name' => 'Nền tảng',
                    'price' => '6.000.000đ',
                    'per' => '/ tháng',
                    'rows' => [
                        ['SEO kỹ thuật', 'Có'],
                        ['Bài mới mỗi tháng', '4'],
                        ['Tối ưu trang đang có', 'Có'],
                        ['Nghiên cứu chủ đề theo cụm', '—'],
                        ['Xây dựng liên kết', '—'],
                        ['Báo cáo', 'Hằng tháng'],
                    ],
                    'rating' => 3,
                ],
                [
                    'name' => 'Tăng trưởng',
                    'price' => '12.000.000đ',
                    'per' => '/ tháng',
                    'featured' => true,
                    'rows' => [
                        ['SEO kỹ thuật', 'Có'],
                        ['Bài mới mỗi tháng', '8'],
                        ['Tối ưu trang đang có', 'Có'],
                        ['Nghiên cứu chủ đề theo cụm', 'Có'],
                        ['Xây dựng liên kết', '—'],
                        ['Báo cáo', 'Hai tuần một lần'],
                    ],
                    'rating' => 4,
                ],
                [
                    'name' => 'Cạnh tranh cao',
                    'price' => 'Từ 20 triệu',
                    'per' => '/ tháng',
                    'rows' => [
                        ['SEO kỹ thuật', 'Có'],
                        ['Bài mới mỗi tháng', '12+'],
                        ['Tối ưu trang đang có', 'Có'],
                        ['Nghiên cứu chủ đề theo cụm', 'Có'],
                        ['Xây dựng liên kết', 'Có'],
                        ['Báo cáo', 'Hằng tuần'],
                    ],
                    'rating' => 5,
                ],
            ],
        ],

        'note' => 'Nếu bạn cần khách trong 30 ngày thì nên chạy quảng cáo song song — chúng tôi nói vậy ngay từ buổi đầu chứ không để bạn chờ ba tháng mới biết.',
    ],
];
