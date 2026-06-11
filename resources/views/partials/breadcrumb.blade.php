{{-- partials/breadcrumb.blade.php --}}
{{-- Accepts: $crumbs array --}}

@if(!empty($crumbs) && count($crumbs) > 1)
<nav class="breadcrumb56" aria-label="Breadcrumb">
    <ol class="breadcrumb56__list">
        @foreach($crumbs as $crumb)
            @if($loop->last)
            <li class="breadcrumb56__item breadcrumb56__item--current" aria-current="page">{{ $crumb['title'] }}</li>
            @else
            <li class="breadcrumb56__item">
                <a href="{{ $crumb['absolute_url'] }}">{{ $crumb['title'] }}</a>
            </li>
            @endif
        @endforeach
    </ol>
</nav>
@endif
