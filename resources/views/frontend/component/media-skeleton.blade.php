{{--
    Skeletons for every image that arrives after paint.

    The template covers are large screenshots fetched from a capture service, so on a cold
    cache a card sat empty and then snapped in — or showed the browser's broken-image glyph
    while it waited. This marks each media box as loading, pulses it, and fades the image
    in once it has actually decoded.

    Applied here rather than in each view, so any card added later gets it for free.
--}}
<script>
(function () {
    // The media containers across the site. Each holds one <img> or <iframe>.
    var SELECTORS = [
        '.tpl-card__poster',
        '.hero__fan-item',
        '.art-card__media',
        '.store-hero__frame',
        '.tpl-frame__screen--shot',
        '.tpl-frame__screen--live',
        '.customer-item .avatar',
        '.showroom-item .image-content'
    ].join(',');

    function mark(box) {
        var media = box.querySelector('img, iframe');
        if (!media || box.hasAttribute('data-skel-media')) return;

        box.setAttribute('data-skel-media', '');

        // A cached image is already complete by the time this runs; do not make it blink.
        if (media.tagName === 'IMG' && media.complete) {
            box.classList.add(media.naturalWidth ? 'is-ready' : 'is-failed');
            return;
        }

        box.classList.add('skel');

        var done = function (ok) {
            box.classList.remove('skel');
            box.classList.add(ok ? 'is-ready' : 'is-failed');
        };

        media.addEventListener('load', function () {
            done(media.tagName !== 'IMG' || media.naturalWidth > 0);
        });
        media.addEventListener('error', function () { done(false); });
    }

    function scan(root) {
        (root || document).querySelectorAll(SELECTORS).forEach(mark);
    }

    scan(document);

    // Cards can arrive later — pagination, filters, anything that replaces a grid.
    if ('MutationObserver' in window) {
        new MutationObserver(function (records) {
            records.forEach(function (r) {
                r.addedNodes.forEach(function (n) {
                    if (n.nodeType !== 1) return;
                    if (n.matches && n.matches(SELECTORS)) mark(n);
                    scan(n);
                });
            });
        }).observe(document.body, { childList: true, subtree: true });
    }
})();
</script>
