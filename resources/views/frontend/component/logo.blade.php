{{--
    The logo, inline.

    Inline rather than <img src="...svg"> for one reason: an SVG loaded as an image cannot
    fetch a web font, so the wordmark would fall back to Arial. Inlined, it renders in
    Manrope like the rest of the page.

    The file at frontend/resources/img/logo/htvietnam.svg is the same drawing with a font
    stack, for anywhere that needs a plain image — meta tags, email, the admin.

    Expects (optional): $height — CSS height for the logo, default 40px
--}}
@php $logoHeight = $height ?? '40px'; @endphp

<svg class="brand" style="height: {{ $logoHeight }}" viewBox="0 0 194 44"
     role="img" aria-label="{{ $system['homepage_brand'] ?? 'HT Việt Nam' }}">
    <title>{{ $system['homepage_company'] ?? 'HT Việt Nam' }}</title>

    {{-- An H built from three bars in the site's three colours. Both uprights run the
         full height: the first attempt shortened the right one to hint at a T, and at
         header size that read as a lowercase "h" instead. The teal band is drawn last so
         it crosses both uprights — that overlap is where the three colours meet, and it
         is what makes the mark read as one letter rather than three shapes. --}}
    <rect x="2"  y="4"  width="10" height="36" rx="5" fill="#0573ff"/>
    <rect x="24" y="4"  width="10" height="36" rx="5" fill="#0b1b3d"/>
    <rect x="2"  y="17" width="32" height="10" rx="5" fill="#35d0ba"/>

    <text x="46" y="31" font-size="25" font-weight="800" letter-spacing="-0.5">
        <tspan fill="#0573ff">HT</tspan><tspan fill="#0b1b3d" dx="3">VIETNAM</tspan>
    </text>
</svg>
