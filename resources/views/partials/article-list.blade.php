{{-- partials/article-list.blade.php --}}
{{-- Used by: BlogController::category AJAX + category.blade.php --}}
{{-- Accepts: $blogs (LengthAwarePaginator) --}}

<div class="blog56 blog56--grid blog56--grid--4cols article-list56">
    @foreach($blogs as $blog)
    @include('partials.post-card', ['blog' => $blog])
    @endforeach
</div>
