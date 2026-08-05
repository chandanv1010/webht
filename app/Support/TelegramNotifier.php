<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Sends new-lead notifications to Telegram.
 *
 * Deliberately best-effort. A lead is saved to the database first and notified
 * second, and a failure here is logged and swallowed — losing a customer enquiry
 * because a messaging API timed out would be far worse than a missed notification.
 *
 * Configure TELEGRAM_BOT_TOKEN and TELEGRAM_CHAT_ID in .env. With either missing the
 * class does nothing, so a developer machine needs no credentials.
 */
class TelegramNotifier
{
    private const TIMEOUT = 5;

    public static function enabled(): bool
    {
        return config('services.telegram.token') !== null
            && config('services.telegram.token') !== ''
            && config('services.telegram.chat_id') !== null
            && config('services.telegram.chat_id') !== '';
    }

    /**
     * @param  array<string, string|null> $fields  label => value, in display order
     */
    public static function lead(string $heading, array $fields, ?string $pageUrl = null): bool
    {
        if (!self::enabled()) {
            return false;
        }

        $lines = ['<b>'.self::esc($heading).'</b>'];

        foreach ($fields as $label => $value) {
            $value = trim((string) $value);
            if ($value === '') {
                continue;
            }
            $lines[] = self::esc($label).': <b>'.self::esc($value).'</b>';
        }

        if ($pageUrl) {
            $lines[] = self::esc('Từ trang').': '.self::esc($pageUrl);
        }

        $lines[] = self::esc('Lúc').': '.now()->format('H:i d/m/Y');

        return self::send(implode("\n", $lines));
    }

    private static function send(string $html): bool
    {
        try {
            $response = Http::timeout(self::TIMEOUT)
                ->asForm()
                ->post('https://api.telegram.org/bot'.config('services.telegram.token').'/sendMessage', [
                    'chat_id' => config('services.telegram.chat_id'),
                    'text' => $html,
                    'parse_mode' => 'HTML',
                    'disable_web_page_preview' => true,
                ]);

            if ($response->successful() && $response->json('ok') === true) {
                return true;
            }

            Log::warning('Telegram lead notification rejected', [
                'status' => $response->status(),
                'description' => $response->json('description'),
            ]);
        } catch (\Throwable $e) {
            // Never rethrow: the lead is already saved, and the visitor must still
            // see a success message.
            Log::warning('Telegram lead notification failed: '.$e->getMessage());
        }

        return false;
    }

    /** Telegram's HTML mode only allows a handful of tags; escape the rest. */
    private static function esc(?string $text): string
    {
        return htmlspecialchars((string) $text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
