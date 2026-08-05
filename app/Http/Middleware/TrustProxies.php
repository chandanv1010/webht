<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * Loopback only, and configurable: a tunnel (ngrok, cloudflared) or a local nginx
     * forwards from 127.0.0.1 and sets X-Forwarded-Proto: https. Without trusting it the
     * app builds every asset URL as http while the page itself is served over https, and
     * the browser blocks all of it as mixed content — the site arrives with no styles.
     *
     * Set TRUSTED_PROXIES in .env when the real proxy is not on loopback.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies = ['127.0.0.1', '::1'];

    public function __construct()
    {
        $configured = env('TRUSTED_PROXIES');

        if ($configured !== null && $configured !== '') {
            $this->proxies = $configured === '*' ? '*' : array_map('trim', explode(',', $configured));
        }
    }

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
