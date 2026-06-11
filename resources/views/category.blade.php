@extends('layout')

@section('title', $seoInfo->seo_title ?? $categoryInfo->name)
@section('description', $seoInfo->seo_desc ?? '')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "CollectionPage",
            "@id": "{{ rtrim(request()->url(), '/') . '/' }}",
            "url": "{{ rtrim(request()->url(), '/') . '/' }}",
            "name": "{{ $seoInfo->seo_title ?? $categoryInfo->name }}",
            "description": "{{ $seoInfo->seo_desc ?? '' }}"
        },
        {
            "@type": "BreadcrumbList",
            "@id": "{{ rtrim(request()->url(), '/') . '/' }}#breadcrumb",
            "itemListElement": [
                @foreach($crumbs as $index => $crumb)
                {
                    "@type": "ListItem",
                    "position": {{ $index + 1 }},
                    "name": "{{ $crumb['title'] }}",
                    "item": "{{ $crumb['absolute_url'] }}"
                }@if(!$loop->last),@endif
                @endforeach
            ]
        }
    ]
}
</script>
@endsection

@section('content')

{{-- Titlebar --}}
<div class="archive56__titlebar">
    <div class="titlebar56 align-center">
        <div class="container">
            <div class="titlebar56__main">
                <span class="titlebar56__label">Browse Category</span>
                <h1 class="titlebar56__title">{{ $categoryInfo->name }}</h1>
            </div>
        </div>
    </div>
</div>

{{-- Breadcrumb --}}
<div class="container container--main">
    @include('partials.breadcrumb', ['crumbs' => $crumbs])
</div>

{{-- Article Grid --}}
<div class="archive56__main">
    <div class="container container--main">
        <div class="primary56">
            <div class="blog56-wrapper">
                <div id="article-list-container">
                    @include('partials.article-list', ['blogs' => $blogs])
                </div>

                {{-- Pagination --}}
                @include('partials.pagination', ['paginator' => $blogs])
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script defer>
(function(){
    'use strict';
    // Category page: numeric pagination AJAX
    var container = document.getElementById('article-list-container');
    var paginationWrapper = document.querySelector('.pagination56-wrapper');
    if (!container) return;

    function loadPage(url) {
        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(res){ return res.json(); })
        .then(function(data){
            if (data.html !== undefined) {
                container.innerHTML = data.html;
                renderPagination(data.pagination);
                window.scrollTo({ top: container.offsetTop - 80, behavior: 'smooth' });
            }
        })
        .catch(function(){});
    }

    function renderPagination(pag) {
        if (!paginationWrapper) return;
        var html = '<div class="pagination56">';
        var currentPage = pag.current_page;
        var lastPage = pag.last_page;
        var baseUrl = window.location.pathname;

        if (!pag.on_first_page) {
            html += '<a class="page-numbers prev" href="' + baseUrl + '?page=' + (currentPage - 1) + '" data-page="' + (currentPage - 1) + '"><span>&laquo; Prev</span></a>';
        }

        for (var i = 1; i <= lastPage; i++) {
            if (i === currentPage) {
                html += '<span class="page-numbers current"><span>' + i + '</span></span>';
            } else if (i <= 2 || i >= lastPage - 1 || Math.abs(i - currentPage) <= 1) {
                html += '<a class="page-numbers" href="' + baseUrl + '?page=' + i + '" data-page="' + i + '"><span>' + i + '</span></a>';
            } else if (Math.abs(i - currentPage) === 2) {
                html += '<span class="page-numbers dots">&hellip;</span>';
            }
        }

        if (pag.has_more_pages) {
            html += '<a class="page-numbers next" href="' + baseUrl + '?page=' + (currentPage + 1) + '" data-page="' + (currentPage + 1) + '"><span>Next &raquo;</span></a>';
        }
        html += '</div>';
        paginationWrapper.innerHTML = html;

        // rebind clicks
        paginationWrapper.querySelectorAll('a[data-page]').forEach(function(a){
            a.addEventListener('click', function(e){
                e.preventDefault();
                var page = this.getAttribute('data-page');
                var url = window.location.pathname + '?page=' + page;
                history.pushState(null, '', url);
                loadPage(url);
            });
        });
    }

    // Bind initial pagination links
    document.querySelectorAll('.pagination56 a[href]').forEach(function(a){
        a.addEventListener('click', function(e){
            var url = this.getAttribute('href');
            if (url && url.indexOf('?page=') !== -1) {
                e.preventDefault();
                history.pushState(null, '', url);
                loadPage(url);
            }
        });
    });
})();
</script>
@endpush
