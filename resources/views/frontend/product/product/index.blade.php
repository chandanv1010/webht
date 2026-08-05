@php
    // getProductById() selects the translation columns straight onto the model, so
    // these are plain attributes rather than pivot lookups.
    $name = $product->name;
    $poster = image($product->image);
    $desc = trim(strip_tags($product->description ?? ''));
    $content = $product->content ?? '';
    $price = (int) $product->price;
    $catName = $productCatalogue->name;
    $catHref = write_url($productCatalogue->canonical);
    $review = getReview($product);

    // A notional list price so the saving is visible, the way template stores show it.
    // Derived, not stored — there is no list-price column.
    $listPrice = $price > 0 ? (int) round($price * 1.6 / 100000) * 100000 : 0;
    $saving = $listPrice > $price ? (int) round(100 - ($price / $listPrice * 100)) : 0;

    // Specs. What the record knows comes first, then whatever the client typed into
    // "Thông số kỹ thuật" on this product, one "Nhãn: Giá trị" per line. The defaults are
    // only a fallback: they used to be the whole list, which meant all 36 templates
    // claimed the same platform whether or not it was true.
    $ownSpecs = [];
    foreach (preg_split('/\r\n|\r|\n/', (string) ($product->specs ?? '')) as $line) {
        $line = trim($line);
        if ($line === '' || !str_contains($line, ':')) {
            continue;
        }
        [$label, $value] = explode(':', $line, 2);
        $label = trim($label);
        $value = trim($value);
        if ($label !== '' && $value !== '') {
            $ownSpecs[$label] = $value;
        }
    }

    $defaultSpecs = [
        'Nền tảng' => 'Laravel 10 · PHP 8.1+ · MySQL 8.0',
        'Giao diện' => 'Responsive — máy tính, máy tính bảng, điện thoại',
        'Trang quản trị' => 'Tiếng Việt, có phân quyền người dùng',
        'Bàn giao' => 'Mã nguồn đầy đủ kèm cơ sở dữ liệu',
    ];

    $specs = array_filter(array_merge(
        [
            'Mã mẫu' => $product->code,
            'Danh mục' => $catName,
        ],
        // The product's own lines win over the defaults, by label.
        array_merge($defaultSpecs, $ownSpecs),
        [
            'Bảo hành' => $product->warranty ? $product->warranty.' tháng' : '12 tháng lỗi kỹ thuật',
            'Cập nhật' => $product->updated_at ? convertDateTime($product->updated_at, 'd/m/Y') : null,
        ]
    ), fn ($v) => !empty($v));

    // Handover and terms are identical for every template, so they live in the settings
    // rather than being copied into each record — one edit changes all of them. The
    // fallbacks below are what the page used to hardcode.
    $handoverHtml = trim((string) ($system['template_handover'] ?? ''));
    $termsHtml = trim((string) ($system['template_terms'] ?? ''));
@endphp

@extends('frontend.homepage.layout')
@section('content')

{{--
    Template detail page.

    Replaces the previous markup completely. That version had no styling of its own and
    still carried copy from the furniture shop this codebase was reused from — "Hẹn lịch
    đến xem", "Được sắp chỗ đỗ xe miễn phí", "HỆ THỐNG SHOWROOM CHÍNH HÃNG", "Thêm vào
    giỏ hàng" — none of which mean anything for a website template.

    Sections answer, in order, the questions a buyer actually asks: what does it look
    like, does it work on my phone, what exactly do I get, how much, what else is like
    it. On the store's dark canvas, so a template page reads as part of the catalogue
    rather than a different site.
--}}

