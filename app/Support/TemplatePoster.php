<?php

namespace App\Support;

/**
 * Generates a preview image for a template in the store.
 *
 * These stand in for real homepage screenshots. Screenshots of other people's
 * websites are their copyright, and stock photography is the wrong kind of content
 * for a store whose whole product is website layouts — so each poster is a drawn
 * mock of a homepage instead: browser chrome, a nav bar, a hero, and whatever
 * arrangement of content the category actually implies.
 *
 * Drop a real screenshot at public/userfiles/image/template-cover/<canonical>.(jpg|png|webp)
 * and the seeder uses that instead.
 */
class TemplatePoster
{
    /** Wide enough to read as a browser window at card size. */
    private const W = 1200;
    private const H = 750;

    /**
     * @param  string $archetype  ecommerce|corporate|landing|realestate|education|admin
     */
    public static function svg(string $title, string $archetype, string $accent, int $seed): string
    {
        $body = match ($archetype) {
            'ecommerce' => self::ecommerce($accent, $seed),
            'corporate' => self::corporate($accent, $seed),
            'landing' => self::landing($accent, $seed),
            'realestate' => self::realestate($accent, $seed),
            'education' => self::education($accent, $seed),
            default => self::admin($accent, $seed),
        };

        $chrome = self::chrome($title);

        return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 '.self::W.' '.self::H.'"'
            .' width="'.self::W.'" height="'.self::H.'" role="img" aria-label="'.self::esc($title).'">'
            .'<rect width="'.self::W.'" height="'.self::H.'" fill="#ffffff"/>'
            .$body
            .$chrome
            .'</svg>';
    }

    /** Browser bar drawn last so it always sits above the page content. */
    private static function chrome(string $title): string
    {
        return '<g>'
            .'<rect x="0" y="0" width="'.self::W.'" height="44" fill="#101433"/>'
            .'<circle cx="28" cy="22" r="6" fill="#fc746c"/>'
            .'<circle cx="50" cy="22" r="6" fill="#f5c451"/>'
            .'<circle cx="72" cy="22" r="6" fill="#35d0ba"/>'
            .'<rect x="100" y="12" width="'.(self::W - 140).'" height="20" rx="10" fill="#ffffff" opacity="0.1"/>'
            .'<text x="116" y="27" font-family="Manrope, Arial, sans-serif" font-size="12" fill="#ffffff" opacity="0.5">'
            .self::esc(mb_strimwidth($title, 0, 64, '…')).'</text>'
            .'</g>';
    }

    /** Nav bar every archetype shares, so the family reads as one system. */
    private static function nav(string $accent, bool $dark = false): string
    {
        $ink = $dark ? '#ffffff' : '#101433';
        $o = $dark ? '0.75' : '0.5';

        $links = '';
        foreach ([0, 1, 2, 3] as $i) {
            $links .= '<rect x="'.(430 + $i * 96).'" y="76" width="'.(56 + ($i % 2) * 16).'" height="9" rx="4.5" fill="'.$ink.'" opacity="'.$o.'"/>';
        }

        return '<rect x="0" y="44" width="'.self::W.'" height="72" fill="'.($dark ? 'none' : '#ffffff').'"/>'
            .'<rect x="56" y="68" width="112" height="24" rx="6" fill="'.$accent.'"/>'
            .$links
            .'<rect x="1000" y="66" width="144" height="30" rx="15" fill="'.$accent.'"/>';
    }

