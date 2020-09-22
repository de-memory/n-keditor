<?php

use Encore\NKeditor\Http\Controllers\NKeditorController;

Route::get('n-keditor', NKeditorController::class.'@index');