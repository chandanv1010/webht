{{--
    Plays the site's own Lottie animations.

    The player is vendored, not loaded from a CDN, and the JSON lives in this repo. Every
    animation here used to be a lottie.host URL; when that account closed, each one became
    a blank hole. Nothing in this chain now depends on someone else's account staying open.

    Loaded only when a page actually has an animation, only when one scrolls into view, and
    never when the visitor has asked for reduced motion — in which case the inline SVG
    fallback simply stays.
--}}
<script>
(function () {
    var boxes = document.querySelectorAll('[data-lottie]');
    if (!boxes.length) return;

    // Reduced motion: leave the static SVG alone. It is the same drawing, not moving.
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    var loading = null;

    function loadPlayer() {
        if (loading) return loading;

        loading = new Promise(function (resolve, reject) {
            var s = document.createElement('script');
            s.src = '{{ asset('frontend/resources/vendor/lottie_light.min.js') }}';
            s.async = true;
            s.onload = function () { resolve(window.lottie); };
            s.onerror = reject;
            document.head.appendChild(s);
        });

        return loading;
    }

    function play(box) {
        if (box.dataset.lottieOn) return;
        box.dataset.lottieOn = '1';

        loadPlayer().then(function (lottie) {
            if (!lottie) return;

            var mount = document.createElement('div');
            mount.className = 'illus__anim';
            box.appendChild(mount);

            var anim = lottie.loadAnimation({
                container: mount,
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: box.getAttribute('data-lottie'),
            });

            // Only hide the fallback once the animation has really parsed, so a broken or
            // missing file leaves the drawing that was already there.
            anim.addEventListener('DOMLoaded', function () {
                box.classList.add('illus--animated');
            });
            anim.addEventListener('data_failed', function () {
                mount.remove();
                box.removeAttribute('data-lottie-on');
            });

            // Stop when it is off screen: an animation nobody can see is only heat.
            if ('IntersectionObserver' in window) {
                new IntersectionObserver(function (entries) {
                    entries.forEach(function (e) {
                        e.isIntersecting ? anim.play() : anim.pause();
                    });
                }, { rootMargin: '80px' }).observe(box);
            }
        }).catch(function () {
            // The player did not load. The SVG is still on screen; nothing to do.
        });
    }

    if (!('IntersectionObserver' in window)) {
        boxes.forEach(play);
        return;
    }

    var watcher = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (!e.isIntersecting) return;
            play(e.target);
            watcher.unobserve(e.target);
        });
    }, { rootMargin: '200px' });

    boxes.forEach(function (box) { watcher.observe(box); });
})();
</script>
