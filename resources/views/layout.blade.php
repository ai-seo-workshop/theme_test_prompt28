<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('description', '')">
    <link rel="canonical" href="{{ rtrim(request()->url(), '/') . '/' }}">
    {!! $alternate_tag ?? '' !!}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Merriweather:wght@300;400;700&display=swap">
    {{-- Site CSS --}}
    <link rel="stylesheet" href="{{ asset('css56/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css56/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css56/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css56/archive.css') }}">
    <link rel="stylesheet" href="{{ asset('css56/single.css') }}">
    <link rel="stylesheet" href="{{ asset('css56/page.css') }}">
    @stack('styles')
    @yield('schema')
    @if(!empty($gtag))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gtag }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $gtag }}');
    </script>
    @endif
</head>
<body>

<div id="wi-all" class="fox-outer-wrapper">

    {{-- ===== DESKTOP MASTHEAD ===== --}}
    <div class="masthead header_desktop56 masthead--sticky">
        <div class="masthead__wrapper">

            {{-- Topbar --}}
            <div id="topbar56" class="topbar56">
                <div class="topbar56__container">
                    <div class="topbar56__left">
                        <button class="hamburger56" data-offcanvas-toggle aria-expanded="false" aria-label="Toggle navigation">
                            <svg class="icon-open" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                            <svg class="icon-close" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>
                    <div class="topbar56__right">
                        Today: <span id="topbar-date">{{ now()->format('F j, Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Main Header: search left / logo center / social right --}}
            <div id="header56" class="main_header56">
                <div class="main_header56__container">
                    <div class="header56__part--left">
                        <div class="header56__search">
                            <button class="search-btn-toggle" data-search-toggle aria-expanded="false" aria-label="Toggle search">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            </button>
                            <div class="search-wrapper-toggle">
                                <form class="searchform56" method="get" action="/" role="search">
                                    <input type="text" name="s" placeholder="Type &amp; hit enter" aria-label="Search">
                                    <button type="submit" aria-label="Submit search">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="header56__part--center">
                        <div class="logo56">
                            <a href="/" rel="home">
                                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" loading="eager">
                            </a>
                            @if(!empty($seoInfo->slogan ?? null))
                            <p class="site-tagline">{{ $seoInfo->slogan }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="header56__part--right">
                        <div class="header56__social">
                            <ul class="social-list56" aria-label="Social media links">
                                <li><a href="#" aria-label="Facebook" rel="noopener noreferrer" target="_blank">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                                </a></li>
                                <li><a href="#" aria-label="Instagram" rel="noopener noreferrer" target="_blank">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nav bar --}}
            <div id="header_bottom56" class="header_bottom56">
                <div class="header_bottom56__container">
                    <nav class="mainnav56" role="navigation" aria-label="Main navigation">
                        <ul>
                            <li><a href="/"><span>{{ \App\Models\MaterielTask::home(app()->getLocale()) }}</span></a></li>
                            @foreach($categories as $cat)
                            <li><a href="{{ $cat->url }}"><span>{{ $cat->name }}</span></a></li>
                            @endforeach
                            @foreach(\App\Models\MaterielTask::SUPPORTS(app()->getLocale()) as $pageType => $pageData)
                            <li><a href="/{{ $pageData['uri'] }}"><span>{{ $pageData['name'] }}</span></a></li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
            </div>

        </div>
    </div>

    {{-- ===== MOBILE HEADER ===== --}}
    <div id="header_mobile56" class="header_mobile56">
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
    <div class="header_mobile56__height"></div>

    {{-- ===== MAIN CONTENT ===== --}}
    <div id="wi-main" class="wi-main fox-main">
        @yield('content')
    </div>

    {{-- ===== FOOTER ===== --}}
    <footer id="wi-footer" class="site-footer">
        <div class="footer_sidebar56">
            <div class="container">
                <div class="footer56__row">
                    {{-- Col 1: Recent Posts --}}
                    <aside class="footer56__col">
                        <h3 class="widget-title56">{{ \App\Models\MaterielTask::recent_posts(app()->getLocale()) }}</h3>
                        @if(!empty($latestBlogs ?? null) && $latestBlogs->count())
                        <ol class="footer-recent-list">
                            @foreach($latestBlogs->take(5) as $index => $lb)
                            <li>
                                <span class="footer-recent-list__num">{{ $index + 1 }}</span>
                                <a href="{{ $lb->url }}">{{ $lb->title }}</a>
                            </li>
                            @endforeach
                        </ol>
                        @elseif(!empty($categories) && $categories->count())
                        <ul class="footer-recent-list">
                            @foreach($categories->take(5) as $index => $cat)
                            <li>
                                <span class="footer-recent-list__num">{{ $index + 1 }}</span>
                                <a href="{{ $cat->url }}">{{ $cat->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </aside>
                    {{-- Col 2: Categories --}}
                    <aside class="footer56__col">
                        <h3 class="widget-title56">{{ \App\Models\MaterielTask::hot_topics(app()->getLocale()) }}</h3>
                        <div class="footer-tags">
                            @foreach($categories as $cat)
                            <a href="{{ $cat->url }}">{{ $cat->name }}</a>
                            @endforeach
                        </div>
                    </aside>
                    {{-- Col 3: Company links --}}
                    <aside class="footer56__col">
                        <h3 class="widget-title56">{{ \App\Models\MaterielTask::company(app()->getLocale()) }}</h3>
                        <ul class="footer-nav-list">
                            @foreach(\App\Models\MaterielTask::SUPPORTS(app()->getLocale()) as $pageType => $pageData)
                            <li><a href="/{{ $pageData['uri'] }}">{{ $pageData['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </aside>
                    {{-- Col 4: Legal links --}}
                    <aside class="footer56__col">
                        <h3 class="widget-title56">{{ \App\Models\MaterielTask::legal(app()->getLocale()) }}</h3>
                        <ul class="footer-nav-list">
                            @foreach(\App\Models\MaterielTask::SUPPORTS(app()->getLocale()) as $pageType => $pageData)
                            <li><a href="/{{ $pageData['uri'] }}">{{ $pageData['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
        <div class="footer_bottom56">
            <div class="container">
                <div class="footer-copyright">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. {{ \App\Models\MaterielTask::copyright(app()->getLocale()) }}
                </div>
                <nav aria-label="Footer navigation">
                    <ul class="footer-menu56">
                        @foreach(\App\Models\MaterielTask::SUPPORTS(app()->getLocale()) as $pageType => $pageData)
                        <li><a href="/{{ $pageData['uri'] }}">{{ $pageData['name'] }}</a></li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </footer>

    {{-- ===== OFFCANVAS OVERLAY ===== --}}
    <div id="offcanvas-overlay" class="offcanvas56__overlay" aria-hidden="true"></div>

    {{-- ===== OFFCANVAS PANEL ===== --}}
    <div id="offcanvas-panel" class="offcanvas56__panel" role="dialog" aria-modal="true" aria-label="Navigation menu">
        <div class="offcanvas56__close">
            <button class="offcanvas56__close-btn" data-offcanvas-close aria-label="Close navigation">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <nav class="offcanvasnav56" role="navigation" aria-label="Mobile navigation">
            <ul>
                <li><a href="/">{{ \App\Models\MaterielTask::home(app()->getLocale()) }}</a></li>
                @foreach($categories as $cat)
                <li><a href="{{ $cat->url }}">{{ $cat->name }}</a></li>
                @endforeach
                @foreach(\App\Models\MaterielTask::SUPPORTS(app()->getLocale()) as $pageType => $pageData)
                <li><a href="/{{ $pageData['uri'] }}">{{ $pageData['name'] }}</a></li>
                @endforeach
            </ul>
        </nav>
    </div>

</div>{{-- #wi-all --}}

<script src="{{ asset('js56/main.js') }}" defer></script>
@stack('scripts')
</body>
</html>
