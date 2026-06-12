<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Samiur Rahman — Dimarz</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700&family=Space+Mono:wght@400;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Syne:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/portfolio.css') }}">
@stack('styles')
</head>
<body>
<!-- Ambient Glow Orbs -->
<div class="glow-orb orb-1"></div>
<div class="glow-orb orb-2"></div>
<div class="glow-orb orb-3"></div>

<!-- Noise Overlay -->
<div class="noise"></div>

<!-- Corner Decorations -->
<div class="corner top-left"></div>
<div class="corner top-right"></div>
<div class="corner bottom-left"></div>
<div class="corner bottom-right"></div>

<!-- Side Text -->
<div class="side-text">Niche-Targeted B2B Lead Generation</div>
<div class="side-text left">Top Rated on Upwork</div>

@yield('content')

<script src="{{ asset('js/portfolio.js') }}"></script>
@stack('scripts')
</body>
</html>
