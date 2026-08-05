<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Guards which view each page actually renders.
 *
 * The template choice in PostController was inverted for a while: news articles got the
 * old landing-page view with furniture-shop leftovers in it, and the service pages got
 * the article view. Both pages returned 200 the whole time, so a status check never
 * caught it. These tests assert on markers that only the intended view emits.
 */
class PageTemplateTest extends TestCase
{
    use DatabaseTransactions;

    /** @return string the canonical of a published post with the given template */
    private function canonicalForTemplate(int $template): string
    {
        $canonical = DB::table('posts')
            ->join('post_language', 'post_language.post_id', '=', 'posts.id')
            ->where('posts.template', $template)
            ->where('posts.publish', 2)
            ->where('post_language.language_id', 1)
            ->whereNotNull('post_language.canonical')
            ->where('post_language.canonical', '!=', '')
            ->value('post_language.canonical');

        $this->assertNotNull($canonical, "no published post with template {$template}");

        return $canonical;
    }

    public function test_a_news_article_renders_the_article_view(): void
    {
        $res = $this->get('/'.$this->canonicalForTemplate(1).'.html');

        $res->assertStatus(200);
        $res->assertSee('article-page', false);
        // Leftovers from the furniture site the theme came from.
        $res->assertDontSee('SHOWROOM CHÍNH HÃNG', false);
        $res->assertDontSee('showroom-system', false);
    }

    public function test_a_service_page_renders_the_service_view(): void
    {
        $res = $this->get('/cham-soc-website.html');

        $res->assertStatus(200);
        $res->assertSee('service-page', false);
        // Built from the body's own headings, so its presence proves the body rendered.
        $res->assertSee('service-toc__list', false);
        $res->assertSee('Dịch vụ khác', false);
    }

    /**
     * "Dịch vụ khác" must list services. Every standalone page shares one catalogue, so
     * an unfiltered sibling query offered the payment policy as a service.
     *
     * Asserted against that section alone — the policy pages legitimately appear in the
     * footer menu on every page, so a whole-document assertion would always fail.
     */
    public function test_service_siblings_exclude_the_policy_pages(): void
    {
        $res = $this->get('/cham-soc-website.html');
        $res->assertStatus(200);

        $html = $res->getContent();
        $start = strpos($html, 'service-others');
        $this->assertNotFalse($start, 'the "Dịch vụ khác" section did not render');
        $section = substr($html, $start, strpos($html, '</section>', $start) - $start);

        $this->assertStringContainsString('Thiết kế website theo yêu cầu', $section);
        $this->assertStringNotContainsString('Chính sách thanh toán', $section);
        $this->assertStringNotContainsString('Quy định sử dụng', $section);
    }

    /** All four services the brief asked for have to exist and render. */
    public function test_every_service_page_resolves(): void
    {
        foreach ([
            'thiet-ke-theo-yeu-cau',
            'thiet-ke-website-theo-mau-co-san',
            'cham-soc-website',
            'dich-vu-hosting',
        ] as $canonical) {
            $res = $this->get('/'.$canonical.'.html');
            $res->assertStatus(200);
            $res->assertSee('service-page', false);
        }
    }

    public function test_contact_page_has_a_working_form(): void
    {
        $res = $this->get('/lien-he.html');

        $res->assertStatus(200);
        $res->assertSee('contact-page', false);
        $res->assertSee(route('fe.contact.advise'), false);
        $res->assertSee('name="phone"', false);
        $res->assertSee('name="email"', false);
        $res->assertSee('name="content"', false);
        // The old page's furniture leftovers.
        $res->assertDontSee('showroom-item', false);
        $res->assertDontSee('news-outstanding', false);
    }

    /** Every phone number on the site is the one the client asked for. */
    public function test_the_contact_page_shows_the_current_hotline(): void
    {
        $res = $this->get('/lien-he.html');

        $res->assertStatus(200);
        $res->assertSee('0982 365 824', false);
        $res->assertSee('href="tel:0982365824"', false);
    }
}
