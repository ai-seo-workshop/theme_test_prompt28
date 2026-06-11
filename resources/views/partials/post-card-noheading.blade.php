{{-- partials/post-card-noheading.blade.php --}}
{{-- Same as post-card but uses <p> instead of <h2> for the title --}}
{{-- Use in sidebar/related areas where H tags are forbidden --}}
{{-- Accepts: $blog (Blog object) --}}

<article class="post56 griditem56 post56--grid post56--normal align-left">
    @if($blog->head_img)
    <figure class="thumbnail56 component56">
        <a href="{{ $blog->url }}">
            <img src="{{ $blog->head_img }}"
                 alt="{{ $blog->head_img_alt ?: $blog->title }}"
                 loading="lazy"
                 decoding="async">
        </a>
    </figure>
    @endif
    <div class="post56__text">
        <p class="title56 component56">
            <a href="{{ $blog->url }}">{{ $blog->title }}</a>
        </p>
        @if($blog->summary)
        <div class="excerpt56 component56">{{ Str::limit($blog->summary, 120) }}</div>
        @endif
        <div class="meta56 component56">
            @if($blog->published_at)
            <div class="meta56__item meta56__date">{{ $blog->published_at->format('F j, Y') }}</div>
            @endif
            @if($blog->category_name)
            <div class="meta56__item meta56__category">
                <a href="{{ $blog->category->url ?? '#' }}" rel="tag">{{ $blog->category_name }}</a>
            </div>
            @endif
        </div>
    </div>
    <hr class="post56__sep__line">
</article>
