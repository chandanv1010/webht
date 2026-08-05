@extends('frontend.homepage.layout')

@section('content')
{{--
    Dịch vụ SEO.

    Every SEO page on the internet promises a ranking, so this one opens by refusing to.
    The hero is the refusal; the section under it is a month-by-month chart of what to
    expect instead, because managing that expectation is the whole job. Then the three
    workstreams as columns, and prices as a plain list.

    No feature matrix, no gallery. Those belong to services you compare on specifics.
--}}
@php $hero = $service['hero']; $offer = $service['offer']; @endphp

<div class="svc svc--seo">

    {{-- ── Hero: the thing we will not promise ───────────────────── --}}
    <section class="svc-hero svc-hero--seo">
        <div class="uk-container uk-container-center">
            <div class="svc-hero__center">
                <p class="svc-eyebrow">{{ $hero['eyebrow'] }}</p>
                <h1 class="svc-title">{!! $hero['title'] !!}</h1>

                <div class="svc-vow">
                    <p class="svc-vow__no">Chúng tôi không hứa top 1 trong 30 ngày.</p>
                    <p class="svc-vow__why">Không ai kiểm soát được thuật toán của Google. Ai cam kết điều đó đang bán cho bạn một trong hai thứ: từ khoá không có người tìm, hoặc một cách làm sẽ khiến website bị phạt về sau.</p>
                    <p class="svc-vow__yes">Chúng tôi cam kết phần nằm trong tầm tay: khối lượng công việc mỗi tháng, chất lượng kỹ thuật, và một báo cáo trung thực kể cả khi số liệu đi xuống.</p>
                </div>

                <div class="svc-actions svc-actions--center">
                    <button type="button" class="svc-btn svc-btn--primary" data-lead-open
                            data-lead-subject="Dịch vụ SEO">Nhận audit miễn phí</button>
                    <a class="svc-btn svc-btn--secondary" href="{{ write_url('tin-cong-nghe') }}">Đọc bài về SEO</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Month by month ────────────────────────────────────────── --}}
    <section class="svc-curve">
        <div class="uk-container uk-container-center">
            <header class="svc-sechead">
                <p class="svc-eyebrow">Kỳ vọng</p>
                <h2 class="svc-h2">Sáu tháng đầu diễn ra thế nào</h2>
                <p class="svc-p">Đây là hình dạng thật của gần như mọi dự án. Nếu bạn cần khách trong 30 ngày, nên chạy quảng cáo song song — chúng tôi nói vậy ngay từ buổi đầu.</p>
            </header>

            {{-- Bars sized by what actually moves in each period. The first pair is
                 deliberately almost flat: that is the part clients are not told. --}}
            <ol class="svc-curve__list">
                @foreach ([
                    ['Tháng 1–2', 18, 'Sửa kỹ thuật và dựng cấu trúc chủ đề', 'Gần như không thấy gì trên báo cáo. Đây là giai đoạn dọn nền: tốc độ, dữ liệu có cấu trúc, trang trùng nội dung, sitemap.'],
                    ['Tháng 3–4', 52, 'Lượt hiển thị bắt đầu tăng', 'Bài mới được index và bắt đầu xuất hiện với các truy vấn dài. Lưu lượng tăng nhẹ, liên hệ chưa đổi nhiều.'],
                    ['Tháng 5–6', 88, 'Lưu lượng và liên hệ tăng rõ', 'Cụm chủ đề đã đủ dày để đỡ nhau. Đây là mốc hợp lý để đánh giá có tiếp tục hay không.'],
                ] as [$period, $pct, $title, $text])
                    <li class="svc-curve__item">
                        <div class="svc-curve__head">
                            <span class="svc-curve__period">{{ $period }}</span>
                            <span class="svc-curve__title">{{ $title }}</span>
                        </div>
                        <div class="svc-curve__bar">
                            <span style="--pct: {{ $pct }}%"></span>
                        </div>
                        <p class="svc-curve__text">{{ $text }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ── Three workstreams ─────────────────────────────────────── --}}
    <section class="svc-streams">
        <div class="uk-container uk-container-center">
            <header class="svc-sechead">
                <p class="svc-eyebrow">Công việc</p>
                <h2 class="svc-h2">Ba việc thực sự làm mỗi tháng</h2>
            </header>

            <div class="svc-streams__grid">
                @foreach ([
                    ['Kỹ thuật', ['Tốc độ tải và Core Web Vitals', 'Dữ liệu có cấu trúc', 'Sitemap và thẻ canonical', 'Xử lý trang trùng nội dung', 'Sửa liên kết hỏng']],
                    ['Nội dung', ['Nghiên cứu từ khoá theo ý định tìm kiếm', 'Dựng cấu trúc chủ đề theo cụm', 'Viết hoặc biên tập bài', 'Tối ưu trang danh mục đang có', 'Tối ưu trang dịch vụ']],
                    ['Đo lường', ['Cấu hình theo dõi chuyển đổi', 'Đọc Search Console mỗi tuần', 'Báo cáo theo lưu lượng và liên hệ', 'Chọn việc tháng sau theo dữ liệu', 'Nói rõ việc nào không hiệu quả']],
                ] as $i => [$name, $items])
                    <div class="svc-stream">
                        <span class="svc-stream__index" aria-hidden="true">{{ sprintf('%02d', $i + 1) }}</span>
                        <h3 class="svc-stream__name">{{ $name }}</h3>
                        <ul class="svc-checks">
                            @foreach ($items as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Prices as a plain list ────────────────────────────────── --}}
    <section class="svc-plain">
        <div class="uk-container uk-container-center">
            <header class="svc-sechead">
                <p class="svc-eyebrow">{{ $offer['label'] }}</p>
                <h2 class="svc-h2">{{ $offer['heading'] }}</h2>
            </header>

            <ul class="svc-plain__list">
                @foreach ($offer['cards'] as $card)
                    <li class="svc-plain__row {{ !empty($card['featured']) ? 'is-featured' : '' }}">
                        <div class="svc-plain__left">
                            <span class="svc-plain__name">{{ $card['name'] }}</span>
                            <span class="svc-plain__meta">
                                {{ collect($card['rows'])->filter(fn ($r) => $r[1] !== '—')->map(fn ($r) => $r[0].': '.$r[1])->take(3)->implode(' · ') }}
                            </span>
                        </div>
                        <div class="svc-plain__right">
                            <span class="svc-plain__price">{{ $card['price'] }}<i>{{ $card['per'] }}</i></span>
                            <button type="button" class="svc-btn svc-btn--primary svc-btn--sm" data-lead-open
                                    data-lead-subject="Dịch vụ SEO — {{ $card['name'] }}">Chọn</button>
                        </div>
                    </li>
                @endforeach
            </ul>

            <p class="svc-note">{{ $service['note'] }}</p>
        </div>
    </section>

    @include('frontend.homepage.home.services.partials.closing', [
        'subject' => 'Dịch vụ SEO',
        'title' => 'Gửi địa chỉ website, nhận audit miễn phí',
        'lead' => 'Chúng tôi trả lại một danh sách việc cần làm theo thứ tự ưu tiên. Bạn tự làm cũng được, không bắt buộc thuê chúng tôi.',
    ])
</div>
@endsection