    private static function ecommerce(string $accent, int $seed): string
    {
        // Banner, then a product grid — what a shop homepage is.
        $s = '<rect x="0" y="44" width="'.self::W.'" height="'.self::H.'" fill="#f7f8fc"/>'
            .self::nav($accent);

        $s .= '<rect x="56" y="140" width="1088" height="190" rx="14" fill="'.$accent.'" opacity="0.14"/>'
            .'<rect x="96" y="176" width="300" height="26" rx="13" fill="#101433" opacity="0.8"/>'
            .'<rect x="96" y="216" width="420" height="13" rx="6.5" fill="#101433" opacity="0.32"/>'
            .'<rect x="96" y="240" width="340" height="13" rx="6.5" fill="#101433" opacity="0.24"/>'
            .'<rect x="96" y="276" width="150" height="34" rx="17" fill="'.$accent.'"/>'
            .'<rect x="760" y="164" width="344" height="146" rx="12" fill="'.$accent.'" opacity="0.3"/>';

        for ($i = 0; $i < 4; $i++) {
            $x = 56 + $i * 278;
            $s .= '<rect x="'.$x.'" y="366" width="254" height="300" rx="12" fill="#ffffff"/>'
                .'<rect x="'.$x.'" y="366" width="254" height="180" rx="12" fill="'.$accent.'" opacity="'.(0.3 - $i * 0.05).'"/>'
                .'<rect x="'.($x + 20).'" y="568" width="150" height="12" rx="6" fill="#101433" opacity="0.6"/>'
                .'<rect x="'.($x + 20).'" y="592" width="96" height="12" rx="6" fill="#101433" opacity="0.24"/>'
                .'<rect x="'.($x + 20).'" y="624" width="80" height="20" rx="10" fill="'.$accent.'"/>';
        }

        return $s;
    }

    private static function corporate(string $accent, int $seed): string
    {
        $s = '<rect x="0" y="44" width="'.self::W.'" height="'.self::H.'" fill="#ffffff"/>'
            .self::nav($accent);

        // Split hero: statement left, image right.
        $s .= '<rect x="56" y="168" width="470" height="34" rx="8" fill="#101433" opacity="0.85"/>'
            .'<rect x="56" y="216" width="380" height="34" rx="8" fill="#101433" opacity="0.85"/>'
            .'<rect x="56" y="278" width="430" height="13" rx="6.5" fill="#101433" opacity="0.3"/>'
            .'<rect x="56" y="302" width="360" height="13" rx="6.5" fill="#101433" opacity="0.3"/>'
            .'<rect x="56" y="344" width="164" height="38" rx="19" fill="'.$accent.'"/>'
            .'<rect x="236" y="344" width="130" height="38" rx="19" fill="none" stroke="#101433" stroke-opacity="0.2" stroke-width="2"/>'
            .'<rect x="608" y="152" width="536" height="288" rx="16" fill="'.$accent.'" opacity="0.16"/>'
            .'<rect x="648" y="196" width="200" height="14" rx="7" fill="'.$accent.'" opacity="0.7"/>'
            .'<rect x="648" y="228" width="360" height="10" rx="5" fill="#101433" opacity="0.18"/>'
            .'<rect x="648" y="252" width="300" height="10" rx="5" fill="#101433" opacity="0.18"/>';

        for ($i = 0; $i < 3; $i++) {
            $x = 56 + $i * 372;
            $s .= '<rect x="'.$x.'" y="492" width="348" height="176" rx="14" fill="#f7f8fc"/>'
                .'<circle cx="'.($x + 44).'" cy="536" r="20" fill="'.$accent.'" opacity="'.(0.85 - $i * 0.22).'"/>'
                .'<rect x="'.($x + 28).'" y="576" width="180" height="13" rx="6.5" fill="#101433" opacity="0.6"/>'
                .'<rect x="'.($x + 28).'" y="602" width="280" height="10" rx="5" fill="#101433" opacity="0.2"/>'
                .'<rect x="'.($x + 28).'" y="622" width="230" height="10" rx="5" fill="#101433" opacity="0.2"/>';
        }

        return $s;
    }

