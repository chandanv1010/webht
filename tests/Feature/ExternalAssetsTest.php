<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Nothing on a page may block on a host we do not control.
 *
 * The template pages hung for half a minute because a stylesheet and a script were loaded
 * from prohousevn.com — the site this codebase was reused from — and that host had stopped
 * answering. A blocking <script> from a dead host leaves the page loading until the browser
 * gives up. The same shape of failure had already emptied every animation on the site when
 * lottie.host went away, and the home page was one outage away from it with a script from
 * getuikit.com.
 *
 * So the allowed list is written down. Adding a host means editing this test, which is the
 * point: it makes the decision deliberate.
 */
class ExternalAssetsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Hosts a page may fetch a script, stylesheet or font from.
     *
     * Fonts and a CDN are here because they are that: a CDN, with an outage record and a
     * fallback in the browser's own font stack. A company's own website is not.
     */
    private const ALLOWED = [
        'fonts.googleapis.com',
        'fonts.gstatic.com',
        'unpkg.com',
        'cdn.jsdelivr.net',
        // Loaded async and never blocking; it is the Facebook page plugin.
        'connect.facebook.net',
    ];

    /** Pages that between them load every stylesheet and script bundle the site has. */
    private const PAGES = [
        '/',
        '/kho-giao-dien.html',
        '/lien-he.html',
        '/blog.html',
        '/video.html',
        '/dich-vu.html',
        '/bang-gia.html',
        '/cham-soc-website.html',
        '/dich-vu-hosting.html',
        '/chi-phi-that-cua-mot-website-re.html',
    ];

    public function test_no_page_loads_a_script_or_stylesheet_from_an_unapproved_host(): void
    {
        // Assets are written as absolute URLs against APP_URL, so the site's own host
        // shows up in the same form as a third party's. Read it rather than hard-coding it,
        // so the test is as correct on production as it is here.
        $ownHost = parse_url((string) config('app.url'), PHP_URL_HOST);

        $offenders = [];

        foreach (self::PAGES as $url) {
            $res = $this->get($url);
            $res->assertStatus(200);

            $html = $res->getContent();

            // <script src> and <link href> only: an anchor to facebook.com is a link a
            // visitor may click, not something the page waits on.
            preg_match_all(
                '~<(?:script[^>]+src|link[^>]+href)=["\'](https?://[^"\']+)["\']~i',
                $html,
                $m
            );

            foreach ($m[1] as $asset) {
                $host = parse_url($asset, PHP_URL_HOST);
                if ($host === null || $host === $ownHost || in_array($host, self::ALLOWED, true)) {
                    continue;
                }
                $offenders[] = $url.'  →  '.$host;
            }
        }

        $this->assertSame([], array_values(array_unique($offenders)), implode("\n", [
            'A page is loading a script or stylesheet from a host that is not on the list.',
            'Vendor it into public/frontend/resources/vendor/, or add the host to',
            'ExternalAssetsTest::ALLOWED and say why.',
        ]));
    }

    /** The two we vendored after they broke, and the one we vendored before it could. */
    public function test_the_vendored_libraries_are_present(): void
    {
        foreach ([
            'frontend/resources/vendor/fancybox/jquery.fancybox.min.js',
            'frontend/resources/vendor/fancybox/jquery.fancybox.min.css',
            'frontend/resources/vendor/lottie_light.min.js',
            'frontend/resources/uikit/js/components/sticky.min.js',
        ] as $path) {
            $full = public_path($path);
            $this->assertFileExists($full, "missing vendored file: {$path}");
            $this->assertGreaterThan(1000, filesize($full), "{$path} looks truncated");
        }
    }

    /** The host that used to serve them must not come back. */
    public function test_the_dead_host_is_gone(): void
    {
        foreach (self::PAGES as $url) {
            $res = $this->get($url);
            $res->assertStatus(200);
            $res->assertDontSee('prohousevn.com', false);
            $res->assertDontSee('lottie.host', false);
            $res->assertDontSee('getuikit.com', false);
        }
    }
}
