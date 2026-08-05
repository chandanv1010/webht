<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Writes the site's Lottie animations as JSON.
 *
 * Lottie is a documented JSON format — the same thing LottieFiles hosts — so the files
 * can be authored here rather than fetched from someone else's account. That matters:
 * every animation on this site was a lottie.host URL, and when that account closed the
 * pages were left with holes. These live in the repo, on our own domain, and can be
 * opened in the LottieFiles editor later if a designer wants to redraw them.
 *
 * One file per role, matching the names the illustration component takes. Motion is
 * built from transform keyframes on shape layers — no path morphing, which is where
 * hand-authored Lottie usually goes wrong.
 *
 *     php artisan lottie:build
 */
class BuildLottie extends Command
{
    protected $signature = 'lottie:build';

    protected $description = 'Generate the self-hosted Lottie animations';

    /** Palette from the live site, as Lottie's 0..1 floats. */
    private const NAVY   = [0.008, 0.024, 0.216, 1];
    private const VIOLET = [0.514, 0.231, 1.000, 1];
    private const BLUE   = [0.110, 0.424, 0.863, 1];
    private const CORAL  = [0.988, 0.455, 0.424, 1];
    private const TEAL   = [0.208, 0.816, 0.729, 1];
    private const AMBER  = [0.961, 0.651, 0.137, 1];
    private const MIST   = [0.902, 0.925, 0.965, 1];
    private const WHITE  = [1, 1, 1, 1];

    private const W = 480;
    private const H = 360;
    private const FR = 30;

    /** Frames. 120 at 30fps is a four-second loop — long enough not to feel twitchy. */
    private const OP = 120;

    private int $ind = 0;

    public function handle(): int
    {
        $dir = public_path('frontend/resources/lottie');

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        foreach ($this->roles() as $name => $layers) {
            $this->ind = 0;
            $json = [
                'v' => '5.7.4',
                'fr' => self::FR,
                'ip' => 0,
                'op' => self::OP,
                'w' => self::W,
                'h' => self::H,
                'nm' => $name,
                'ddd' => 0,
                'assets' => [],
                'layers' => $layers(),
                'markers' => [],
            ];

            $path = $dir.'/'.$name.'.json';
            file_put_contents($path, json_encode($json, JSON_UNESCAPED_SLASHES));
            $this->line(sprintf('  %-10s %6d bytes  %d layers', $name, filesize($path), count($json['layers'])));
        }

        $this->newLine();
        $this->info('Written to public/frontend/resources/lottie/');

        return self::SUCCESS;
    }

    /* ─────────────────────────────────────────────────────────────────────
       The animations
       ───────────────────────────────────────────────────────────────────── */

