<?php

namespace Encore\NKeditor;

use Encore\Admin\Extension;

class NKeditor extends Extension
{
    public $name = 'n-keditor';

    public $views = __DIR__.'/../resources/views';

    public $assets = __DIR__.'/../resources/assets';

    public $menu = [
        'title' => 'Nkeditor',
        'path'  => 'n-keditor',
        'icon'  => 'fa-gears',
    ];
}