<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * The animations are ours and they are served from here.
 *
 * Every animation on this site used to be a lottie.host URL. That account closed and each
 * one became a blank hole in a layout built around it. These tests hold the replacement to
 * the property that matters: the player and the JSON are both in this repo, the JSON is
 * valid, and the static drawing underneath still ships so a failure is never a hole again.
 */
class LottieTest extends TestCase
{
    use DatabaseTransactions;

    /** Every role the illustration component can be asked for. */
    private const ROLES = [
        'build', 'welcome', 'contact', 'company', 'speed',
        'team', 'process', 'email', 'support', 'domain',
    ];

    public function test_every_role_has_an_animation_file(): void
    {
        foreach (self::ROLES as $role) {
            $path = public_path('frontend/resources/lottie/'.$role.'.json');
            $this->assertFileExists($path, "no animation for role {$role}");
        }
    }

    /** Valid Lottie, with the fields the player actually reads. */
    public function test_the_animations_are_valid_lottie(): void
    {
        foreach (self::ROLES as $role) {
            $json = json_decode(file_get_contents(public_path('frontend/resources/lottie/'.$role.'.json')), true);

            $this->assertIsArray($json, "{$role}.json is not valid JSON");

            foreach (['v', 'fr', 'ip', 'op', 'w', 'h', 'layers'] as $key) {
                $this->assertArrayHasKey($key, $json, "{$role}.json is missing {$key}");
            }

            $this->assertGreaterThan(0, $json['op'], "{$role} has no duration");
            $this->assertNotEmpty($json['layers'], "{$role} has no layers");

            foreach ($json['layers'] as $i => $layer) {
                $this->assertSame(4, $layer['ty'], "{$role} layer {$i} is not a shape layer");
                $this->assertArrayHasKey('ks', $layer, "{$role} layer {$i} has no transform");
                $this->assertNotEmpty($layer['shapes'], "{$role} layer {$i} draws nothing");
            }
        }
    }

    /** At least one animation actually animates, or these are just static SVG in JSON. */
    public function test_the_animations_have_keyframes(): void
    {
        foreach (self::ROLES as $role) {
            $raw = file_get_contents(public_path('frontend/resources/lottie/'.$role.'.json'));
            $this->assertStringContainsString('"a":1', $raw, "{$role} has no animated property");
        }
    }

    /** The player is vendored. A CDN is the failure we are recovering from. */
    public function test_the_player_is_self_hosted(): void
    {
        $path = public_path('frontend/resources/vendor/lottie_light.min.js');

        $this->assertFileExists($path, 'the lottie player is not vendored');
        $this->assertGreaterThan(50_000, filesize($path), 'the vendored player looks truncated');
    }

    /**
     * The page ships the static drawing as well as the animation, and points at our own
     * domain for both.
     */
    public function test_a_page_ships_the_fallback_and_no_external_animation_host(): void
    {
        $res = $this->get('/dich-vu-hosting.html');

        $res->assertStatus(200);
        // The animation source, on our own host.
        $res->assertSee('frontend/resources/lottie/', false);
        // And the drawing that shows if it never loads.
        $res->assertSee('illus__fallback', false);
        // The host that took the old ones away.
        $res->assertDontSee('lottie.host', false);
        $res->assertDontSee('lottiefiles.com', false);
    }
}