    private function roles(): array
    {
        return [
            // A page being built: chrome first, then blocks dropping in, then a cursor.
            'build' => fn () => array_merge(
                [$this->cursor(300, 250, [[24, 300, 250], [46, 190, 168], [60, 190, 168], [96, 300, 250]])],
                $this->blocks(),
                [
                    $this->bar(240, 118, 300, 10, self::MIST, 14),
                    $this->bar(190, 96, 200, 10, self::BLUE, 8),
                    $this->dots(),
                    $this->frame(),
                ]
            ),

            // Arriving somewhere finished: the frame settles and a tick draws itself in.
            'welcome' => fn () => [
                $this->tick(),
                $this->pill(240, 250, 150, 34, self::VIOLET, 17, 30),
                $this->bar(240, 200, 260, 12, self::MIST, 20),
                $this->bar(240, 172, 180, 12, self::MIST, 20),
                $this->breathingFrame(),
            ],

            // Two people talking: bubbles alternate, one side then the other.
            'contact' => fn () => [
                $this->bubble(150, 150, 150, 56, self::VIOLET, 0),
                $this->bubble(330, 226, 130, 50, self::MIST, 40),
                $this->bubble(150, 292, 110, 44, self::CORAL, 80),
                $this->frame(),
            ],

            // A company growing: three bars rise to different heights and hold.
            'company' => fn () => [
                $this->growBar(170, 230, 46, 90, self::MIST, 6),
                $this->growBar(240, 230, 46, 140, self::BLUE, 14),
                $this->growBar(310, 230, 46, 110, self::VIOLET, 22),
                $this->bar(240, 296, 220, 4, self::NAVY, 2),
                $this->frame(),
            ],

            // Speed: a needle sweeps up, a bar fills behind it.
            'speed' => fn () => [
                $this->needle(),
                $this->arc(),
                $this->fillBar(),
                $this->frame(),
            ],

            // A team assembling: heads pop in one after another.
            'team' => fn () => [
                $this->head(160, 200, 44, self::VIOLET, 6),
                $this->head(240, 178, 52, self::BLUE, 20),
                $this->head(320, 200, 44, self::CORAL, 34),
                $this->bar(240, 262, 220, 10, self::MIST, 5),
                $this->frame(),
            ],

            // A process: a pulse travels along the line through four stations.
            'process' => fn () => array_merge(
                [$this->travellingDot()],
                [
                    $this->station(140, 200, 0),
                    $this->station(207, 200, 24),
                    $this->station(273, 200, 48),
                    $this->station(340, 200, 72),
                    $this->bar(240, 200, 210, 4, self::MIST, 2),
                    $this->frame(),
                ]
            ),

            // Mail: an envelope, and a message that lifts out of it and flies away.
            'email' => fn () => [
                $this->flyer(),
                $this->pill(240, 214, 120, 8, self::MIST, 4, 0),
                $this->envelope(),
                $this->frame(),
            ],

            // Support: a headset, with a ring that pulses outward as a call comes in.
            'support' => fn () => [
                $this->ring(240, 196, 0),
                $this->ring(240, 196, 40),
                $this->headset(),
                $this->frame(),
            ],

            // A domain: a globe turning under a magnifier that drifts across it.
            'domain' => fn () => [
                $this->magnifier(),
                $this->meridian(),
                $this->globe(),
                $this->frame(),
            ],
        ];
    }

    /* ─────────────────────────────────────────────────────────────────────
       Pieces
       ───────────────────────────────────────────────────────────────────── */

    /** The browser chrome every one of these sits in. */
    private function frame(): array
    {
        return $this->layer('frame', [
            $this->group([$this->rect(360, 250, 16), $this->stroke(self::NAVY, 3, 0.85)]),
            $this->group([$this->rect(360, 250, 16), $this->fill(self::WHITE, 0)]),
            $this->group([$this->rect(360, 2, 0), $this->fill(self::NAVY, 22)], [0, -84]),
        ], $this->still(240, 190));
    }

    /** The same chrome, breathing very slightly, for the pages where it is the subject. */
    private function breathingFrame(): array
    {
        $ks = $this->still(240, 190);
        $ks['s'] = $this->animArr([[0, [99, 99, 100]], [60, [101, 101, 100]], [120, [99, 99, 100]]]);

        return $this->layer('frame', [
            $this->group([$this->rect(360, 250, 16), $this->stroke(self::NAVY, 3, 0.85)]),
            $this->group([$this->rect(360, 250, 16), $this->fill(self::WHITE, 0)]),
        ], $ks);
    }

    /** Traffic lights on the chrome bar. */
    private function dots(): array
    {
        $shapes = [];
        foreach ([[-160, self::CORAL], [-146, self::AMBER], [-132, self::TEAL]] as [$x, $c]) {
            $shapes[] = $this->group([$this->ellipse(9, 9), $this->fill($c)], [$x, -84]);
        }

        return $this->layer('dots', $shapes, $this->still(240, 190));
    }

    /** Content blocks dropping in one after another. */
    private function blocks(): array
    {
        $out = [];
        foreach ([[178, 6], [240, 18], [302, 30]] as $i => [$x, $delay]) {
            $ks = $this->still($x, 240);
            $ks['p'] = $this->animPos([
                [$delay, [$x, 210]],
                [$delay + 16, [$x, 240]],
            ]);
            $ks['o'] = $this->animArr([[$delay, [0]], [$delay + 10, [100]]]);

            $out[] = $this->layer('block'.$i, [
                $this->group([$this->rect(48, 48, 8), $this->fill($i === 1 ? self::VIOLET : self::MIST)]),
            ], $ks);
        }

        return $out;
    }

