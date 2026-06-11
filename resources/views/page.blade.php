@extends('layout')

@section('title', $pageInfo->seo_title ?? $pageInfo->h1 ?? config('app.name'))
@section('description', $pageInfo->seo_desc ?? '')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "@id": "{{ rtrim(request()->url(), '/') . '/' }}#breadcrumb",
    "itemListElement": [
        @foreach($crumbs ?? [] as $index => $crumb)
        {
            "@type": "ListItem",
            "position": {{ $index + 1 }},
            "name": "{{ $crumb['title'] }}",
            "item": "{{ $crumb['absolute_url'] }}"
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script>
@endsection

@section('content')

<div class="page56__outer">
    <div class="container container--main">

        {{-- Page header --}}
        <div class="page56__header">
            <span class="page56__label">Page</span>
            <h1 class="page56__title">{{ $pageInfo->h1 ?? $pageInfo->seo_title }}</h1>
        </div>

        {{-- Breadcrumb --}}
        @if(!empty($crumbs))
        <div class="page56__breadcrumb">
            @include('partials.breadcrumb', ['crumbs' => $crumbs])
        </div>
        @endif

        {{-- Page content --}}
        <div class="page56__content">
            {!! $pageInfo->content !!}
        </div>

    </div>
</div>

@endsection
