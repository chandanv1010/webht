{{--
    Self-hosted illustrations, one shared visual system.

    Replaces the lottie.host animations, which all returned 403 once that account
    was closed and left large blank holes in the hero and section layouts. These are
    inline SVG with CSS animation: nothing to fetch, nothing that can expire.

    The family is deliberately drawn as schematic browser frames and wireframe
    blocks — this is a company that builds websites, so its own material is the
    subject. Palette is taken from the live site: navy #020637 structure, violet
    #833bff/#ac1de1 primary, coral #fc746c and teal #35d0ba accents.

    Usage: @include('frontend.component.illustration', ['name' => 'build'])
    Names: build welcome contact company speed team process email support domain
--}}
@php
    $name = $name ?? 'build';
@endphp

{{-- Colours live in illustration.css, not in gradient defs here: an <svg> included
     many times per page would need a unique gradient id each time, and flat fills
     read better against the line-art anyway. --}}
<div class="illus illus--{{ $name }}" aria-hidden="true">
<svg viewBox="0 0 480 360" role="presentation" focusable="false">
    @switch($name)

        {{-- Website being built: chrome, blocks landing one after another, cursor. --}}
        @case('build')
            <rect class="il-frame" x="54" y="52" width="372" height="256" rx="16"/>
            <path class="il-line" d="M54 92h372"/>
            <circle class="il-dot il-dot--1" cx="80" cy="72" r="5"/>
            <circle class="il-dot il-dot--2" cx="98" cy="72" r="5"/>
            <circle class="il-dot il-dot--3" cx="116" cy="72" r="5"/>
            <rect class="il-block il-in-1" x="78" y="112" width="150" height="76" rx="8"/>
            <rect class="il-block il-block--v il-in-2" x="244" y="112" width="158" height="34" rx="6"/>
            <rect class="il-block il-in-3" x="244" y="158" width="112" height="12" rx="6"/>
            <rect class="il-block il-in-4" x="244" y="176" width="158" height="12" rx="6"/>
            <rect class="il-block il-in-5" x="78" y="206" width="98" height="60" rx="8"/>
            <rect class="il-block il-in-6" x="188" y="206" width="98" height="60" rx="8"/>
            <rect class="il-block il-block--w il-in-7" x="298" y="206" width="104" height="60" rx="8"/>
            <path class="il-cursor" d="M352 250l0 26 7-7 5 12 6-3-5-12 10-1z"/>
        @break

        {{-- Welcome: layered pages sliding forward, a spark on the top one. --}}
        @case('welcome')
            <rect class="il-frame il-frame--ghost il-drift-3" x="112" y="60" width="300" height="196" rx="14"/>
            <rect class="il-frame il-frame--ghost il-drift-2" x="94" y="80" width="300" height="196" rx="14"/>
            <rect class="il-frame il-surface il-drift-1" x="72" y="100" width="300" height="196" rx="14"/>
            <path class="il-line" d="M72 134h300"/>
            <circle class="il-dot il-dot--1" cx="96" cy="117" r="5"/>
            <circle class="il-dot il-dot--2" cx="114" cy="117" r="5"/>
            <rect class="il-block il-block--v" x="98" y="156" width="120" height="14" rx="7"/>
            <rect class="il-block" x="98" y="180" width="200" height="10" rx="5"/>
            <rect class="il-block" x="98" y="198" width="164" height="10" rx="5"/>
            <rect class="il-block il-block--w" x="98" y="228" width="94" height="32" rx="16"/>
            <g class="il-spark">
                <path d="M382 78l6 18 18 6-18 6-6 18-6-18-18-6 18-6z"/>
            </g>
        @break

        {{-- Contact: message going out, replies coming back. --}}
        @case('contact')
            <rect class="il-frame il-surface" x="66" y="68" width="230" height="176" rx="14"/>
            <path class="il-line" d="M66 102h230"/>
            <rect class="il-block il-block--v" x="90" y="124" width="104" height="12" rx="6"/>
            <rect class="il-block" x="90" y="148" width="164" height="10" rx="5"/>
            <rect class="il-block" x="90" y="166" width="132" height="10" rx="5"/>
            <rect class="il-block il-block--w" x="90" y="196" width="88" height="30" rx="15"/>
            <g class="il-float-1">
                <rect class="il-bubble" x="266" y="94" width="132" height="56" rx="20"/>
                <circle class="il-tick" cx="296" cy="122" r="6"/>
                <rect class="il-block" x="314" y="116" width="66" height="10" rx="5"/>
            </g>
            <g class="il-float-2">
                <rect class="il-bubble il-bubble--v" x="248" y="176" width="156" height="62" rx="20"/>
                <rect class="il-block il-block--onv" x="272" y="196" width="108" height="10" rx="5"/>
                <rect class="il-block il-block--onv" x="272" y="214" width="76" height="10" rx="5"/>
            </g>
        @break

        {{-- Company: a stack of finished sites, one verified. --}}
        @case('company')
            <rect class="il-frame il-frame--ghost" x="96" y="58" width="288" height="70" rx="12"/>
            <rect class="il-frame il-surface" x="78" y="118" width="324" height="86" rx="12"/>
            <path class="il-line" d="M78 148h324"/>
            <circle class="il-dot il-dot--1" cx="102" cy="133" r="4"/>
            <circle class="il-dot il-dot--2" cx="118" cy="133" r="4"/>
            <rect class="il-block il-block--v" x="102" y="166" width="118" height="12" rx="6"/>
            <rect class="il-block" x="234" y="166" width="146" height="12" rx="6"/>
            <rect class="il-frame il-frame--ghost" x="96" y="216" width="288" height="70" rx="12"/>
            <g class="il-stamp">
                <circle class="il-stamp-ring" cx="382" cy="252" r="34"/>
                <path class="il-check" d="M366 252l12 12 22-24"/>
            </g>
        @break

        {{-- Speed: a dial sweeping up, with the padlock that comes with SSL. --}}
        @case('speed')
            <path class="il-arc-track" d="M118 258a122 122 0 0 1 244 0"/>
            <path class="il-arc" d="M118 258a122 122 0 0 1 244 0"/>
            <g class="il-needle">
                <path d="M240 258L188 176"/>
                <circle cx="240" cy="258" r="12"/>
            </g>
            <path class="il-tickmark" d="M136 210l16 8M240 142v18M344 210l-16 8"/>
            <g class="il-lock">
                <rect class="il-lock-body" x="292" y="252" width="60" height="48" rx="10"/>
                <path class="il-lock-arc" d="M306 252v-12a16 16 0 0 1 32 0v12"/>
                <circle class="il-lock-pin" cx="322" cy="274" r="5"/>
            </g>
        @break

        {{-- Team: people as nodes on one system. --}}
        @case('team')
            <path class="il-link" d="M164 208 240 132 316 208M164 208h152"/>
            <g class="il-node il-node--1">
                <circle class="il-avatar il-avatar--v" cx="240" cy="122" r="34"/>
                <circle class="il-head" cx="240" cy="112" r="11"/>
                <path class="il-body" d="M222 142a18 18 0 0 1 36 0z"/>
            </g>
            <g class="il-node il-node--2">
                <circle class="il-avatar" cx="150" cy="222" r="30"/>
                <circle class="il-head" cx="150" cy="213" r="10"/>
                <path class="il-body" d="M134 240a16 16 0 0 1 32 0z"/>
            </g>
            <g class="il-node il-node--3">
                <circle class="il-avatar il-avatar--w" cx="330" cy="222" r="30"/>
                <circle class="il-head" cx="330" cy="213" r="10"/>
                <path class="il-body" d="M314 240a16 16 0 0 1 32 0z"/>
            </g>
            <rect class="il-block" x="176" y="286" width="128" height="12" rx="6"/>
        @break

        {{-- Process: three stages, progress running through them. --}}
        @case('process')
            <path class="il-rail" d="M96 180h288"/>
            <path class="il-rail-fill" d="M96 180h288"/>
            <g class="il-step il-step--1">
                <circle class="il-step-ring il-step-ring--v" cx="96" cy="180" r="26"/>
                <path class="il-check" d="M85 180l8 8 15-16"/>
            </g>
            <g class="il-step il-step--2">
                <circle class="il-step-ring il-step-ring--v" cx="240" cy="180" r="26"/>
                <path class="il-check" d="M229 180l8 8 15-16"/>
            </g>
            <g class="il-step il-step--3">
                <circle class="il-step-ring" cx="384" cy="180" r="26"/>
                <circle class="il-pulse" cx="384" cy="180" r="26"/>
            </g>
            <rect class="il-block" x="60" y="234" width="72" height="10" rx="5"/>
            <rect class="il-block" x="204" y="234" width="72" height="10" rx="5"/>
            <rect class="il-block" x="348" y="234" width="72" height="10" rx="5"/>
        @break

        {{-- Email: the envelope opens and the message lifts out. --}}
        @case('email')
            <g class="il-mail">
                <rect class="il-frame il-surface" x="98" y="150" width="284" height="164" rx="14"/>
                <path class="il-mail-flap" d="M98 164l142 96 142-96"/>
                <g class="il-letter">
                    <rect class="il-surface il-letter-card" x="146" y="74" width="188" height="118" rx="12"/>
                    <rect class="il-block il-block--v" x="170" y="100" width="90" height="12" rx="6"/>
                    <rect class="il-block" x="170" y="124" width="140" height="10" rx="5"/>
                    <rect class="il-block" x="170" y="142" width="112" height="10" rx="5"/>
                </g>
                <path class="il-mail-front" d="M98 314V190l142 84 142-84v124z"/>
            </g>
        @break

        {{-- Support: a headset, with the line staying open. --}}
        @case('support')
            <path class="il-band" d="M156 210v-30a84 84 0 0 1 168 0v30"/>
            <rect class="il-cup il-cup--v" x="132" y="200" width="46" height="80" rx="22"/>
            <rect class="il-cup il-cup--v" x="302" y="200" width="46" height="80" rx="22"/>
            <path class="il-mic" d="M302 264v18a28 28 0 0 1-28 28h-22"/>
            <circle class="il-mic-tip" cx="242" cy="310" r="11"/>
            <g class="il-rings">
                <circle class="il-ring il-ring--1" cx="240" cy="196" r="118"/>
                <circle class="il-ring il-ring--2" cx="240" cy="196" r="118"/>
            </g>
        @break

        {{-- Domain: searching the globe for a name. --}}
        @case('domain')
            <circle class="il-globe" cx="222" cy="176" r="98"/>
            <path class="il-meridian" d="M222 78c34 30 34 166 0 196M222 78c-34 30-34 166 0 196M124 176h196M140 128h164M140 224h164"/>
            <g class="il-scan">
                <circle class="il-lens" cx="300" cy="248" r="52"/>
                <path class="il-handle" d="M338 286l44 44"/>
            </g>
            <rect class="il-frame il-surface il-chip" x="150" y="152" width="144" height="46" rx="10"/>
            <rect class="il-block il-block--v" x="170" y="169" width="58" height="12" rx="6"/>
            <rect class="il-block il-block--w" x="236" y="169" width="38" height="12" rx="6"/>
        @break

    @endswitch
</svg>
</div>
