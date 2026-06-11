@php
    $locale = app()->getLocale();
    $cats = $categories ?? collect([]);
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \App\Models\MaterielTask::page_not_found($locale) }} | {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Merriweather:wght@300;400;700&display=swap">
    <link rel="stylesheet" href="{{ asset('css56/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css56/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css56/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css56/page.css') }}">
</head>
<body>
<div id="wi-all" class="fox-outer-wrapper">

    {{-- Mobile header --}}
    <div id="header_mobile56" class="header_mobile56" style="display:flex;">
        <div class="header_mobile56__container">
            <div class="header_mobile56__left">
                <button class="hamburger56" data-offcanvas-toggle aria-expanded="false" aria-label="Toggle navigation">
                    <svg class="icon-open" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    <svg class="icon-close" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="header_mobile56__center">
                <div class="logo56">
                    <a href="/" rel="home">
                        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" loading="eager">
                    </a>
                </div>
            </div>
            <div class="header_mobile56__right"></div>
        </div>
    </div>

    {{-- Simple nav --}}
    <div id="header_bottom56" class="header_bottom56">
        <div class="header_bottom56__container">
            <nav class="mainnav56" role="navigation" aria-label="Main navigation">
                <ul>
                    <li><a href="/"><span>{{ \App\Models\MaterielTask::home($locale) }}</span></a></li>
                    @foreach($cats as $cat)
                    <li><a href="{{ $cat->url }}"><span>{{ $cat->name }}</span></a></li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>

    <div id="wi-main" class="wi-main fox-main">
        <div class="error404-page">
            <div class="container">
                <div class="error404__code" aria-hidden="true">404</div>
                <h1 class="error404__title">{{ \App\Models\MaterielTask::page_not_found($locale) }}</h1>
                <p class="error404__desc">{{ \App\Models\MaterielTask::desc_1_404($locale) }}</p>
                <p class="error404__desc">{{ \App\Models\MaterielTask::desc_2_404($locale) }}</p>
                <div class="error404__action">
                    <a href="/" class="btn56">{{ \App\Models\MaterielTask::go_to_homepage($locale) }}</a>
                </div>
                @if($cats->count())
                <div class="error404__categories">
                    <h2 class="error404__categories-title">{{ \App\Models\MaterielTask::popular_destinations($locale) }}</h2>
                    <ul class="error404__cat-list">
                        @foreach($cats as $cat)
                        <li><a href="{{ $cat->url }}">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Footer bottom --}}
    <footer id="wi-footer" class="site-footer">
        <div class="footer_bottom56">
            <div class="container">
                <div class="footer-copyright">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. {{ \App\Models\MaterielTask::copyright($locale) }}
                </div>
                <nav aria-label="Footer navigation">
                    <ul class="footer-menu56">
                        @foreach(\App\Models\MaterielTask::SUPPORTS($locale) as $pageType => $pageData)
                        <li><a href="/{{ $pageData['uri'] }}">{{ $pageData['name'] }}</a></li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </footer>

    {{-- Offcanvas --}}
    <div id="offcanvas-overlay" class="offcanvas56__overlay"></div>
    <div id="offcanvas-panel" class="offcanvas56__panel" role="dialog" aria-modal="true" aria-label="Navigation menu">
        <div class="offcanvas56__close">
            <button class="offcanvas56__close-btn" data-offcanvas-close aria-label="Close navigation">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <nav class="offcanvasnav56" role="navigation" aria-label="Mobile navigation">
            <ul>
                <li><a href="/">{{ \App\Models\MaterielTask::home($locale) }}</a></li>
                @foreach($cats as $cat)
                <li><a href="{{ $cat->url }}">{{ $cat->name }}</a></li>
                @endforeach
            </ul>
        </nav>
    </div>

</div>
<script src="{{ asset('js56/main.js') }}" defer></script>
</body>
</html>
