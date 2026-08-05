{{--
    The closing block, shared by the four service landings.

    Deliberately the only thing they share: every page argues its own way and then ends
    the same way, because the next step is the same everywhere — a call or a form.

    Expects: $subject, $title, $lead
--}}
<section class="svc-close">
    <div class="uk-container uk-container-center">
        <div class="svc-close__box">
            <div>
                <h2 class="svc-close__title">{{ $title }}</h2>
                <p class="svc-close__lead">{{ $lead }}</p>
            </div>

            <div class="svc-close__actions">
                <button type="button" class="svc-btn svc-btn--primary" data-lead-open
                        data-lead-subject="{{ $subject }}">Để lại số điện thoại</button>
                <a class="svc-btn svc-btn--ghost" href="{{ tel_href($system['contact_hotline'] ?? '') }}">
                    {{ $system['contact_hotline'] ?? '' }}
                </a>
            </div>
        </div>
    </div>
</section>
