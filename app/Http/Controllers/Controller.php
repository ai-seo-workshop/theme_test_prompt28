<?php

namespace App\Http\Controllers;

use App\Models\MaterielTask;
use App\Services\CategoryService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $categories;
    protected $locale;
    protected $alternate_tag;
    protected $site;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->locale     = app()->getLocale();
            $this->categories = CategoryService::getActiveCategories();
            $this->site       = app('current_site');

            // 生成 hreflang 标签
            $this->alternate_tag = $this->generateAlternateTags();

            return $next($request);
        });
    }

    /**
     * 生成 hreflang alternate 标签
     */
    protected function generateAlternateTags(): string
    {
        $defaultLanguage    = config('app.default_language', 'en');
        $supportedLanguages = config('app.supported_languages', [$defaultLanguage]);

        $tags = [];
        foreach ($supportedLanguages as $lang) {
            $url    = $this->getLocalizedHomeUrl($lang);
            $tags[] = sprintf('    <link rel="alternate" href="%s/" hreflang="%s">', $url, $lang);
        }

        return implode("\n", $tags);
    }

    /**
     * 获取本地化首页 URL
     */
    protected function getLocalizedHomeUrl(string $lang): string
    {
        $defaultLanguage = config('app.default_language', 'en');

        if ($lang === $defaultLanguage) {
            return route('home');
        }

        if (\Illuminate\Support\Facades\Route::has('home.localized')) {
            return route('home.localized', ['locale' => $lang]);
        }

        return url('/' . $lang . '/');
    }

    public function seoInfo($type, $categoryId = 0)
    {
        return MaterielTask::byLanguage($this->locale)
            ->where('category_id', $categoryId)
            ->byType($type)
            ->first();
    }

    public function crumbs($categoryInfo = null, $blog = null)
    {
        $defaultLanguage = config('app.default_language', 'en');

        $crumbs = [[
            'title'        => MaterielTask::home($this->locale),
            'absolute_url' => $this->locale === $defaultLanguage
                ? route_slash('home')
                : (\Illuminate\Support\Facades\Route::has('home.localized')
                    ? route_slash('home.localized', ['locale' => $this->locale])
                    : url('/' . $this->locale . '/'))
        ]];

        if ($categoryInfo) {
            $crumbs[] = [
                'title'        => $categoryInfo->name,
                'absolute_url' => $categoryInfo->absoluteUrl(),
            ];
        }

        if ($blog) {
            $crumbs[] = [
                'author'       => $blog->author,
                'title'        => $blog->title,
                'absolute_url' => $blog->absoluteUrl(),
            ];
        }

        return $crumbs;
    }
}
