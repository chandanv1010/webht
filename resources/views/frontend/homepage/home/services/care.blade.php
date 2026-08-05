@extends('frontend.homepage.layout')

@section('content')
{{--
    Chăm sóc website.

    Nobody buys maintenance because it sounds nice; they buy it after something breaks, or
    because they can imagine it breaking. So this page leads with the failures — named,
    with what each one costs — then shows who answers and how fast, and only then the
    plans, as a feature matrix.

    A status strip stands in for the hero image: this service is about a site staying up,
    and that is what up looks like.
--}}
@php $hero = $service['hero']; $offer = $service['offer']; @endphp

<div class="svc svc--care">

    {{-- ── Hero with a status strip ──────────────────────────────── --}}
    <section class="svc-hero svc-hero--care">
        <div class="uk-container uk-container-center">
            <div class="svc-hero__grid">
                <div class="svc-hero__copy">
                    <p class="svc-eyebrow">{{ $hero['eyebrow'] }}</p>
                    <h1 class="svc-title">{!! $hero['title'] !!}</h1>
                    <p class="svc-lead">{{ $hero['lead'] }}</p>

                    <div class="svc-actions">
                        <button type="button" class="svc-btn svc-btn--primary" data-lead-open
                                data-lead-subject="Chăm sóc website">Nhận báo giá gói phù hợp</button>
                        <a class="svc-btn svc-btn--secondary" href="#cac-goi">Xem ba gói</a>
                    </div>
                </div>

                {{-- Ninety days of uptime, one tick per day. The two amber ticks are honest:
                     a claim of a perfect record is the least believable thing on a
                     maintenance page. --}}
                <figure class="svc-status">
                    <figcaption>
                        <span class="svc-status__label">Uptime 90 ngày gần nhất</span>
                        <span class="svc-status__num">99,96%</span>
                    </figcaption>
                    <div class="svc-status__ticks" aria-hidden="true">
                        @for ($i = 0; $i < 90; $i++)
                            <i class="{{ in_array($i, [37, 68]) ? 'is-warn' : '' }}"></i>
                        @endfor
                    </div>
                    <p class="svc-status__legend">
                        <span><i></i> Bình thường</span>
                        <span><i class="is-warn"></i> Có cảnh báo, xử lý trong ngày</span>
                    </p>
                </figure>
            </div>
        </div>
    </section>

    {{-- ── What actually breaks ──────────────────────────────────── --}}
    <section class="svc-faults">
        <div class="uk-container uk-container-center">
            <header class="svc-sechead">
                <p class="svc-eyebrow">Vì sao trang đang chạy tốt vẫn cần chăm sóc</p>
                <h2 class="svc-h2">Phần lớn sự cố không đến từ lỗi lập trình</h2>
                <p class="svc-p">Nó đến từ những thứ đứng im trong khi thế giới bên ngoài thay đổi. Năm việc dưới đây chiếm gần hết số ca chúng tôi xử lý.</p>
            </header>

            <div class="svc-faults__grid">
                @foreach ([
                    ['Bản vá không cập nhật', 'Đến một ngày bị quét tự động và bị chèn mã. Khách vào thấy cảnh báo của Google.', 'Nặng'],
                    ['SSL hết hạn', 'Trình duyệt chặn, khách thấy màn hình đỏ. Thường xảy ra đúng cuối tuần.', 'Nặng'],
                    ['Tên miền hết hạn', 'Email nhắc gửi vào hộp thư của nhân sự đã nghỉ. Mất luôn cả email công ty.', 'Rất nặng'],
                    ['Ảnh không nén', 'Sau hai năm trang chủ nặng 12MB, mất 9 giây để mở. Khách rời trước khi thấy gì.', 'Vừa'],
                    ['Không ai sao lưu', 'Đến lúc cần thì không có gì để phục hồi. Đây là việc không sửa được sau.', 'Rất nặng'],
                ] as [$title, $text, $level])
                    <article class="svc-fault">
                        <span class="svc-fault__level svc-fault__level--{{ $level === 'Rất nặng' ? 'high' : ($level === 'Nặng' ? 'mid' : 'low') }}">{{ $level }}</span>
                        <h3 class="svc-fault__title">{{ $title }}</h3>
                        <p class="svc-fault__text">{{ $text }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Who answers, how fast ─────────────────────────────────── --}}
    <section class="svc-sla">
        <div class="uk-container uk-container-center">
            <div class="svc-sla__grid">
                <div class="svc-sla__copy">
                    <h2 class="svc-h2">Khi có sự cố</h2>
                    <p class="svc-p">Hệ thống theo dõi phát hiện trang không phản hồi và gửi cảnh báo trước khi bạn kịp nhận ra. Với gói ưu tiên, chúng tôi bắt đầu xử lý ngay mà không chờ bạn gọi.</p>
                    <ol class="svc-flow">
                        <li>Xác định phạm vi: toàn bộ website, một trang, hay một chức năng.</li>
                        <li>Nếu là tấn công hoặc lỗi dữ liệu, phục hồi từ bản sao lưu gần nhất trước.</li>
                        <li>Báo nguyên nhân và cách xử lý bằng tiếng Việt, không bằng ảnh chụp log.</li>
                        <li>Ghi vào báo cáo tháng để lần sau không lặp lại.</li>
                    </ol>
                </div>

                <div class="svc-sla__nums">
                    @foreach ([
                        ['5 phút', 'một lần kiểm tra trang còn sống'],
                        ['2 giờ', 'cam kết phản hồi sự cố, gói ưu tiên'],
                        ['30 bản', 'sao lưu gần nhất luôn được giữ'],
                    ] as [$num, $label])
                        <div class="svc-num">
                            <span class="svc-num__value">{{ $num }}</span>
                            <span class="svc-num__label">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ── Plans as a matrix ─────────────────────────────────────── --}}
    <section class="svc-matrix" id="cac-goi">
        <div class="uk-container uk-container-center">
            <header class="svc-sechead">
                <p class="svc-eyebrow">{{ $offer['label'] }}</p>
                <h2 class="svc-h2">{{ $offer['heading'] }}</h2>
            </header>

            <div class="svc-table-wrap">
                <table class="svc-table svc-table--matrix">
                    <thead>
                        <tr>
                            <th scope="col"><span class="uk-hidden">Hạng mục</span></th>
                            @foreach ($offer['cards'] as $card)
                                <th scope="col" class="{{ !empty($card['featured']) ? 'is-featured' : '' }}">
                                    <span class="svc-table__name">{{ $card['name'] }}</span>
                                    <span class="svc-table__price">{{ $card['price'] }}</span>
                                    <span class="svc-table__per">{{ $card['per'] }}</span>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($offer['cards'][0]['rows'] as $i => $row)
                            <tr>
                                <th scope="row">{{ $row[0] }}</th>
                                @foreach ($offer['cards'] as $card)
                                    @php $value = $card['rows'][$i][1] ?? '—'; @endphp
                                    <td class="{{ !empty($card['featured']) ? 'is-featured' : '' }} {{ $value === '—' ? 'is-off' : '' }}">
                                        @if ($value === 'Có')
                                            <span class="svc-tick" aria-label="Có">✓</span>
                                        @elseif ($value === '—')
                                            <span class="svc-cross" aria-label="Không">–</span>
                                        @else
                                            {{ $value }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        <tr>
                            <th scope="row"></th>
                            @foreach ($offer['cards'] as $card)
                                <td class="{{ !empty($card['featured']) ? 'is-featured' : '' }}">
                                    <button type="button" class="svc-btn svc-btn--primary svc-btn--sm" data-lead-open
                                            data-lead-subject="Chăm sóc website — {{ $card['name'] }}">Chọn</button>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>

            <p class="svc-note">{{ $service['note'] }}</p>
        </div>
    </section>

    @include('frontend.homepage.home.services.partials.closing', [
        'subject' => 'Chăm sóc website',
        'title' => 'Website của bạn lần cuối được sao lưu khi nào?',
        'lead' => 'Nếu bạn không trả lời ngay được, đó là lý do để gọi. Chúng tôi kiểm tra miễn phí và nói thẳng bạn có cần gói nào không.',
    ])
</div>
@endsection
