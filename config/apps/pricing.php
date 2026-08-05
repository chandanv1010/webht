<?php

/*
|--------------------------------------------------------------------------
| Bảng giá
|--------------------------------------------------------------------------
|
| The three packages on /bang-gia.html.
|
| `was` is the list price shown struck through. It is a claim about your own pricing
| history, so leave it null unless the discount is real — an invented "was" price is a
| false advertisement, not a design element.
|
| `features` are ticked; `missing` are shown greyed with a dash, because what a package
| does *not* include is the thing buyers most often find out too late.
|
*/

return [

    'lead' => [
        'eyebrow' => 'Bảng giá',
        'title' => 'Giải pháp tối ưu, chi phí rõ ràng',
        'text' => 'Ba mức, chia theo phạm vi giao diện và phần dịch vụ đi kèm. Giá dưới đây là giá trọn gói cho một website — không có khoản nào phát sinh sau khi ký mà bạn chưa được nói trước.',
    ],

    'packages' => [
        [
            'key' => 'start',
            'name' => 'Khởi đầu',
            'price' => '4.500.000đ',
            'was' => null,
            'scope' => 'Giao diện tới 2 triệu trong kho, kèm dịch vụ triển khai',
            'note' => 'Cho cá nhân và đơn vị mới thành lập',
            'features' => [
                'Bàn giao mã nguồn đầy đủ',
                'Dữ liệu mẫu để xem website hoàn chỉnh',
                'Triển khai và trỏ tên miền',
                'Gắn Google Analytics',
                'Tài liệu hướng dẫn quản trị',
                'Bảo hành 3 tháng',
            ],
            'missing' => [
                'Đăng ký tên miền năm đầu',
                'Google Tag Manager',
                'Bài viết chuẩn SEO',
                'Ưu tiên xử lý yêu cầu',
            ],
        ],
        [
            'key' => 'pro',
            'name' => 'Chuyên nghiệp',
            'price' => '7.500.000đ',
            'was' => null,
            'featured' => true,
            'scope' => 'Giao diện tới 3,5 triệu trong kho, kèm dịch vụ toàn diện',
            'note' => 'Hay được chọn nhất',
            'features' => [
                'Toàn bộ quyền lợi gói Khởi đầu',
                'Đăng ký tên miền năm đầu',
                'Google Tag Manager',
                'Bảo hành 12 tháng',
                '3 bài viết chuẩn SEO',
                'Ưu tiên xử lý yêu cầu',
            ],
            'missing' => [
                'Tuỳ biến theo nhận diện thương hiệu',
                'Tối ưu SEO toàn diện',
            ],
        ],
        [
            'key' => 'premium',
            'name' => 'Cao cấp',
            'price' => '11.900.000đ',
            'was' => null,
            'scope' => 'Tuỳ biến giao diện không giới hạn theo nhận diện thương hiệu',
            'note' => 'Cho thương hiệu đã có bộ nhận diện',
            'features' => [
                'Toàn bộ quyền lợi gói Chuyên nghiệp',
                'Tuỳ biến theo nhận diện thương hiệu',
                'Tối ưu SEO toàn diện',
                'Biên tập nội dung theo giọng thương hiệu',
                'Hỗ trợ ưu tiên mức 3',
                'Bảo hành 12 tháng',
            ],
            'missing' => [],
        ],
    ],

    /* What is not in any package. Said here rather than discovered later. */
    'extras' => [
        ['Viết nội dung ngoài phạm vi', '350.000đ / bài 800 từ'],
        ['Chụp ảnh sản phẩm', 'Báo giá theo số lượng, tối thiểu 30 ảnh'],
        ['Tên miền từ năm thứ hai', 'Theo giá nhà đăng ký công bố'],
        ['Thêm luồng nghiệp vụ mới', 'Báo giá trước khi làm'],
    ],

    'faqs' => [
        ['Giá trên đã gồm hosting chưa?', 'Đã gồm hosting năm đầu ở cả ba gói. Từ năm thứ hai tính theo bảng giá hosting công khai, từ 55 nghìn/tháng.'],
        ['Thanh toán chia mấy đợt?', 'Hai đợt: 50% khi xác nhận đơn, 50% khi nghiệm thu. Có hoá đơn VAT cho từng đợt.'],
        ['Tôi có nhận được mã nguồn không?', 'Có, ở cả ba gói. Toàn bộ mã nguồn và cơ sở dữ liệu, không mã hoá, không giới hạn số lần cài lại.'],
        ['Nếu tôi cần một chức năng không có trong mẫu?', 'Nếu là chỉnh nhỏ thì làm trong gói. Nếu là luồng nghiệp vụ mới thì thuộc phần thiết kế theo yêu cầu, và chúng tôi báo giá trước khi làm.'],
        ['Bảo hành gồm những gì?', 'Lỗi kỹ thuật phát sinh từ mã nguồn chúng tôi bàn giao, không giới hạn số lần trong thời hạn bảo hành. Không áp dụng cho lỗi do bên thứ ba can thiệp mã nguồn.'],
    ],
];