    /** A pointer that moves, presses, and moves back. */
    private function cursor(int $x, int $y, array $path): array
    {
        $keys = [];
        foreach ($path as [$t, $px, $py]) {
            $keys[] = [$t, [$px, $py]];
        }

        $ks = $this->still($x, $y);
        $ks['p'] = $this->animPos($keys);
        $ks['s'] = $this->animArr([[44, [100, 100, 100]], [50, [82, 82, 100]], [58, [100, 100, 100]]]);

        return $this->layer('cursor', [
            $this->group([$this->rect(16, 16, 3), $this->fill(self::NAVY)]),
            $this->group([$this->ellipse(30, 30), $this->stroke(self::VIOLET, 2, 0.5)]),
        ], $ks);
    }

    private function bar(int $x, int $y, int $w, int $h, array $colour, int $r): array
    {
        return $this->layer('bar', [
            $this->group([$this->rect($w, $h, $r), $this->fill($colour)]),
        ], $this->still($x, $y));
    }

    /** A bar that grows from its base, like a column on a chart. */
    private function growBar(int $x, int $baseY, int $w, int $h, array $colour, int $delay): array
    {
        $ks = $this->still($x, $baseY);
        // Anchored at the bottom edge, so scaling Y grows it upward.
        $ks['a'] = ['a' => 0, 'k' => [0, $h / 2, 0]];
        $ks['p'] = ['a' => 0, 'k' => [$x, $baseY + $h / 2, 0]];
        $ks['s'] = $this->animArr([
            [$delay, [100, 4, 100]],
            [$delay + 26, [100, 108, 100]],
            [$delay + 34, [100, 100, 100]],
        ]);

        return $this->layer('col', [
            $this->group([$this->rect($w, $h, 8), $this->fill($colour)]),
        ], $ks);
    }

    private function pill(int $x, int $y, int $w, int $h, array $colour, int $r, int $delay): array
    {
        $ks = $this->still($x, $y);
        $ks['s'] = $this->animArr([
            [$delay, [70, 70, 100]],
            [$delay + 14, [104, 104, 100]],
            [$delay + 22, [100, 100, 100]],
        ]);
        $ks['o'] = $this->animArr([[$delay, [0]], [$delay + 8, [100]]]);

        return $this->layer('pill', [
            $this->group([$this->rect($w, $h, $r), $this->fill($colour)]),
        ], $ks);
    }

    /** A tick that scales in with a slight overshoot. */
    private function tick(): array
    {
        $ks = $this->still(240, 130);
        $ks['s'] = $this->animArr([
            [34, [0, 0, 100]],
            [50, [116, 116, 100]],
            [60, [100, 100, 100]],
        ]);
        $ks['r'] = $this->animScalar([[34, [-30]], [56, [0]]]);

        return $this->layer('tick', [
            $this->group([$this->ellipse(64, 64), $this->fill(self::TEAL)]),
            $this->group([$this->rect(26, 5, 3), $this->fill(self::WHITE)], [-4, 4], -45),
            $this->group([$this->rect(5, 14, 3), $this->fill(self::WHITE)], [-12, 0], -45),
        ], $ks);
    }

    /** A chat bubble that pops in, waits, and fades. */
    private function bubble(int $x, int $y, int $w, int $h, array $colour, int $delay): array
    {
        $ks = $this->still($x, $y);
        $ks['s'] = $this->animArr([
            [$delay, [60, 60, 100]],
            [$delay + 12, [104, 104, 100]],
            [$delay + 18, [100, 100, 100]],
        ]);
        $ks['o'] = $this->animArr([
            [$delay, [0]],
            [$delay + 8, [100]],
            [$delay + 74, [100]],
            [$delay + 86, [0]],
        ]);

        return $this->layer('bubble', [
            $this->group([$this->rect($w, $h, 14), $this->fill($colour)]),
            $this->group([$this->rect($w - 54, 6, 3), $this->fill(self::WHITE, 65)], [-8, -6]),
            $this->group([$this->rect($w - 84, 6, 3), $this->fill(self::WHITE, 45)], [-23, 10]),
        ], $ks);
    }

