<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\MaterielTask;

class BlogController extends Controller
{
    /**
     * 首页
     */
    public function index()
    {
        $seoInfo     = $this->seoInfo(MaterielTask::TYPE_HOME);
        $categoryIds = $this->categories->pluck('id')->toArray();

        $hotPosts = Blog::active()
            ->byLanguage($this->locale)
            ->whereIn('category_id', $categoryIds)
            ->latest('published_at')
            ->limit(4)
            ->get();

        $latestPosts = Blog::active()
            ->byLanguage($this->locale)
            ->whereIn('category_id', $categoryIds)
            ->latest('published_at')
            ->limit(6)
            ->get();

        return view('home', [
            'crumbs'      => $this->crumbs(null, null),
            'gtag'        => $this->site->gtag,
            'seoInfo'     => $seoInfo,
            'categories'  => $this->categories,
            'slogan'      => $seoInfo,
            'hotPosts'    => $hotPosts,
            'latestPosts' => $latestPosts,
        ]);
    }

    /**
     * 分类列表页
     */
    public function category($locale = 'en', $category = null)
    {
        if ($category === null) {
            $category     = $locale;
            $this->locale = app()->getLocale();
        }

        $categoryInfo = $this->categories->where('slug', $category)->first();
        if (!$categoryInfo) {
            return response()->view('404', ['categories' => $this->categories, 'slogan' => $this->seoInfo(MaterielTask::TYPE_HOME)], 404);
        }
        $seoInfo = $this->seoInfo(MaterielTask::TYPE_CATEGORY, $categoryInfo->id);

        $blogs = Blog::active()
            ->byLanguage($this->locale)
            ->where('category_id', $categoryInfo->id)
            ->latest('published_at')
            ->paginate(12);

        if (request()->ajax()) {
            return response()->json([
                'html' => view('partials.article-list', compact('blogs'))->render(),
                'pagination' => [
                    'current_page'   => $blogs->currentPage(),
                    'last_page'      => $blogs->lastPage(),
                    'has_more_pages' => $blogs->hasMorePages(),
                    'on_first_page'  => $blogs->onFirstPage(),
                ]
            ]);
        }

        return view('category', [
            'crumbs'       => $this->crumbs($categoryInfo, null),
            'gtag'         => $this->site->gtag,
            'categoryInfo' => $categoryInfo,
            'seoInfo'      => $seoInfo,
            'categories'   => $this->categories,
            'slogan'       => $this->seoInfo(MaterielTask::TYPE_HOME),
            'blogs'        => $blogs,
        ]);
    }

    /**
     * 文章详情页
     */
    public function show($locale = 'en', $title_uniq = null)
    {
        if ($title_uniq === null) {
            $title_uniq   = $locale;
            $this->locale = app()->getLocale();
        }

        $blog = Blog::active()
            ->byLanguage($this->locale)
            ->where('title_uniq', $title_uniq)
            ->first();
        if (!$blog) {
            return response()->view('404', ['categories' => $this->categories, 'slogan' => $this->seoInfo(MaterielTask::TYPE_HOME)], 404);
        }

        $categoryIds = $this->categories->pluck('id')->toArray();

        $popularPosts = Blog::active()
            ->byLanguage($this->locale)
            ->whereIn('category_id', $categoryIds)
            ->latest('published_at')
            ->limit(5)
            ->get();

        return view('blog-detail', [
            'crumbs'       => $this->crumbs($blog->category, $blog),
            'gtag'         => $this->site->gtag,
            'blog'         => $blog,
            'categories'   => $this->categories,
            'slogan'       => $this->seoInfo(MaterielTask::TYPE_HOME),
            'popularPosts' => $popularPosts,
        ]);
    }
}

