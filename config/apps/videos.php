<?php

/*
|--------------------------------------------------------------------------
| Video library
|--------------------------------------------------------------------------
|
| The video page's list. Each entry is a YouTube id, a title and which shelf it
| belongs on. The featured player at the top uses the "Video youtube(pc)" setting
| from the admin, so the client changes that without touching this file.
|
| Kept here rather than in the database because there is no admin screen for a video
| list yet, and a config file is honest about that: it is one commit to change, and it
| does not pretend to be editable content.
|
| The ids below are placeholders using the channel already configured on the site —
| replace them with the real uploads.
|
*/

return [

    'shelves' => [
        [
            'name' => 'Giới thiệu',
            'note' => 'Bắt đầu từ đây nếu bạn chưa biết chúng tôi làm gì',
            'items' => [
                ['id' => '3z0t0zIluRI', 'title' => 'HT Việt Nam làm website như thế nào', 'length' => '4:12'],
                ['id' => '3z0t0zIluRI', 'title' => 'Một dự án đi qua những bước nào', 'length' => '6:38'],
                ['id' => '3z0t0zIluRI', 'title' => 'Vì sao chúng tôi bàn giao cả mã nguồn', 'length' => '3:05'],
            ],
        ],
        [
            'name' => 'Hướng dẫn quản trị',
            'note' => 'Quay lại đúng màn hình bạn đang dùng',
            'items' => [
                ['id' => '3z0t0zIluRI', 'title' => 'Đăng bài viết và chèn ảnh', 'length' => '5:20'],
                ['id' => '3z0t0zIluRI', 'title' => 'Thêm sản phẩm và nhóm sản phẩm', 'length' => '7:44'],
                ['id' => '3z0t0zIluRI', 'title' => 'Sửa menu, banner và thông tin liên hệ', 'length' => '4:58'],
                ['id' => '3z0t0zIluRI', 'title' => 'Xem và xử lý liên hệ của khách', 'length' => '2:47'],
            ],
        ],
        [
            'name' => 'Kiến thức website',
            'note' => 'Những câu hỏi khách hay hỏi nhất, trả lời bằng video',
            'items' => [
                ['id' => '3z0t0zIluRI', 'title' => 'Website chậm: kiểm tra gì trước', 'length' => '8:15'],
                ['id' => '3z0t0zIluRI', 'title' => 'Tên miền của bạn đang đứng tên ai', 'length' => '3:32'],
                ['id' => '3z0t0zIluRI', 'title' => 'SSL và những hiểu nhầm thường gặp', 'length' => '5:01'],
            ],
        ],
    ],
];
