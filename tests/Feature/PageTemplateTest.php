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
     * Each service is its own landing page now, following the layout of the hosting page
     * the client asked to keep: hero, three promises, the offer as cards, an enquiry.
     * The earlier post-driven article layout is gone.
     */
    public function test_a_service_page_renders_its_landing(): void
    {
        $res = $this->get('/cham-soc-website.html');

        $res->assertStatus(200);
        $res->assertSee('service-landing', false);
        $res->assertSee('hosting-element-title', false);
        // The offer, and a button that opens the shared enquiry popup rather than a link
        // to somewhere else.
        $res->assertSee('hosting-item', false);
        $res->assertSee('data-lead-open', false);
        // Leftovers from the furniture theme.
        $res->assertDontSee('showroom-system', false);
    }

    /** All four services, plus the two the footer menu lists, have to render. */
    public function test_every_service_landing_resolves(): void
    {
        foreach ([
            'thiet-ke-theo-yeu-cau',
            'thiet-ke-website-theo-mau-co-san',
            'cham-soc-website',
            'dich-vu-seo',
        ] as $canonical) {
            $res = $this->get('/'.$canonical.'.html');
            $res->assertStatus(200);
            $res->assertSee('service-landing', false);
        }

        // The hosting page keeps its own hand-built view.
        $res = $this->get('/dich-vu-hosting.html');
        $res->assertStatus(200);
        $res->assertSee('panel-search-domain', false);
    }

    /** Every landing states a price. A service page with no number is a brochure. */
    public function test_a_service_landing_states_prices(): void
    {
        $res = $this->get('/cham-soc-website.html');

        $res->assertStatus(200);
        $res->assertSee('600.000đ', false);
        $res->assertSee('3.500.000đ', false);
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