    /** The gauge needle. */
    private function needle(): array
    {
        $ks = $this->still(240, 236);
        $ks['r'] = $this->animScalar([
            [8, [-72]],
            [50, [58]],
            [66, [42]],
            [96, [48]],
            [120, [-72]],
        ]);

        return $this->layer('needle', [
            $this->group([$this->rect(6, 84, 3), $this->fill(self::CORAL)], [0, -42]),
            $this->group([$this->ellipse(20, 20), $this->fill(self::NAVY)]),
        ], $ks);
    }

    /** The gauge's dial, drawn as a stroked circle with the lower part hidden. */
    private function arc(): array
    {
        return $this->layer('arc', [
            $this->group([$this->ellipse(180, 180), $this->stroke(self::MIST, 14)]),
            $this->group([$this->rect(200, 60, 0), $this->fill(self::WHITE)], [0, 62]),
        ], $this->still(240, 236));
    }

    /** A progress bar that fills as the needle sweeps. */
    private function fillBar(): array
    {
        $ks = $this->still(240, 292);
        $ks['a'] = ['a' => 0, 'k' => [-105, 0, 0]];
        $ks['p'] = ['a' => 0, 'k' => [135, 292, 0]];
        $ks['s'] = $this->animArr([
            [8, [4, 100, 100]],
            [56, [100, 100, 100]],
            [96, [100, 100, 100]],
            [120, [4, 100, 100]],
        ]);

        return $this->layer('fill', [
            $this->group([$this->rect(210, 10, 5), $this->fill(self::TEAL)]),
        ], $ks);
    }

    /** A head and shoulders that pops in. */
    private function head(int $x, int $y, int $size, array $colour, int $delay): array
    {
        $ks = $this->still($x, $y);
        $ks['s'] = $this->animArr([
            [$delay, [0, 0, 100]],
            [$delay + 14, [112, 112, 100]],
            [$delay + 22, [100, 100, 100]],
        ]);

        return $this->layer('head', [
            $this->group([$this->ellipse($size, $size), $this->fill($colour)]),
            $this->group([$this->rect($size + 14, $size * 0.7, $size / 2), $this->fill($colour, 55)], [0, $size * 0.78]),
        ], $ks);
    }

    /** A station on the process line. */
    private function station(int $x, int $y, int $delay): array
    {
        $ks = $this->still($x, $y);
        $ks['s'] = $this->animArr([
            [$delay, [100, 100, 100]],
            [$delay + 10, [136, 136, 100]],
            [$delay + 22, [100, 100, 100]],
        ]);

        return $this->layer('station', [
            $this->group([$this->ellipse(22, 22), $this->fill(self::WHITE)]),
            $this->group([$this->ellipse(22, 22), $this->stroke(self::BLUE, 3)]),
        ], $ks);
    }

    /** The pulse that runs along the process line. */
    private function travellingDot(): array
    {
        $ks = $this->still(140, 200);
        $ks['p'] = $this->animPos([
            [0, [140, 200]],
            [24, [207, 200]],
            [48, [273, 200]],
            [72, [340, 200]],
            [96, [340, 200]],
            [120, [140, 200]],
        ]);
        $ks['o'] = $this->animArr([[96, [100]], [106, [0]], [118, [0]], [120, [100]]]);

        return $this->layer('pulse', [
            $this->group([$this->ellipse(12, 12), $this->fill(self::CORAL)]),
        ], $ks);
    }

    /** An envelope. */
    private function envelope(): array
    {
        return $this->layer('envelope', [
            $this->group([$this->rect(180, 116, 12), $this->fill(self::BLUE)]),
            $this->group([$this->rect(120, 4, 2), $this->fill(self::WHITE, 45)], [0, 22]),
            $this->group([$this->rect(150, 4, 2), $this->fill(self::WHITE, 30)], [0, 36]),
        ], $this->still(240, 244));
    }

