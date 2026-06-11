<?php

namespace App\Http\Controllers;

use App\Models\MaterielTask;
use App\Services\CategoryService;

class PageController extends Controller
{
    /**
     * About Us 页面
     */
    public function about()
    {
        $pageInfo = $this->seoInfo(MaterielTask::TYPE_ABOUT);
        if (!$pageInfo) {
            return response()->view('404', ['categories' => $this->categories, 'slogan' => $this->seoInfo(MaterielTask::TYPE_HOME)], 404);
        }

        return view('page', [
            'gtag' => $this->site->gtag,
            'pageInfo' => $pageInfo,
            'categories' => $this->categories,
            'slogan' => $this->seoInfo(MaterielTask::TYPE_HOME),
            'crumbs' => $this->pagecrumbs($pageInfo),
        ]);
    }

    /**
     * Contact Us 页面
     */
    public function contact()
    {
        $pageInfo = $this->seoInfo(MaterielTask::TYPE_CONTACT);
        if (!$pageInfo) {
            return response()->view('404', ['categories' => $this->categories, 'slogan' => $this->seoInfo(MaterielTask::TYPE_HOME)], 404);
        }

        return view('page', [
            'gtag' => $this->site->gtag,
            'pageInfo' => $pageInfo,
            'categories' => $this->categories,
            'slogan' => $this->seoInfo(MaterielTask::TYPE_HOME),
            'crumbs' => $this->pagecrumbs($pageInfo),
        ]);
    }

    /**
     * Privacy Policy 页面
     */
    public function privacy()
    {
        $pageInfo = $this->seoInfo(MaterielTask::TYPE_POLICY);
        if (!$pageInfo) {
            return response()->view('404', ['categories' => $this->categories, 'slogan' => $this->seoInfo(MaterielTask::TYPE_HOME)], 404);
        }

        return view('page', [
            'gtag' => $this->site->gtag,
            'pageInfo' => $pageInfo,
            'categories' => $this->categories,
            'slogan' => $this->seoInfo(MaterielTask::TYPE_HOME),
            'crumbs' => $this->pagecrumbs($pageInfo),
        ]);
    }

    /**
     * Terms 页面
     */
    public function terms()
    {
        $pageInfo = $this->seoInfo(MaterielTask::TYPE_TERMS);
        if (!$pageInfo) {
            return response()->view('404', ['categories' => $this->categories, 'slogan' => $this->seoInfo(MaterielTask::TYPE_HOME)], 404);
        }

        return view('page', [
            'gtag' => $this->site->gtag,
            'pageInfo' => $pageInfo,
            'categories' => $this->categories,
            'slogan' => $this->seoInfo(MaterielTask::TYPE_HOME),
            'crumbs' => $this->pagecrumbs($pageInfo),
        ]);
    }

    /**
     * 构建 page 页面的面包屑（首页 > 页面名称）
     */
    private function pagecrumbs($pageInfo): array
    {
        $pageName = data_get(MaterielTask::SUPPORTS(app()->getLocale()), $pageInfo->type . '.name', $pageInfo->title ?? '');

        return array_merge(
            $this->crumbs(null, null),
            [['title' => $pageName, 'absolute_url' => rtrim(request()->url(), '/') . '/']]
        );
    }

    public function error() {
        return response()->view('404', ['categories' => $this->categories, 'slogan' => $this->seoInfo(MaterielTask::TYPE_HOME)], 404);
    }
}
