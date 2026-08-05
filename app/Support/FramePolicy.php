<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Whether a page will let us show it inside an iframe.
 *
 * Most sites refuse: they send X-Frame-Options: SAMEORIGIN or a CSP frame-ancestors that
 * excludes us, and the browser paints a broken-page icon inside the frame. That is worse
 * than no preview at all, so ask the server first and fall back to the screenshot when
 * the answer is no.
 *
 * The answer is cached for a day — it changes about as often as a server config does, and
 * a template detail page must not wait on a third-party request on every visit.
 */
class FramePolicy
{
    private const TTL = 86400;

    public static function allowsFraming(?string $url): bool
    {
        $url = trim((string) $url);

        if ($url === '' || !preg_match('~^https?://~i', $url)) {
            return false;
        }

        return Cache::remember('frameable:'.sha1($url), self::TTL, function () use ($url) {
            try {
                $res = Http::timeout(4)
                    ->connectTimeout(3)
                    ->withoutVerifying()
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; HTVietnamPreview/1.0)'])
                    ->get($url);
            } catch (\Throwable $e) {
                Log::info('Không kiểm tra được iframe cho '.$url.': '.$e->getMessage());

                return false;
            }

            if (!$res->successful()) {
                return false;
            }

            $xfo = strtolower(trim((string) $res->header('X-Frame-Options')));
            if ($xfo !== '' && (str_contains($xfo, 'deny') || str_contains($xfo, 'sameorigin'))) {
                return false;
            }

            $csp = strtolower((string) $res->header('Content-Security-Policy'));
            if ($csp !== '' && str_contains($csp, 'frame-ancestors')) {
                // Take only the frame-ancestors directive; 'none' and 'self' both exclude us.
                if (preg_match('/frame-ancestors([^;]*)/', $csp, $m)) {
                    $value = trim($m[1]);
                    if ($value === '' || str_contains($value, "'none'")) {
                        return false;
                    }
                    // Anything that is not a wildcard is a list we are almost certainly
                    // not on. Being wrong here costs a screenshot; being wrong the other
                    // way costs a broken frame on the page.
                    if (!str_contains($value, '*')) {
                        return false;
                    }
                }
            }

            return true;
        });
    }
}