    /** A message that lifts out of the envelope and flies off. */
    private function flyer(): array
    {
        $ks = $this->still(240, 244);
        $ks['p'] = $this->animPos([
            [10, [240, 244]],
            [46, [240, 168]],
            [86, [352, 116]],
            [120, [240, 244]],
        ]);
        $ks['o'] = $this->animArr([[10, [0]], [24, [100]], [70, [100]], [86, [0]], [119, [0]]]);
        $ks['r'] = $this->animScalar([[10, [0]], [46, [0]], [86, [22]], [120, [0]]]);

        return $this->layer('flyer', [
            $this->group([$this->rect(96, 64, 8), $this->fill(self::WHITE)]),
            $this->group([$this->rect(96, 64, 8), $this->stroke(self::NAVY, 2.5, 0.8)]),
            $this->group([$this->rect(56, 4, 2), $this->fill(self::CORAL)], [-12, -10]),
            $this->group([$this->rect(38, 4, 2), $this->fill(self::MIST)], [-21, 2]),
        ], $ks);
    }

    /** A headset: band, two cups, a mic arm. */
    private function headset(): array
    {
        return $this->layer('headset', [
            $this->group([$this->ellipse(150, 150), $this->stroke(self::NAVY, 12)]),
            $this->group([$this->rect(180, 80, 0), $this->fill(self::WHITE)], [0, 56]),
            $this->group([$this->rect(34, 56, 16), $this->fill(self::VIOLET)], [-72, 22]),
            $this->group([$this->rect(34, 56, 16), $this->fill(self::VIOLET)], [72, 22]),
            $this->group([$this->rect(6, 46, 3), $this->fill(self::NAVY)], [72, 66]),
            $this->group([$this->rect(46, 6, 3), $this->fill(self::NAVY)], [50, 88]),
            $this->group([$this->ellipse(18, 18), $this->fill(self::CORAL)], [24, 88]),
        ], $this->still(240, 196));
    }

    /** A ring that expands outward and fades, like a call arriving. */
    private function ring(int $x, int $y, int $delay): array
    {
        $ks = $this->still($x, $y);
        $ks['s'] = $this->animArr([
            [$delay, [70, 70, 100]],
            [$delay + 70, [150, 150, 100]],
        ]);
        $ks['o'] = $this->animArr([
            [$delay, [0]],
            [$delay + 12, [55]],
            [$delay + 70, [0]],
        ]);

        return $this->layer('ring', [
            $this->group([$this->ellipse(190, 190), $this->stroke(self::VIOLET, 3)]),
        ], $ks);
    }

    /** A globe. */
    private function globe(): array
    {
        return $this->layer('globe', [
            $this->group([$this->ellipse(168, 168), $this->fill(self::MIST, 55)]),
            $this->group([$this->ellipse(168, 168), $this->stroke(self::NAVY, 3, 0.8)]),
            $this->group([$this->rect(160, 3, 2), $this->fill(self::NAVY, 30)]),
        ], $this->still(220, 190));
    }

    /** The meridian, squashed and stretched so the globe reads as turning. */
    private function meridian(): array
    {
        $ks = $this->still(220, 190);
        $ks['s'] = $this->animArr([
            [0, [14, 100, 100]],
            [30, [96, 100, 100]],
            [60, [14, 100, 100]],
            [90, [96, 100, 100]],
            [120, [14, 100, 100]],
        ]);

        return $this->layer('meridian', [
            $this->group([$this->ellipse(168, 168), $this->stroke(self::BLUE, 3, 0.65)]),
        ], $ks);
    }

    /** A magnifier drifting across the globe. */
    private function magnifier(): array
    {
        $ks = $this->still(286, 236);
        $ks['p'] = $this->animPos([
            [0, [286, 236]],
            [40, [250, 258]],
            [80, [304, 214]],
            [120, [286, 236]],
        ]);

        return $this->layer('magnifier', [
            $this->group([$this->ellipse(74, 74), $this->fill(self::WHITE, 88)]),
            $this->group([$this->ellipse(74, 74), $this->stroke(self::NAVY, 6)]),
            $this->group([$this->rect(10, 44, 5), $this->fill(self::NAVY)], [30, 34], -45),
        ], $ks);
    }

    /* ─────────────────────────────────────────────────────────────────────
       Lottie building blocks
       ───────────────────────────────────────────────────────────────────── */

