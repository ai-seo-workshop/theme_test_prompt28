<?php

namespace App\Http\Middleware;

use App\Models\Site;
use Closure;
use Illuminate\Http\Request;

class IdentifySite
{
    /**
     * 根据请求域名识别当前站点，并动态覆盖域名和语言配置。
     * 必须作为全局中间件注册，在所有路由中间件之前执行。
     */
    public function handle(Request $request, Closure $next)
    {
        // 获取当前请求的域名（不含端口，方便本地调试也能匹配）
        $host = $request->getHost();

        // 按域名查找站点（带缓存，每个域名只查一次数据库）
        $site = Site::findByDomain($host);

        // 未找到站点时返回 403，防止未授权域名访问
        if (!$site) {
            abort(403, "Domain [{$host}] is not registered.");
        }

        // 将当前站点注入容器，全局可通过 app('current_site') 获取
        app()->instance('current_site', $site);

        // 覆盖当前站点域名（SitemapService、alternate_tag 等会用到）
        config(['app.domain' => $site->domain]);

        // 覆盖语言配置
        $defaultLanguage   = $site->getDefaultLanguage();
        $allLanguages      = $site->getLanguagesArray();
        $nonDefaultLangs   = array_values(array_diff($allLanguages, [$defaultLanguage]));

        config([
            'app.default_language'      => $defaultLanguage,
            'app.supported_languages'   => $allLanguages,
            'app.non_default_languages' => $nonDefaultLangs,
        ]);

        return $next($request);
    }
}
