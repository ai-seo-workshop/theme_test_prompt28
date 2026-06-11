<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Site extends Model
{
//    protected $connection = 'mysql_center';

    protected $table = 'sites';

    protected $fillable = [
        'name', 'domain', 'gtag', 'default_language', 'languages'
    ];

    protected $casts = [
        'languages' => 'array',  // 自动将 JSON 字段转换为 PHP 数组
    ];

    /**
     * 按域名查找站点，带缓存（避免每次请求都查库）
     * 缓存 key 格式: site_domain_{domain}
     */
    public static function findByDomain(string $domain): ?self
    {
        return Cache::remember("site_domain_{$domain}", 3600, function () use ($domain) {
            return static::where('domain', $domain)->first();
        });
    }

    /**
     * 获取站点支持的语言数组，兜底为 ['en']
     */
    public function getLanguagesArray(): array
    {
        return $this->languages ?: [config('app.default_language')];
    }

    /**
     * 获取站点默认语言，兜底为 'en'
     */
    public function getDefaultLanguage(): string
    {
        return $this->default_language ?: config('app.default_language');
    }

    /**
     * 清除站点缓存
     */
    public function clearCache(): void
    {
        Cache::forget("site_domain_{$this->domain}");
    }

    protected static function booted()
    {
        static::saved(function ($site) {
            $site->clearCache();
        });

        static::deleted(function ($site) {
            $site->clearCache();
        });
    }
}
