{{--
    One enquiry popup for the whole site.

    Any element with data-lead-open opens it; data-lead-subject on that element says what
    the visitor was looking at, and that text is stored with the enquiry and sent to
    Telegram — so a lead from the hosting price card and one from a slide CTA are told
    apart without four different forms.

    Included once in the layout, so no page has to remember to add it.
--}}
<div class="lead-modal" id="lead-modal" hidden>
    <div class="lead-modal__veil" data-lead-close></div>

    <div class="lead-modal__panel" role="dialog" aria-modal="true" aria-labelledby="lead-modal-title">
        <button type="button" class="lead-modal__x" data-lead-close aria-label="Đóng">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                <path d="M6 6l12 12M18 6L6 18"/>
            </svg>
        </button>

        <p class="lead-modal__eyebrow" data-lead-context></p>
        <h2 class="lead-modal__title" id="lead-modal-title">Để lại thông tin, chúng tôi gọi lại</h2>
        <p class="lead-modal__sub">Hai ô đầu là bắt buộc. Trong giờ hành chính chúng tôi gọi lại trong khoảng một giờ.</p>

        <form class="lead-modal__form" action="{{ route('fe.contact.advise') }}" method="post" data-lead-form>
            @csrf
            <input type="hidden" name="address" value="" data-lead-subject-field>

            <label for="lead-modal-name">Họ và tên <span aria-hidden="true">*</span></label>
            <input id="lead-modal-name" type="text" name="name" required autocomplete="name">

            <label for="lead-modal-phone">Số điện thoại <span aria-hidden="true">*</span></label>
            <input id="lead-modal-phone" type="tel" name="phone" required autocomplete="tel" inputmode="tel">

            <label for="lead-modal-content">Bạn cần gì</label>
            <textarea id="lead-modal-content" name="content" rows="3"
                      placeholder="Vài câu về việc bạn đang cần làm."></textarea>

            <button type="submit" class="svc-btn svc-btn--primary svc-btn--block">Gửi yêu cầu</button>

            <p class="lead-modal__msg" data-lead-msg role="status" aria-live="polite"></p>
            <p class="lead-modal__fine">
                Hoặc gọi ngay
                <a href="{{ tel_href($system['contact_hotline'] ?? '') }}">{{ $system['contact_hotline'] ?? '' }}</a>.
                Thông tin chỉ dùng để liên hệ về yêu cầu này.
            </p>
        </form>
    </div>
</div>

<script>
(function () {
    var modal = document.getElementById('lead-modal');
    if (!modal) return;

    var form = modal.querySelector('[data-lead-form]');
    var msg = modal.querySelector('[data-lead-msg]');
    var btn = form.querySelector('button[type="submit"]');
    var contextLine = modal.querySelector('[data-lead-context]');
    var subjectField = modal.querySelector('[data-lead-subject-field]');
    var lastTrigger = null;

    function open(trigger) {
        lastTrigger = trigger || null;

        var subject = (trigger && trigger.getAttribute('data-lead-subject')) || '';
        subjectField.value = subject;
        contextLine.textContent = subject;
        contextLine.hidden = subject === '';

        msg.textContent = '';
        msg.className = 'lead-modal__msg';
        btn.disabled = false;

        modal.hidden = false;
        // A frame later, so the transition has a start state to animate from.
        requestAnimationFrame(function () { modal.classList.add('is-open'); });
        document.documentElement.style.overflow = 'hidden';

        var first = modal.querySelector('input[name="name"]');
        if (first) first.focus({ preventScroll: true });
    }

    function close() {
        modal.classList.remove('is-open');
        document.documentElement.style.overflow = '';

        // Wait out the fade before hiding, or the panel disappears instantly.
        var done = function () { modal.hidden = true; };
        var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        reduce ? done() : setTimeout(done, 220);

        if (lastTrigger && document.contains(lastTrigger)) lastTrigger.focus();
    }

    document.addEventListener('click', function (e) {
        var opener = e.target.closest('[data-lead-open]');
        if (opener) {
            e.preventDefault();
            open(opener);
            return;
        }
        if (e.target.closest('[data-lead-close]')) {
            e.preventDefault();
            close();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.hidden) close();
        if (e.key !== 'Tab' || modal.hidden) return;

        // Keep focus inside the dialog while it is open.
        var focusable = modal.querySelectorAll('button, input, textarea, a[href]');
        if (!focusable.length) return;
        var first = focusable[0];
        var last = focusable[focusable.length - 1];

        if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
        else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        btn.disabled = true;
        msg.className = 'lead-modal__msg';
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
                    msg.className = 'lead-modal__msg is-bad';
                    msg.textContent = data.messages.name || data.messages.phone || 'Vui lòng kiểm tra lại thông tin.';
                    btn.disabled = false;
                    return;
                }
                // Only code 10 means the enquiry is actually stored.
                if (data.code !== 10) {
                    msg.className = 'lead-modal__msg is-bad';
                    msg.textContent = 'Không lưu được yêu cầu. Vui lòng gọi {{ $system['contact_hotline'] ?? '' }}.';
                    btn.disabled = false;
                    return;
                }
                msg.className = 'lead-modal__msg is-good';
                msg.textContent = 'Đã nhận yêu cầu. Chúng tôi gọi lại trong 1 giờ làm việc.';
                form.reset();
                subjectField.value = '';
            })
            .catch(function () {
                msg.className = 'lead-modal__msg is-bad';
                msg.textContent = 'Không gửi được. Vui lòng gọi {{ $system['contact_hotline'] ?? '' }}.';
                btn.disabled = false;
            });
    });
})();
</script>