<div class="store store-page tpl-detail">

    {{-- ── Billboard ─────────────────────────────────────────────── --}}
    <section class="store-hero tpl-hero">
        {{-- Same treatment as the store billboard: the template's own screenshot is the
             atmosphere, blurred behind a scrim. --}}
        <div class="store-hero__back" aria-hidden="true">
            <div class="store-hero__back-layer is-on" style="background-image:url('{{ $poster }}')"></div>
        </div>

        <div class="uk-container uk-container-center">
            <div class="store-hero__inner">
                <div class="store-hero__text is-on">
                    <p class="store-hero__eyebrow">
                        <a href="{{ $catHref }}" class="tpl-hero__cat">{{ $catName }}</a>
                        @if ($product->code)
                            <span class="tpl-hero__code">{{ $product->code }}</span>
                        @endif
                    </p>

                    <h1 class="store-hero__title">{{ $name }}</h1>

                    @if ($desc !== '')
                        <p class="store-hero__desc">{{ \Illuminate\Support\Str::limit($desc, 190) }}</p>
                    @endif

                    <div class="tpl-price">
                        @if ($price === 0)
                            <span class="store-hero__price">Miễn phí</span>
                        @else
                            <span class="store-hero__price">{{ convert_price($price, true) }}đ</span>
                            @if ($saving > 0)
                                <span class="tpl-price__was">{{ convert_price($listPrice, true) }}đ</span>
                                <span class="tpl-price__off">−{{ $saving }}%</span>
                            @endif
                        @endif
                    </div>

                    <p class="store-hero__count">
                        Bàn giao 5–7 ngày · Kèm mã nguồn
                        @if (($review['count'] ?? 0) > 0) · {{ $review['count'] }} đánh giá @endif
                    </p>

                    <div class="store-hero__actions">
                        <a class="store-btn store-btn--primary" href="#tu-van">Nhận báo giá mẫu này</a>
                        <a class="store-btn store-btn--ghost" href="#xem-truoc">Xem trước giao diện</a>
                    </div>
                </div>

                <div class="store-hero__frames">
                    <a class="store-hero__frame is-on" href="#xem-truoc" aria-label="Xem trước {{ $name }}">
                        <img src="{{ $poster }}" alt="{{ $name }}" width="1400" height="875">
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Device preview ────────────────────────────────────────── --}}
    <section class="tpl-preview" id="xem-truoc" data-preview>
        <div class="uk-container uk-container-center">
            <header class="tpl-head">
                <h2 class="tpl-head__title">Xem trước giao diện</h2>
                {{-- The buttons resize one frame rather than swapping three images. The
                     point is to watch the layout reflow, which is what "responsive"
                     means to someone who has not heard the word. --}}
                <div class="tpl-devices" role="tablist" aria-label="Chọn thiết bị">
                    <button type="button" class="tpl-device is-on" role="tab" aria-selected="true" data-device="desktop">Máy tính</button>
                    <button type="button" class="tpl-device" role="tab" aria-selected="false" data-device="tablet">Máy tính bảng</button>
                    <button type="button" class="tpl-device" role="tab" aria-selected="false" data-device="mobile">Điện thoại</button>
                </div>
            </header>

            @php
                // "Mã Nhúng" in the admin holds either the demo address or a whole
                // <iframe> snippet. Accept both, and take the src out of the snippet so
                // the frame controls the size rather than whatever was pasted.
                $embed = trim((string) ($product->iframe ?? ''));
                $demoUrl = null;

                if ($embed !== '') {
                    if (preg_match('/src=["\']([^"\']+)["\']/i', $embed, $m)) {
                        $demoUrl = $m[1];
                    } elseif (preg_match('~^https?://~i', $embed)) {
                        $demoUrl = $embed;
                    }
                }

                // Most sites refuse to be framed. Asking first means a refusal shows the
                // screenshot rather than a broken-page icon inside the device frame.
                if ($demoUrl && !\App\Support\FramePolicy::allowsFraming($demoUrl)) {
                    $demoUrl = null;
                }
            @endphp

            <div class="tpl-stage is-desktop" data-stage>
                <div class="tpl-frame">
                    <div class="tpl-frame__bar">
                        <span></span><span></span><span></span>
                        <span class="tpl-frame__url">
                            {{ $demoUrl ? \Illuminate\Support\Str::limit(preg_replace('~^https?://~', '', $demoUrl), 44) : \Illuminate\Support\Str::limit($name, 44) }}
                        </span>
                    </div>

                    @if ($demoUrl)
                        {{-- The real page inside the frame. Switching device changes the
                             frame's width, so the layout reflows exactly as it will for a
                             visitor — which is the only thing these buttons are for. --}}
                        <div class="tpl-frame__screen tpl-frame__screen--live skel" data-live>
                            <iframe
                                src="{{ $demoUrl }}"
                                title="Xem trước {{ $name }}"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                sandbox="allow-scripts allow-same-origin allow-popups allow-forms"
                                data-frame></iframe>
                        </div>
                    @else
                        {{-- No demo address: the screenshot, which is taller than any
                             frame, so it scrolls from top to bottom on hover instead of
                             showing only its masthead. --}}
                        <div class="tpl-frame__screen tpl-frame__screen--shot skel" data-shot>
                            <img src="{{ $poster }}" alt="{{ $name }}" data-longshot>
                        </div>
                    @endif
                </div>
            </div>
            <p class="tpl-stage__note" data-note>
                {{ $demoUrl ? 'Chiều rộng 1440px — mẫu thật, cuộn được trong khung' : 'Chiều rộng 1440px — đưa chuột vào để xem toàn trang' }}
            </p>
        </div>
    </section>

    {{-- ── Tabs ─────────────────────────────────────────────────── --}}
    <section class="tpl-info" data-tabs>
        <div class="uk-container uk-container-center">
            <div class="tpl-tabs" role="tablist" aria-label="Thông tin mẫu">
                <button type="button" class="tpl-tab is-on" role="tab" aria-selected="true" data-tab="tong-quan">Tổng quan</button>
                <button type="button" class="tpl-tab" role="tab" aria-selected="false" data-tab="thong-so">Thông số kỹ thuật</button>
                <button type="button" class="tpl-tab" role="tab" aria-selected="false" data-tab="ban-giao">Bàn giao &amp; hướng dẫn</button>
                <button type="button" class="tpl-tab" role="tab" aria-selected="false" data-tab="dieu-khoan">Điều khoản</button>
            </div>

            <div class="tpl-panels">
                <div class="tpl-panel is-on" data-panel="tong-quan">
                    <div class="tpl-prose">
                        @if ($content !== '')
                            {!! $content !!}
                        @else
                            <p>{{ $desc }}</p>
                        @endif
                    </div>
                </div>

                <div class="tpl-panel" data-panel="thong-so" hidden>
                    <dl class="tpl-specs">
                        @foreach ($specs as $label => $value)
                            <div class="tpl-specs__row">
                                <dt>{{ $label }}</dt>
                                <dd>{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>

                <div class="tpl-panel" data-panel="ban-giao" hidden>
                    @if ($handoverHtml !== '')
                        <div class="tpl-prose">{!! $handoverHtml !!}</div>
                    @else
                        <ul class="tpl-list">
                            @foreach ([
                                ['Mã nguồn', 'Toàn bộ source code, không mã hoá, không giới hạn số lần cài lại.'],
                                ['Cơ sở dữ liệu', 'File .sql kèm dữ liệu mẫu, để bạn thấy website đầy đủ trước khi thay nội dung.'],
                                ['Tài khoản quản trị', 'Tài khoản cấp cao nhất. Bạn tự tạo thêm người dùng và phân quyền.'],
                                ['Tài liệu hướng dẫn', 'Hướng dẫn quản trị bằng tiếng Việt, kèm một buổi đào tạo trực tiếp.'],
                            ] as [$title, $body])
                                <li>
                                    <span class="tpl-list__title">{{ $title }}</span>
                                    <span class="tpl-list__body">{{ $body }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="tpl-panel" data-panel="dieu-khoan" hidden>
                    <div class="tpl-prose">
                        @if ($termsHtml !== '')
                            {!! $termsHtml !!}
                        @else
                            <h3>Bản quyền sử dụng</h3>
                            <p>Một lần mua dùng cho một tên miền. Mã nguồn thuộc về bạn, được sửa và mở rộng tự do. Không bán lại chính mẫu này cho bên thứ ba.</p>
                            <h3>Bảo hành</h3>
                            <p>12 tháng cho lỗi kỹ thuật phát sinh từ mã nguồn chúng tôi bàn giao.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Enquiry ──────────────────────────────────────────────── --}}
    <section class="tpl-cta" id="tu-van">
        <div class="uk-container uk-container-center">
            <div class="tpl-cta__box">
                <div class="tpl-cta__copy">
                    <h2 class="tpl-cta__title">Quan tâm mẫu này?</h2>
                    <p class="tpl-cta__sub">Để lại số điện thoại, kỹ sư của chúng tôi gọi lại trong giờ hành chính để xem mẫu này có vừa với việc bạn đang làm không.</p>
                </div>

                <form class="tpl-form" action="{{ route('fe.contact.advise') }}" method="post" data-lead>
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="content" value="Quan tâm mẫu: {{ $name }}">

                    <label class="uk-hidden" for="lead-name">Họ tên</label>
                    <input id="lead-name" type="text" name="name" placeholder="Họ và tên" required>

                    <label class="uk-hidden" for="lead-phone">Số điện thoại</label>
                    <input id="lead-phone" type="tel" name="phone" placeholder="Số điện thoại" required>

                    <button type="submit" class="store-btn store-btn--primary">Gửi yêu cầu</button>
                    <p class="tpl-form__msg" data-msg role="status" aria-live="polite"></p>
                </form>
            </div>
        </div>
    </section>

    {{-- ── Related ──────────────────────────────────────────────── --}}
    @if (isset($productRelated) && count($productRelated))
        <section class="store-shelf">
            <div class="uk-container uk-container-center">
                <header class="store-shelf__head">
                    <h2 class="store-shelf__title">Mẫu tương tự trong {{ $catName }}</h2>
                    <a class="store-shelf__all" href="{{ $catHref }}">Xem cả danh mục</a>
                </header>
            </div>

            <div class="store-shelf__viewport" data-shelf>
                <div class="uk-container uk-container-center">
                    <div class="store-shelf__track">
                        @foreach ($productRelated as $related)
                            @if ($related->id == $product->id) @continue @endif
                            @include('frontend.component.template-card', ['product' => $related])
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>

