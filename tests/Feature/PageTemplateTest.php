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

    /**
     * Each service has its own layout, built around what its own decision turns on. They
     * shared one template at first and came out indistinguishable, which is the thing
     * these assertions exist to catch: each page is checked for the structure only it has.
     */
    public function test_each_service_landing_has_its_own_layout(): void
    {
        $expected = [
            // bespoke work: a process spine and an FAQ
            'thiet-ke-theo-yeu-cau' => ['svc--process', 'svc-track', 'svc-acc'],
            // ready-made: real templates on screen and a day-by-day strip
            'thiet-ke-website-theo-mau-co-san' => ['svc--gallery', 'svc-tile', 'svc-strip'],
            // maintenance: the uptime record, the failure list, a feature matrix
            'cham-soc-website' => ['svc--care', 'svc-status', 'svc-fault', 'svc-table--matrix'],
            // seo: the refusal, and the month-by-month chart
            'dich-vu-seo' => ['svc--seo', 'svc-vow', 'svc-curve'],
        ];

        foreach ($expected as $canonical => $markers) {
            $res = $this->get('/'.$canonical.'.html');
            $res->assertStatus(200);

            foreach ($markers as $marker) {
                $res->assertSee($marker, false);
            }
        }
    }

    /** No two of them share a layout: each marker appears on exactly one page. */
    public function test_the_service_layouts_are_not_shared(): void
    {
        $html = [];
        foreach (['thiet-ke-theo-yeu-cau', 'thiet-ke-website-theo-mau-co-san',
                  'cham-soc-website', 'dich-vu-seo'] as $canonical) {
            $html[$canonical] = $this->get('/'.$canonical.'.html')->getContent();
        }

        foreach (['svc-track', 'svc-tile', 'svc-status', 'svc-vow'] as $marker) {
            $pages = array_keys(array_filter($html, fn ($h) => str_contains($h, $marker)));
            $this->assertCount(1, $pages, "$marker appears on ".count($pages).' pages, expected 1');
        }
    }

    /** Every page still opens the shared enquiry popup. */
    public function test_each_service_landing_opens_the_popup(): void
    {
        foreach (['thiet-ke-theo-yeu-cau', 'thiet-ke-website-theo-mau-co-san',
                  'cham-soc-website', 'dich-vu-seo'] as $canonical) {
            $res = $this->get('/'.$canonical.'.html');
            $res->assertStatus(200);
            $res->assertSee('data-lead-open', false);
        }
    }

    /** The hosting page keeps the hand-built view the client asked to keep. */
    public function test_hosting_keeps_its_own_view(): void
    {
        $res = $this->get('/dich-vu-hosting.html');

        $res->assertStatus(200);
        $res->assertSee('panel-search-domain', false);
        $res->assertSee('hosting-element-title', false);
        // Not one of the four new layouts.
        $res->assertDontSee('svc--process', false);
        $res->assertDontSee('svc--gallery', false);
    }

    /** Every landing states a price. A service page with no number is a brochure. */
    public function test_every_service_landing_states_prices(): void
    {
        foreach ([
            'cham-soc-website' => ['600.000đ', '3.500.000đ'],
            'thiet-ke-website-theo-mau-co-san' => ['4.500.000đ', '12.000.000đ'],
            'thiet-ke-theo-yeu-cau' => ['25–40 triệu'],
            'dich-vu-seo' => ['6.000.000đ'],
        ] as $canonical => $prices) {
            $res = $this->get('/'.$canonical.'.html');
            $res->assertStatus(200);
            foreach ($prices as $price) {
                $res->assertSee($price, false);
            }
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
        // The old page's furniture leftovers. Asserted on the markup, not the bare word:
        // the media-skeleton script names .showroom-item among the containers it watches
        // for the legacy views that still have one.
        $res->assertDontSee('class="showroom-item"', false);
        $res->assertDontSee('class="news-outstanding"', false);
    }

    /** The header the client asked for: slogan on top, search as its own field. */
    public function test_header_has_the_slogan_and_its_own_search(): void
    {
        $res = $this->get('/');

        $res->assertStatus(200);
        $res->assertSee('site-header__slogan', false);
        $res->assertSee('site-search', false);
        $res->assertSee('site-header__cta', false);
        // The old markup, whose hover-expanding field flickered without end.
        $res->assertDontSee('class="header-search"', false);
        $res->assertDontSee('middle-toolbox', false);
    }

    /** Every page carries the enquiry popup, so any CTA can open it. */
    public function test_the_enquiry_popup_is_on_every_page(): void
    {
        foreach (['/', '/kho-giao-dien.html', '/cham-soc-website.html', '/blog.html'] as $url) {
            $res = $this->get($url);
            $res->assertStatus(200);
            $res->assertSee('id="lead-modal"', false);
            $res->assertSee(route('fe.contact.advise'), false);
        }
    }

    /** The Blog category the menu links to used to be empty. */
    public function test_blog_listing_has_articles(): void
    {
        $res = $this->get('/blog.html');

        $res->assertStatus(200);
        $res->assertSee('art-card', false);

        $count = DB::table('post_catalogue_post')
            ->join('post_catalogue_language as l', 'l.post_catalogue_id', '=', 'post_catalogue_post.post_catalogue_id')
            ->where('l.canonical', 'blog')
            ->where('l.language_id', 1)
            ->count();

        $this->assertGreaterThanOrEqual(6, $count, 'blog has too few posts to judge the listing');
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
