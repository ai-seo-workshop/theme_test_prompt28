@extends('layout')

@section('title', $blog->title)
@section('description', $blog->summary ?? '')

@section('schema')
@php
    $faqData = $blog->faq ?? [];
    $hasFaq = !empty($faqData);
@endphp
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@graph": [
        {
            "@type": "Article",
            "@id": "{{ $blog->absoluteUrl() }}#article",
            "url": "{{ $blog->absoluteUrl() }}",
            "headline": "{{ $blog->title }}",
            "datePublished": "{{ $blog->published_at ? $blog->published_at->toIso8601String() : '' }}",
            "dateModified": "{{ $blog->published_at ? $blog->published_at->toIso8601String() : '' }}",
            "author": {
                "@type": "Person",
                "name": "{{ $blog->author ?? config('app.name') }}"
            },
            "publisher": {
                "@type": "Organization",
                "name": "{{ config('app.name') }}"
            }
        },
        {
            "@type": "BreadcrumbList",
            "@id": "{{ $blog->absoluteUrl() }}#breadcrumb",
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
        @if($hasFaq)
        ,{
            "@type": "FAQPage",
            "mainEntity": [
                @foreach($faqData as $faqItem)
                {
                    "@type": "Question",
                    "name": "{{ $faqItem['question'] }}",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "{{ strip_tags($faqItem['answer']) }}"
                    }
                }@if(!$loop->last),@endif
                @endforeach
            ]
        }
        @endif
    ]
}
</script>
@endsection

@section('content')

<div class="single-placement">
    <article id="wi-content" class="single56 no-sidebar single56--narrow">

        {{-- ===== ARTICLE HEADER: meta + H1 + hero image ===== --}}
        <div class="container container--single-header single56__outer">

            {{-- Breadcrumb --}}
            <div class="single56__breadcrumb">
                @include('partials.breadcrumb', ['crumbs' => $crumbs])
            </div>

            <div class="single56__header align-center">
                <div class="meta56">
                    @if($blog->published_at)
                    <div class="meta56__date">{{ $blog->published_at->format('F j, Y') }}</div>
                    @endif
                    @if($blog->category_name)
                    <div class="meta56__category">
                        <a href="{{ $blog->category->url ?? '#' }}" rel="tag">{{ $blog->category_name }}</a>
                    </div>
                    @endif
                    @if($blog->author)
                    <div class="meta56__author">
                        {{ \App\Models\MaterielTask::by(app()->getLocale()) }}
                        <span>{{ $blog->author }}</span>
                    </div>
                    @endif
                </div>

                <h1 class="post-title single56__title">{!! $blog->h1 !!}</h1>
            </div>

        </div>

        {{-- ===== ARTICLE BODY ===== --}}
        <div class="container container--main single56__outer">
            <div class="primary56">
                <div class="single56__body">

                    {{-- Meta info bar --}}
                    <div class="single56__meta-info">
                        @if($blog->published_at)
                        <span>{{ \App\Models\MaterielTask::detailPublished(app()->getLocale()) }}: {{ $blog->published_at->format('F j, Y') }}</span>
                        @endif
                        @if($blog->category_name)
                        <span> &middot; {{ \App\Models\MaterielTask::filedUnder(app()->getLocale()) }}: <a href="{{ $blog->category->url ?? '#' }}">{{ $blog->category_name }}</a></span>
                        @endif
                        @if($blog->author)
                        <span> &middot; {{ \App\Models\MaterielTask::by(app()->getLocale()) }} {{ $blog->author }}</span>
                        @endif
                    </div>

                    {{-- Main content --}}
                    <div class="entry-content single56__element single56__content">
                        {!! $blog->content !!}
                    </div>

                    {{-- FAQ section --}}
                    @if($hasFaq)
                    <div class="single56__faq">
                        <h2 class="single56__faq-title">{{ \App\Models\MaterielTask::detail_content(app()->getLocale()) }}</h2>
                        @foreach($faqData as $faqItem)
                        <div class="faq56-item">
                            <h3 class="faq56-question" aria-expanded="false" role="button" tabindex="0">{{ $faqItem['question'] }}</h3>
                            <div class="faq56-answer">{!! $faqItem['answer'] !!}</div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- FAQ from content_faq --}}
                    @if(!empty($blog->content_faq))
                    <div class="entry-content single56__element">
                        {!! $blog->content_faq !!}
                    </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ===== RELATED ARTICLES ===== --}}
        @if(!empty($relatedBlogs) && $relatedBlogs->count())
        <div class="container container--main single56__outer">
            <div class="single56__related">
                <div class="single56__related-title">{{ \App\Models\MaterielTask::related_posts(app()->getLocale()) }}</div>
                <div class="blog56 blog56--grid blog56--grid--4cols">
                    @foreach($relatedBlogs as $rb)
                    @include('partials.post-card-noheading', ['blog' => $rb])
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </article>
</div>

@endsection
