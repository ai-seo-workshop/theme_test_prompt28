@extends('layout')

@section('title', $seoInfo->seo_title ?? config('app.name'))
@section('description', $seoInfo->seo_desc ?? '')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "@id": "{{ rtrim(config('app.url'), '/') }}/#website",
    "url": "{{ rtrim(config('app.url'), '/') }}/",
    "name": "{{ config('app.name') }}",
    "description": "{{ $seoInfo->seo_desc ?? '' }}"
}
</script>
@endsection

@section('content')

{{-- ===== H1 (before all other headings) ===== --}}
<div class="container container--main" style="padding-top:20px;padding-bottom:0;">
    <h1 class="home56__h1">{{ !empty($seoInfo->h1) ? $seoInfo->h1 : \App\Models\MaterielTask::homeH1(app()->getLocale()) }}</h1>
</div>

{{-- ===== FEATURED GROUP (first latestBlog large + side list) ===== --}}
@if(!empty($latestBlogs) && $latestBlogs->count())
<section class="home56__featured">
    <div class="container container--main">
        @php $featuredBlog = $latestBlogs->first(); $sideBlogs = $latestBlogs->slice(1, 4); @endphp
        <div class="home56__featured-inner">
            {{-- Big featured card --}}
            <div class="home56__featured-main">
                <article class="post56 post56--featured">
                    @if($featuredBlog->head_img)
                    <figure class="thumbnail56">
                        <a href="{{ $featuredBlog->url }}">
                            <img src="{{ $featuredBlog->head_img }}"
                                 alt="{{ $featuredBlog->head_img_alt ?: $featuredBlog->title }}"
                                 loading="eager"
                                 decoding="async">
                        </a>
                    </figure>
                    @endif
                    <div class="post56__text">
                        <div class="meta56">
                            <div class="meta56__date">{{ $featuredBlog->published_at ? $featuredBlog->published_at->format('F j, Y') : '' }}</div>
                            <div class="meta56__category"><a href="{{ $featuredBlog->category->url ?? '#' }}">{{ $featuredBlog->category_name }}</a></div>
                        </div>
                        <h2 class="title56"><a href="{{ $featuredBlog->url }}">{{ $featuredBlog->title }}</a></h2>
                        @if($featuredBlog->summary)
                        <div class="excerpt56">{{ Str::limit($featuredBlog->summary, 180) }}</div>
                        @endif
                    </div>
                    <hr class="post56__sep__line">
                </article>
            </div>
            {{-- Side list --}}
            @if($sideBlogs->count())
            <div class="home56__side-list">
                @foreach($sideBlogs as $sb)
                <article class="post56">
                    @if($sb->head_img)
                    <figure class="thumbnail56">
                        <a href="{{ $sb->url }}">
                            <img src="{{ $sb->head_img }}"
                                 alt="{{ $sb->head_img_alt ?: $sb->title }}"
                                 loading="lazy"
                                 decoding="async">
                        </a>
                    </figure>
                    @endif
                    <div class="post56__text">
                        <div class="meta56">
                            <div class="meta56__date">{{ $sb->published_at ? $sb->published_at->format('M j, Y') : '' }}</div>
                            <div class="meta56__category"><a href="{{ $sb->category->url ?? '#' }}">{{ $sb->category_name }}</a></div>
                        </div>
                        <h2 class="title56"><a href="{{ $sb->url }}">{{ $sb->title }}</a></h2>
                    </div>
                </article>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- ===== PER-CATEGORY SECTIONS from $blogs ===== --}}
@if(!empty($blogs) && $blogs->count())
    @php $catSectionCount = 0; @endphp
    @foreach($blogs as $catId => $catBlogs)
        @if($catSectionCount >= 3) @break @endif
        @php
            $catObj = $categories->where('id', $catId)->first();
            $catSectionCount++;
        @endphp
        <section class="home56__cat-section builder56__section">
            <div class="container container--main">
                <div class="home56__cat-header">
                    <h2 class="home56__cat-title">
                        <span class="home56__cat-title-line"></span>
                        {{ $catObj ? $catObj->name : $catBlogs->first()->category_name }}
                        <span class="home56__cat-title-line"></span>
                    </h2>
                    @if($catObj)
                    <a href="{{ $catObj->url }}" class="home56__cat-viewall">View All &raquo;</a>
                    @endif
                </div>
                <div class="blog56 blog56--grid blog56--grid--4cols">
                    @foreach($catBlogs->take(4) as $blog)
                    @include('partials.post-card', ['blog' => $blog])
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach
@endif

{{-- ===== HOT TOPICS SECTION ===== --}}
@if(!empty($hotBlogs) && $hotBlogs->count())
<section class="home56__hot-section builder56__section">
    <div class="container container--main">
        <div class="home56__hot-header">
            <h2 class="home56__hot-title">
                <span class="home56__cat-title-line"></span>
                {{ \App\Models\MaterielTask::hot_topics(app()->getLocale()) }}
                <span class="home56__cat-title-line"></span>
            </h2>
        </div>
        <div class="blog56 blog56--grid blog56--grid--4cols">
            @foreach($hotBlogs as $blog)
            @include('partials.post-card', ['blog' => $blog])
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
