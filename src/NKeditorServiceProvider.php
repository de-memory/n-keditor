<?php

namespace Encore\NKeditor;

use Encore\Admin\Admin;
use Encore\Admin\Form;
use Encore\NKeditor\Controllers\NKeditorController;
use Illuminate\Support\ServiceProvider;

class NKeditorServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(NKeditor $extension)
    {
        if (! NKeditor::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'n-keditor');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/de-memory/n-keditor')],
                'n-keditor'
            );
        }

        // 加载插件
        Admin::booting(function () {
            Form::extend('nkeditor', NKeditorController::class);
        });

        $this->app->booted(function () {
            NKeditor::routes(__DIR__.'/../routes/web.php');
        });
    }
}