@extends('frontend.homepage.layout')

@section('content')
{{--
    Thiết kế theo yêu cầu.

    Laid out around the process, because that is what the decision turns on: someone
    spending 25–90 triệu wants to know what happens in which week and what they can see at
    each point. So the spine of this page is a timeline, and the price comes after it as a
    comparison table rather than three cards — a table is what you read when you are
    choosing between tiers on specifics.
--}}
@php $hero = $service['hero']; $offer = $service['offer']; @endphp

<div class="svc svc--process">

    {{-- ── Hero: the promise, and the first thing you receive ────── --}}
    <section class="svc-hero">
        <div class="uk-container uk-container-center">
            <div class="svc-hero__grid">
                <div class="svc-hero__copy">
                    <p class="svc-eyebrow">{{ $hero['eyebrow'] }}</p>
                    <h1 class="svc-title">{!! $hero['title'] !!}</h1>
                    <p class="svc-lead">{{ $hero['lead'] }}</p>

                    <div class="svc-actions">
                        <button type="button" class="svc-btn svc-btn--primary" data-lead-open
                                data-lead-subject="Thiết kế theo yêu cầu">Nhận tư vấn miễn phí</button>
                        <a class="svc-btn svc-btn--secondary" href="#quy-trinh">Xem quy trình</a>
                    </div>

                    <dl class="svc-facts">
                        <div><dt>Thời gian</dt><dd>4–10 tuần</dd></div>
                        <div><dt>Chi phí</dt><dd>25–90 triệu</dd></div>
                        <div><dt>Bảo hành</dt><dd>12 tháng</dd></div>
                    </dl>
                </div>

                {{-- Wireframe → thiết kế → chạy thật, the three states of the work, drawn
                     rather than described. --}}
                <div class="svc-triptych" aria-hidden="true">
                    <div class="svc-tri svc-tri--wire">
                        <span class="svc-tri__label">Wireframe</span>
                        <span class="svc-tri__row"></span>
                        <span class="svc-tri__row svc-tri__row--w70"></span>
                        <span class="svc-tri__blocks"><i></i><i></i><i></i></span>
                    </div>
                    <div class="svc-tri svc-tri--design">
                        <span class="svc-tri__label">Giao diện</span>
                        <span class="svc-tri__row"></span>
                        <span class="svc-tri__row svc-tri__row--w70"></span>
                        <span class="svc-tri__blocks"><i></i><i></i><i></i></span>
                    </div>
                    <div class="svc-tri svc-tri--live">
                        <span class="svc-tri__label">Chạy thật</span>
                        <span class="svc-tri__row"></span>
                        <span class="svc-tri__row svc-tri__row--w70"></span>
                        <span class="svc-tri__blocks"><i></i><i></i><i></i></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── When bespoke is the wrong answer ─────────────────────── --}}
    <section class="svc-band">
        <div class="uk-container uk-container-center">
            <div class="svc-band__grid">
                <h2 class="svc-h2">{!! $service['why']['heading'] !!}</h2>
                <div class="svc-band__body">
                    <p class="svc-p">{{ $service['why']['lead'] }}</p>
                    <ul class="svc-checks">
                        @foreach ($service['why']['points'] as $point)
                            <li>{{ $point }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ── The timeline: the spine of this page ─────────────────── --}}
    <section class="svc-timeline" id="quy-trinh">
        <div class="uk-container uk-container-center">
            <header class="svc-sechead">
                <p class="svc-eyebrow">{{ $service['steps']['label'] }}</p>
                <h2 class="svc-h2">{{ $service['steps']['heading'] }}</h2>
                <p class="svc-p">{{ $service['steps']['lead'] }}</p>
            </header>

            {{-- Numbered and ordered because it genuinely is a sequence: each step starts
                 when the one before it is signed off. --}}
            <ol class="svc-track">
                @foreach ($service['steps']['items'] as $step)
                    <li class="svc-track__item">
                        <div class="svc-track__marker" aria-hidden="true"></div>
                        <div class="svc-track__card">
                            <p class="svc-track__when">{{ $step['when'] }}</p>
                            <h3 class="svc-track__title">{{ $step['title'] }}</h3>
                            <p class="svc-track__text">{{ $step['text'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ── What you are handed ──────────────────────────────────── --}}
    <section class="svc-handover">
        <div class="uk-container uk-container-center">
            <div class="svc-handover__grid">
                <div>
                    <h2 class="svc-h2">Bàn giao gồm những gì</h2>
                    <ul class="svc-checks">
                        <li>Toàn bộ mã nguồn và cơ sở dữ liệu, kèm hướng dẫn cài lên máy chủ khác.</li>
                        <li>Tài liệu quản trị bằng tiếng Việt, viết theo đúng màn hình bạn dùng.</li>
                        <li>Một buổi đào tạo trực tiếp, có ghi lại cho nhân sự mới.</li>
                        <li>Tài khoản quản trị cấp cao nhất thuộc về bạn.</li>
                    </ul>
                </div>
                <div>
                    <h2 class="svc-h2">Không nằm trong phạm vi</h2>
                    <ul class="svc-checks svc-checks--no">
                        <li>Viết nội dung và chụp ảnh sản phẩm — báo giá riêng theo số lượng.</li>
                        <li>Chạy quảng cáo và SEO sau bàn giao.</li>
                        <li>Thêm luồng nghiệp vụ mới sau khi đã duyệt phạm vi, trừ khi báo giá bổ sung.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Price as a comparison table ──────────────────────────── --}}
    <section class="svc-pricing">
        <div class="uk-container uk-container-center">
            <header class="svc-sechead">
                <p class="svc-eyebrow">{{ $offer['label'] }}</p>
                <h2 class="svc-h2">{{ $offer['heading'] }}</h2>
            </header>

            {{-- A table, not cards: at this price someone is comparing specifics row by
                 row, and three cards force them to hold each list in their head. --}}
            <div class="svc-table-wrap">
                <table class="svc-table">
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
                                    <td class="{{ !empty($card['featured']) ? 'is-featured' : '' }}">
                                        {{ $card['rows'][$i][1] ?? '—' }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        <tr>
                            <th scope="row"></th>
                            @foreach ($offer['cards'] as $card)
                                <td class="{{ !empty($card['featured']) ? 'is-featured' : '' }}">
                                    <button type="button" class="svc-btn svc-btn--primary svc-btn--sm"
                                            data-lead-open
                                            data-lead-subject="Thiết kế theo yêu cầu — {{ $card['name'] }}">Chọn</button>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>

            <p class="svc-note">{{ $service['note'] }}</p>
        </div>
    </section>

    {{-- ── Questions asked before signing ───────────────────────── --}}
    <section class="svc-faq">
        <div class="uk-container uk-container-center">
            <h2 class="svc-h2">Câu hỏi trước khi ký</h2>

            <div class="svc-acc" data-acc>
                @foreach ([
                    ['Tôi chưa có nội dung thì có làm được không?', 'Được. Chúng tôi dựng bằng nội dung mẫu và thay dần. Nhưng phần văn bản chính nên do bạn viết vì bạn hiểu khách của mình nhất; chúng tôi biên tập lại.'],
                    ['Đang chạy dở muốn đổi yêu cầu?', 'Thay đổi trong phạm vi đã ký thì miễn phí. Thêm luồng mới thì báo giá bổ sung trước khi làm, không tính thêm sau.'],
                    ['Website có tự lên Google không?', 'Không. Chúng tôi làm đúng phần kỹ thuật: tốc độ, cấu trúc, dữ liệu có cấu trúc, sitemap. Thứ hạng cần nội dung và thời gian.'],
                    ['Nếu giữa đường tôi muốn dừng?', 'Thanh toán theo bốn mốc nên bạn chỉ trả cho phần đã nhận. Chúng tôi giao lại mọi thứ đã làm đến thời điểm đó, gồm cả file thiết kế.'],
                ] as $i => [$q, $a])
                    <div class="svc-acc__item {{ $i === 0 ? 'is-open' : '' }}">
                        <button type="button" class="svc-acc__q" aria-expanded="{{ $i === 0 ? 'true' : 'false' }}">
                            <span>{{ $q }}</span>
                            <i aria-hidden="true"></i>
                        </button>
                        <div class="svc-acc__a"><p>{{ $a }}</p></div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('frontend.homepage.home.services.partials.closing', [
        'subject' => 'Thiết kế theo yêu cầu',
        'title' => 'Kể cho chúng tôi về quy trình của bạn',
        'lead' => 'Buổi đầu thường 20 phút. Nếu mẫu có sẵn giải quyết được việc của bạn, chúng tôi sẽ nói vậy.',
    ])
</div>

<script>
    // Accordion. Only one open at a time, and the height animates from its real value so
    // it never has to guess.
    document.querySelectorAll('[data-acc]').forEach(function (acc) {
        var items = acc.querySelectorAll('.svc-acc__item');

        function setOpen(item, open) {
            var panel = item.querySelector('.svc-acc__a');
            item.classList.toggle('is-open', open);
            item.querySelector('.svc-acc__q').setAttribute('aria-expanded', open ? 'true' : 'false');
            panel.style.maxHeight = open ? panel.scrollHeight + 'px' : '0px';
        }

        items.forEach(function (item) {
            setOpen(item, item.classList.contains('is-open'));
            item.querySelector('.svc-acc__q').addEventListener('click', function () {
                var willOpen = !item.classList.contains('is-open');
                items.forEach(function (other) { setOpen(other, false); });
                if (willOpen) setOpen(item, true);
            });
        });

        window.addEventListener('resize', function () {
            items.forEach(function (item) {
                if (item.classList.contains('is-open')) setOpen(item, true);
            });
        });
    });
</script>
@endsection