    /** One shape layer. */
    private function layer(string $name, array $shapes, array $ks): array
    {
        return [
            'ddd' => 0,
            'ind' => ++$this->ind,
            'ty' => 4,
            'nm' => $name,
            'sr' => 1,
            'ks' => $ks,
            'ao' => 0,
            // Reversed: in Lottie the first shape paints on top, the opposite of SVG. The
            // pieces above are written in SVG order — later means in front — so the mask
            // rects and the details on top of them land the right way round.
            'shapes' => array_reverse($shapes),
            'ip' => 0,
            'op' => self::OP,
            'st' => 0,
            'bm' => 0,
        ];
    }

    /** A group: the drawn shape, its paint, and the group's own transform. */
    private function group(array $items, array $offset = [0, 0], float $rotate = 0): array
    {
        return [
            'ty' => 'gr',
            'it' => array_merge($items, [[
                'ty' => 'tr',
                'p' => ['a' => 0, 'k' => $offset],
                'a' => ['a' => 0, 'k' => [0, 0]],
                's' => ['a' => 0, 'k' => [100, 100]],
                'r' => ['a' => 0, 'k' => $rotate],
                'o' => ['a' => 0, 'k' => 100],
                'sk' => ['a' => 0, 'k' => 0],
                'sa' => ['a' => 0, 'k' => 0],
            ]]),
            'nm' => 'g',
        ];
    }

    private function rect(float $w, float $h, float $r): array
    {
        return [
            'ty' => 'rc',
            'd' => 1,
            's' => ['a' => 0, 'k' => [$w, $h]],
            'p' => ['a' => 0, 'k' => [0, 0]],
            'r' => ['a' => 0, 'k' => $r],
        ];
    }

    private function ellipse(float $w, float $h): array
    {
        return [
            'ty' => 'el',
            'd' => 1,
            's' => ['a' => 0, 'k' => [$w, $h]],
            'p' => ['a' => 0, 'k' => [0, 0]],
        ];
    }

    private function fill(array $colour, float $opacity = 100): array
    {
        return [
            'ty' => 'fl',
            'c' => ['a' => 0, 'k' => $colour],
            'o' => ['a' => 0, 'k' => $opacity],
            'r' => 1,
        ];
    }

    private function stroke(array $colour, float $width, float $alpha = 1): array
    {
        return [
            'ty' => 'st',
            'c' => ['a' => 0, 'k' => $colour],
            'o' => ['a' => 0, 'k' => $alpha * 100],
            'w' => ['a' => 0, 'k' => $width],
            'lc' => 2,
            'lj' => 2,
        ];
    }

    /** A layer transform that does not move. */
    private function still(float $x, float $y): array
    {
        return [
            'o' => ['a' => 0, 'k' => 100],
            'r' => ['a' => 0, 'k' => 0],
            'p' => ['a' => 0, 'k' => [$x, $y, 0]],
            'a' => ['a' => 0, 'k' => [0, 0, 0]],
            's' => ['a' => 0, 'k' => [100, 100, 100]],
        ];
    }

    /**
     * Keyframes for a position. Eased both sides so nothing starts or stops abruptly —
     * the complaint about the rest of the site was exactly that.
     */
    private function animPos(array $keys): array
    {
        $out = [];
        $last = count($keys) - 1;

        foreach ($keys as $i => [$t, $value]) {
            $frame = ['t' => $t, 's' => [$value[0], $value[1], 0]];
            if ($i < $last) {
                $frame['i'] = ['x' => 0.35, 'y' => 1];
                $frame['o'] = ['x' => 0.35, 'y' => 0];
            }
            $out[] = $frame;
        }

        return ['a' => 1, 'k' => $out];
    }

    /** Keyframes for a multi-value property: scale, or an rgba. */
    private function animArr(array $keys): array
    {
        $out = [];
        $last = count($keys) - 1;

        foreach ($keys as $i => [$t, $value]) {
            $n = count($value);
            $frame = ['t' => $t, 's' => $value];
            if ($i < $last) {
                $frame['i'] = ['x' => array_fill(0, $n, 0.35), 'y' => array_fill(0, $n, 1)];
                $frame['o'] = ['x' => array_fill(0, $n, 0.35), 'y' => array_fill(0, $n, 0)];
            }
            $out[] = $frame;
        }

        return ['a' => 1, 'k' => $out];
    }

    /** Keyframes for rotation. */
    private function animScalar(array $keys): array
    {
        return $this->animArr($keys);
    }
}