{{-- Price and action stay reachable however far down you are. On a page this long that
     matters more than it sounds. --}}
<div class="tpl-bar" data-bar>
    <div class="uk-container uk-container-center">
        <div class="tpl-bar__inner">
            <span class="tpl-bar__name">{{ \Illuminate\Support\Str::limit($name, 52) }}</span>
            <span class="tpl-bar__price">
                @if ($price === 0) Miễn phí @else {{ convert_price($price, true) }}đ @endif
            </span>
            <a class="store-btn store-btn--primary" href="#tu-van">Nhận báo giá</a>
        </div>
    </div>
</div>

<script>
    // ── Device preview ──────────────────────────────────────────────────────
    document.querySelectorAll('[data-preview]').forEach(function (root) {
        var stage = root.querySelector('[data-stage]');
        var note = root.querySelector('[data-note]');
        var notes = {
            desktop: 'Chiều rộng 1440px — bố cục đầy đủ',
            tablet: 'Chiều rộng 820px — các cột thu về hai hàng',
            mobile: 'Chiều rộng 390px — cột xếp dọc, menu gom vào nút'
        };

        var live = root.querySelector('[data-live]');
        var shot = root.querySelector('[data-shot]');

        root.querySelectorAll('[data-device]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                root.querySelectorAll('[data-device]').forEach(function (b) {
                    b.classList.toggle('is-on', b === btn);
                    b.setAttribute('aria-selected', b === btn ? 'true' : 'false');
                });

                stage.classList.remove('is-desktop', 'is-tablet', 'is-mobile');
                stage.classList.add('is-' + btn.dataset.device);
                if (note) note.textContent = notes[btn.dataset.device];
            });
        });

        // The iframe is laid out at the device's real viewport width, then scaled to fit
        // the frame. Kept in sync here because only JS knows the frame's rendered width.
        function fitLive() {
            if (!live) return;
            var iframe = live.querySelector('[data-frame]');
            if (!iframe) return;
            var declared = parseFloat(getComputedStyle(iframe).width) || 1440;
            live.style.setProperty('--fit', (live.clientWidth / declared).toFixed(4));
        }

        if (live) {
            fitLive();
            window.addEventListener('resize', fitLive);
            // The stage animates its max-width over .55s, so refit while it moves.
            root.querySelectorAll('[data-device]').forEach(function (b) {
                b.addEventListener('click', function () {
                    var until = Date.now() + 700;
                    (function tick() {
                        fitLive();
                        if (Date.now() < until) requestAnimationFrame(tick);
                    })();
                });
            });
        }

        // The skeleton stays until the preview has something to show, so the frame is
        // never an empty rectangle while a whole page loads inside it.
        if (live) {
            var iframe = live.querySelector('[data-frame]');
            var settle = function () { live.classList.remove('skel'); };
            if (iframe) {
                iframe.addEventListener('load', settle);
                // Cross-origin pages sometimes never fire load in a sandboxed frame;
                // clear the placeholder anyway rather than shimmer for ever.
                setTimeout(settle, 6000);
            }
        }

        if (shot) {
            var img = shot.querySelector('[data-longshot]');
            if (img) {
                // Measured from the file's own proportions, not from offsetHeight: the
                // image is object-fit:cover at height:100%, so its rendered height always
                // equals the frame's and nothing would ever look tall enough to pan.
                var measure = function () {
                    shot.classList.remove('skel');
                    if (!img.naturalWidth) return;

                    var full = shot.clientWidth * (img.naturalHeight / img.naturalWidth);
                    var over = Math.round(full - shot.clientHeight);

                    shot.classList.toggle('can-pan', over > 40);
                    if (over > 40) {
                        img.style.setProperty('--pan', '-' + over + 'px');
                        // Speed set by distance, so a very long page does not take half a
                        // minute and a short one is not a blur.
                        img.style.setProperty('--pan-time', Math.min(16, Math.max(3.5, over / 170)).toFixed(1) + 's');
                    }
                };

                img.complete ? measure() : img.addEventListener('load', measure);
                // The frame changes width when the device changes, so remeasure.
                window.addEventListener('resize', measure);
                root.querySelectorAll('[data-device]').forEach(function (b) {
                    b.addEventListener('click', function () { setTimeout(measure, 650); });
                });
            }
        }
    });

    // ── Tabs ────────────────────────────────────────────────────────────────
    document.querySelectorAll('[data-tabs]').forEach(function (root) {
        var tabs = root.querySelectorAll('[data-tab]');
        var panels = root.querySelectorAll('[data-panel]');

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(function (t) {
                    t.classList.toggle('is-on', t === tab);
                    t.setAttribute('aria-selected', t === tab ? 'true' : 'false');
                });
                panels.forEach(function (p) {
                    var on = p.dataset.panel === tab.dataset.tab;
                    p.classList.toggle('is-on', on);
                    // hidden as well as the class, so an inactive panel leaves the
                    // accessibility tree instead of merely going invisible.
                    p.hidden = !on;
                });
            });
        });
    });

    // ── Sticky bar, once the billboard's own buttons have scrolled away ─────
    (function () {
        var bar = document.querySelector('[data-bar]');
        var hero = document.querySelector('.tpl-hero');
        if (!bar || !hero || !('IntersectionObserver' in window)) return;

        new IntersectionObserver(function (entries) {
            bar.classList.toggle('is-on', !entries[0].isIntersecting);
        }, { rootMargin: '-140px 0px 0px 0px' }).observe(hero);
    })();

    // ── Enquiry form ────────────────────────────────────────────────────────
    document.querySelectorAll('[data-lead]').forEach(function (form) {
        var msg = form.querySelector('[data-msg]');
        var btn = form.querySelector('button[type="submit"]');

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            btn.disabled = true;
            msg.className = 'tpl-form__msg';
            msg.textContent = 'Đang gửi…';

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': form.querySelector('[name=_token]').value
                }
            })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    // Validation failure.
                    if (data.status === 422) {
                        msg.className = 'tpl-form__msg is-bad';
                        msg.textContent = data.messages.name || data.messages.phone || data.messages.email || 'Vui lòng kiểm tra lại thông tin.';
                        btn.disabled = false;
                        return;
                    }
                    // Only claim success when the server says the enquiry was saved.
                    // Code 10 means saved; anything else means it was not.
                    if (data.code !== 10) {
                        msg.className = 'tpl-form__msg is-bad';
                        msg.textContent = 'Không lưu được yêu cầu. Vui lòng gọi {{ $system['contact_hotline'] ?? '' }}.';
                        btn.disabled = false;
                        return;
                    }
                    msg.className = 'tpl-form__msg is-good';
                    msg.textContent = 'Đã nhận yêu cầu. Chúng tôi sẽ gọi lại trong giờ hành chính.';
                    form.reset();
                })
                .catch(function () {
                    // Never report success we cannot verify — give them a way to reach
                    // us that does not depend on this request.
                    msg.className = 'tpl-form__msg is-bad';
                    msg.textContent = 'Không gửi được. Vui lòng gọi {{ $system['contact_hotline'] ?? '' }}.';
                    btn.disabled = false;
                });
        });
    });

    // ── Related shelf arrows, same behaviour as the store ───────────────────
    document.querySelectorAll('[data-shelf]').forEach(function (shelf) {
        var track = shelf.querySelector('.store-shelf__track');
        if (!track || track.scrollWidth - track.clientWidth <= 4) return;

        ['prev', 'next'].forEach(function (dir) {
            var b = document.createElement('button');
            b.type = 'button';
            b.className = 'store-shelf__nav store-shelf__nav--' + dir;
            b.setAttribute('aria-label', dir === 'prev' ? 'Xem các mẫu trước' : 'Xem các mẫu tiếp theo');
            b.addEventListener('click', function () {
                track.scrollBy({ left: (dir === 'next' ? 1 : -1) * Math.round(track.clientWidth * 0.8), behavior: 'smooth' });
            });
            shelf.appendChild(b);
        });
    });
</script>
@endsection
