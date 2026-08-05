@extends('frontend.homepage.layout')
@section('content')

{{--
    Service page — thiết kế theo yêu cầu, website mẫu có sẵn, chăm sóc website, hosting,
    plus the pricing, SEO and policy pages, all of which are Posts with template = 2.

    A service page has one job: explain the service well enough that someone decides to
    call. So it is a headline, the body, and a way to get in touch — with a table of
    contents built from the body's own headings, because these pages run long.
--}}

@php
    $pv = $post->languages->first()?->pivot;
    $title = $pv->name ?? '';
    $lead = plain_text($pv->description ?? '');
    $body = $pv->content ?? '';
    $cover = trim((string) $post->image);

    $catPivot = $postCatalogue->languages->first()?->pivot;
    $catName = $catPivot->name ?? '';

    // Table of contents from the body's own <h2>s, with ids injected so the links land.
    // Built here rather than stored, so it can never fall out of step with the content.
    $toc = [];
    if (trim(strip_tags($body)) !== '') {
        if (preg_match_all('/<h2[^>]*>(.*?)<\/h2>/is', $body, $m)) {
            foreach ($m[1] as $i => $heading) {
                $text = trim(strip_tags($heading));
                if ($text === '') continue;
                $slug = 'muc-'.($i + 1);
                $toc[] = ['slug' => $slug, 'text' => $text];
                $body = preg_replace(
                    '/'.preg_quote($m[0][$i], '/').'/',
                    '<h2 id="'.$slug.'">'.$heading.'</h2>',
                    $body,
                    1
                );
            }
        }
    }

    // The other service pages. The controller resolves these from the menu — this
    // catalogue also holds the policy and FAQ pages, and offering those under
    // "Dịch vụ khác" would be misleading.
    $siblings = collect($serviceSiblings ?? [])->take(6);
@endphp

<div class="store store-page news-page service-page">

    {{-- ── Header ────────────────────────────────────────────────── --}}
    <section class="store-hero service-hero">
        @if ($cover !== '')
            <div class="store-hero__back" aria-hidden="true">
                <div class="store-hero__back-layer is-on" style="background-image:url('{{ image($cover) }}')"></div>
            </div>
        @endif

        <div class="uk-container uk-container-center">
            <div class="service-hero__inner">
                <p class="store-hero__eyebrow">{{ $catName !== '' ? $catName : 'Dịch vụ' }}</p>
                <h1 class="article-title">{{ $title }}</h1>

                @if ($lead !== '')
                    <p class="article-lead">{{ $lead }}</p>
                @endif

                <div class="store-hero__actions">
                    <a class="store-btn store-btn--primary" href="#tu-van">Nhận tư vấn</a>
                    <a class="store-btn store-btn--ghost" href="{{ write_url('kho-giao-dien') }}">Xem kho giao diện</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Body + contents ───────────────────────────────────────── --}}
    <section class="service-body">
        <div class="uk-container uk-container-center">
            <div class="service-layout">
                <div class="service-main tpl-prose">
                    @if (trim(strip_tags($body)) !== '')
                        {!! $body !!}
                    @else
                        <p>{{ $lead }}</p>
                    @endif
                </div>

                @if (count($toc) > 1)
                    {{-- Sticky on desktop, and skipped entirely when the page has only one
                         heading — a contents list of one item is furniture, not help. --}}
                    <aside class="service-toc" aria-label="Nội dung trang">
                        <p class="service-toc__label">Trong trang này</p>
                        <ol class="service-toc__list">
                            @foreach ($toc as $item)
                                <li><a href="#{{ $item['slug'] }}">{{ $item['text'] }}</a></li>
                            @endforeach
                        </ol>

                        <div class="service-toc__cta">
                            <p>Cần hỏi trước khi quyết định?</p>
                            <a class="store-btn store-btn--primary" href="{{ tel_href($system['contact_hotline'] ?? '') }}">
                                {{ $system['contact_hotline'] ?? '' }}
                            </a>
                        </div>
                    </aside>
                @endif
            </div>
        </div>
    </section>

    {{-- ── Enquiry ──────────────────────────────────────────────── --}}
    <section class="tpl-cta" id="tu-van">
        <div class="uk-container uk-container-center">
            <div class="tpl-cta__box">
                <div class="tpl-cta__copy">
                    <h2 class="tpl-cta__title">{{ $title }}</h2>
                    <p class="tpl-cta__sub">Để lại số điện thoại, chúng tôi gọi lại trong giờ hành chính. Không gọi ngoài giờ, không gọi lại nhiều lần nếu bạn không bắt máy.</p>
                </div>

                <form class="tpl-form" action="{{ route('fe.contact.advise') }}" method="post" data-lead>
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="content" value="Quan tâm dịch vụ: {{ $title }}">

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

    {{-- ── Other services ───────────────────────────────────────── --}}
    @if ($siblings->isNotEmpty())
        <section class="news-list service-others">
            <div class="uk-container uk-container-center">
                <header class="store-shelf__head">
                    <h2 class="store-shelf__title">Dịch vụ khác</h2>
                </header>

                <div class="news-grid">
                    @foreach ($siblings as $item)
                        @include('frontend.component.article-card', ['post' => $item])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>

<script>
    // Highlight the heading currently on screen in the contents list.
    (function () {
        var links = document.querySelectorAll('.service-toc__list a');
        if (!links.length || !('IntersectionObserver' in window)) return;

        var byId = {};
        links.forEach(function (a) { byId[a.getAttribute('href').slice(1)] = a; });

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (!e.isIntersecting) return;
                links.forEach(function (a) { a.classList.remove('is-on'); });
                if (byId[e.target.id]) byId[e.target.id].classList.add('is-on');
            });
        }, { rootMargin: '-30% 0px -60% 0px' });

        Object.keys(byId).forEach(function (id) {
            var el = document.getElementById(id);
            if (el) observer.observe(el);
        });
    })();

    // Same enquiry handler as the template page: only claim success on code 10.
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
                    if (data.status === 422) {
                        msg.className = 'tpl-form__msg is-bad';
                        msg.textContent = data.messages.name || data.messages.phone || data.messages.email || 'Vui lòng kiểm tra lại thông tin.';
                        btn.disabled = false;
                        return;
                    }
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
                    msg.className = 'tpl-form__msg is-bad';
                    msg.textContent = 'Không gửi được. Vui lòng gọi {{ $system['contact_hotline'] ?? '' }}.';
                    btn.disabled = false;
                });
        });
    });
</script>
@endsection