    private static function landing(string $accent, int $seed): string
    {
        // One screen, one goal: headline, form, trust logos.
        $s = '<rect x="0" y="44" width="'.self::W.'" height="'.self::H.'" fill="#101433"/>'
            .self::nav($accent, true);

        $s .= '<rect x="140" y="182" width="620" height="38" rx="9" fill="#ffffff" opacity="0.92"/>'
            .'<rect x="140" y="236" width="470" height="38" rx="9" fill="#ffffff" opacity="0.92"/>'
            .'<rect x="140" y="302" width="440" height="13" rx="6.5" fill="#ffffff" opacity="0.4"/>'
            .'<rect x="140" y="326" width="360" height="13" rx="6.5" fill="#ffffff" opacity="0.4"/>'
            // Signup card
            .'<rect x="760" y="176" width="384" height="248" rx="16" fill="#ffffff"/>'
            .'<rect x="792" y="212" width="180" height="14" rx="7" fill="#101433" opacity="0.75"/>'
            .'<rect x="792" y="248" width="320" height="36" rx="8" fill="#101433" opacity="0.07"/>'
            .'<rect x="792" y="296" width="320" height="36" rx="8" fill="#101433" opacity="0.07"/>'
            .'<rect x="792" y="352" width="320" height="42" rx="21" fill="'.$accent.'"/>';

        for ($i = 0; $i < 5; $i++) {
            $s .= '<rect x="'.(140 + $i * 148).'" y="470" width="104" height="26" rx="6" fill="#ffffff" opacity="0.16"/>';
        }

        $s .= '<rect x="140" y="556" width="1004" height="112" rx="14" fill="#ffffff" opacity="0.06"/>'
            .'<rect x="180" y="592" width="240" height="14" rx="7" fill="#ffffff" opacity="0.5"/>'
            .'<rect x="180" y="620" width="420" height="10" rx="5" fill="#ffffff" opacity="0.28"/>';

        return $s;
    }

    private static function realestate(string $accent, int $seed): string
    {
        $s = '<rect x="0" y="44" width="'.self::W.'" height="'.self::H.'" fill="#f7f8fc"/>'
            .self::nav($accent);

        // Hero with the search bar that every listing site leads with.
        $s .= '<rect x="56" y="140" width="1088" height="216" rx="14" fill="'.$accent.'" opacity="0.2"/>'
            .'<rect x="104" y="184" width="380" height="28" rx="8" fill="#101433" opacity="0.78"/>'
            .'<rect x="104" y="252" width="992" height="60" rx="12" fill="#ffffff"/>'
            .'<rect x="128" y="270" width="200" height="24" rx="6" fill="#101433" opacity="0.1"/>'
            .'<rect x="352" y="270" width="200" height="24" rx="6" fill="#101433" opacity="0.1"/>'
            .'<rect x="576" y="270" width="200" height="24" rx="6" fill="#101433" opacity="0.1"/>'
            .'<rect x="932" y="266" width="140" height="32" rx="16" fill="'.$accent.'"/>';

        for ($i = 0; $i < 3; $i++) {
            $x = 56 + $i * 372;
            $s .= '<rect x="'.$x.'" y="396" width="348" height="272" rx="14" fill="#ffffff"/>'
                .'<rect x="'.$x.'" y="396" width="348" height="160" rx="14" fill="'.$accent.'" opacity="'.(0.32 - $i * 0.06).'"/>'
                .'<rect x="'.($x + 20).'" y="452" width="76" height="22" rx="11" fill="'.$accent.'"/>'
                .'<rect x="'.($x + 24).'" y="580" width="220" height="14" rx="7" fill="#101433" opacity="0.62"/>'
                .'<rect x="'.($x + 24).'" y="606" width="150" height="10" rx="5" fill="#101433" opacity="0.22"/>'
                .'<rect x="'.($x + 24).'" y="632" width="110" height="18" rx="9" fill="#35d0ba"/>';
        }

        return $s;
    }

