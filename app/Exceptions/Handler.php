<?php

namespace App\Exceptions;

use App\Models\MaterielTask;
use App\Services\CategoryService;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            // 获取当前语言
            $locale = app()->getLocale();

            // 获取对应语言的分类
            $categories = CategoryService::getActiveCategories($locale);

            // 获取对应语言的 slogan
            $slogan = MaterielTask::byLanguage($locale)
                ->where('type', MaterielTask::TYPE_HOME)
                ->first();

            return response()->view('404', [
                'categories' => $categories,
                'slogan'     => $slogan,
            ], 404);
        }
        return parent::render($request, $exception);
    }
}