    private static function education(string $accent, int $seed): string
    {
        $s = '<rect x="0" y="44" width="'.self::W.'" height="'.self::H.'" fill="#ffffff"/>'
            .self::nav($accent);

        $s .= '<rect x="0" y="116" width="'.self::W.'" height="252" fill="'.$accent.'" opacity="0.12"/>'
            .'<rect x="56" y="176" width="420" height="32" rx="8" fill="#101433" opacity="0.82"/>'
            .'<rect x="56" y="224" width="330" height="32" rx="8" fill="#101433" opacity="0.82"/>'
            .'<rect x="56" y="286" width="180" height="38" rx="19" fill="'.$accent.'"/>'
            .'<circle cx="900" cy="242" r="98" fill="'.$accent.'" opacity="0.3"/>'
            .'<circle cx="1040" cy="200" r="52" fill="#f5c451" opacity="0.55"/>';

        for ($i = 0; $i < 3; $i++) {
            $x = 56 + $i * 372;
            $s .= '<rect x="'.$x.'" y="416" width="348" height="252" rx="14" fill="#f7f8fc"/>'
                .'<rect x="'.$x.'" y="416" width="348" height="132" rx="14" fill="'.$accent.'" opacity="'.(0.3 - $i * 0.06).'"/>'
                .'<rect x="'.($x + 24).'" y="576" width="90" height="20" rx="10" fill="'.$accent.'" opacity="0.9"/>'
                .'<rect x="'.($x + 24).'" y="610" width="240" height="13" rx="6.5" fill="#101433" opacity="0.58"/>'
                .'<rect x="'.($x + 24).'" y="636" width="170" height="10" rx="5" fill="#101433" opacity="0.2"/>';
        }

        return $s;
    }

    private static function admin(string $accent, int $seed): string
    {
        // Sidebar + topbar + chart: what an admin dashboard template is.
        $s = '<rect x="0" y="44" width="'.self::W.'" height="'.self::H.'" fill="#f4f6fb"/>'
            .'<rect x="0" y="44" width="248" height="'.(self::H - 44).'" fill="#101433"/>'
            .'<rect x="32" y="84" width="150" height="18" rx="9" fill="'.$accent.'"/>';

        for ($i = 0; $i < 6; $i++) {
            $s .= '<rect x="32" y="'.(140 + $i * 44).'" width="'.(160 - ($i % 3) * 26).'" height="12" rx="6" fill="#ffffff" opacity="'.($i === 1 ? '0.85' : '0.24').'"/>';
        }

        $s .= '<rect x="248" y="44" width="952" height="68" fill="#ffffff"/>'
            .'<rect x="288" y="68" width="200" height="20" rx="10" fill="#101433" opacity="0.14"/>'
            .'<circle cx="1128" cy="78" r="18" fill="'.$accent.'" opacity="0.85"/>';

        for ($i = 0; $i < 3; $i++) {
            $x = 288 + $i * 300;
            $s .= '<rect x="'.$x.'" y="148" width="276" height="112" rx="12" fill="#ffffff"/>'
                .'<rect x="'.($x + 24).'" y="176" width="80" height="10" rx="5" fill="#101433" opacity="0.24"/>'
                .'<rect x="'.($x + 24).'" y="200" width="130" height="24" rx="6" fill="'.$accent.'" opacity="'.(0.9 - $i * 0.25).'"/>';
        }

        // Bar chart on a baseline, plus a side panel.
        $s .= '<rect x="288" y="292" width="576" height="376" rx="14" fill="#ffffff"/>';
        $base = 610;
        for ($i = 0; $i < 7; $i++) {
            $h = 60 + (($seed + $i * 3) % 5) * 42;
            $s .= '<rect x="'.(328 + $i * 74).'" y="'.($base - $h).'" width="44" height="'.$h.'" rx="6" fill="'.$accent.'" opacity="'.(0.35 + ($i % 3) * 0.22).'"/>';
        }
        $s .= '<rect x="328" y="'.$base.'" width="496" height="2" fill="#101433" opacity="0.12"/>';

        $s .= '<rect x="888" y="292" width="272" height="376" rx="14" fill="#ffffff"/>';
        for ($i = 0; $i < 5; $i++) {
            $s .= '<circle cx="920" cy="'.(336 + $i * 62).'" r="14" fill="'.$accent.'" opacity="'.(0.8 - $i * 0.13).'"/>'
                .'<rect x="948" y="'.(329 + $i * 62).'" width="'.(170 - ($i % 3) * 34).'" height="10" rx="5" fill="#101433" opacity="0.2"/>';
        }

        return $s;
    }

    private static function esc(string $s): string
    {
        return htmlspecialchars($s, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }
}
