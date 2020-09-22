<?php

namespace Encore\NKeditor\Controllers;

use Encore\Admin\Form\Field;
use Encore\NKeditor\NKeditor;

class NKeditorController extends Field
{
    protected $view = 'admin.form.n-keditor';

    protected static $css = [
    ];

    protected static $js = [
        '/vendor/de-memory/n-keditor/NKeditor-all.js',
        '/vendor/de-memory/n-keditor/libs/JDialog/JDialog.min.js',
    ];

    public function render()
    {
        $name = $this->formatName($this->column);

        // 主题
        $uploadJson = NKeditor::config('uploadJson', "K.basePath + 'php/default/upload_json.php'");

        // 主题
        $fileManagerJson = NKeditor::config('fileManagerJson', "K.basePath + 'php/default/file_manager_json.php'");

        // 主题
        $themeType = NKeditor::config('themeType', 'black');

        // 输入辅助线
        $showHelpGrid = NKeditor::config('showHelpGrid', true);

        // 浏览远程服务器按钮
        $allowFileManager = NKeditor::config('allowFileManager', false);

        // 图片上传按钮
        $allowImageUpload = NKeditor::config('allowImageUpload', true);

        // 视音频上传按钮
        $allowMediaUpload = NKeditor::config('allowMediaUpload', true);

        // 上传图片、Flash、视音频、文件时，支持添加别的参数一并传到服务器。
        $extraFileUploadParams = json_encode(NKeditor::config('extraFileUploadParams', ["name" => 'de-memory']));

        $this->script = <<<EOT

KindEditor.ready(function (K) {
        if ("{$themeType}" == 'light'){
             K.create('textarea[name="{$name}"]', {
                uploadJson: "{$uploadJson}",
                fileManagerJson: "{$fileManagerJson}",
                items : ['source','formatblock', 'fontname', 'fontsize','forecolor','justifyleft', 'justifycenter', 'justifyright',
					'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'bold', 'italic', 'underline',
					'lineheight', 'removeformat','code', 'quote', 'plainpaste','image', 'table', 'hr', 'pagebreak','link', 'unlink',
					'preview','about'
				],
                allowFileManager: ("{$allowFileManager}" == 1) ? "false" : "true",
                extraFileUploadParams: {$extraFileUploadParams}, 
                themeType : "primary", //主题
                //错误处理 handler
                errorMsgHandler: function (message, type) {
                    try {
                        JDialog.msg({type: type, content: message, timer: 2000});
                    } catch (Error) {
                        alert(message);
                    }
                }
            });
        } else {
             K.create('textarea[name="{$name}"]', {
                uploadJson: K.basePath + 'php/default/upload_json.php',
                fileManagerJson: K.basePath + 'php/default/file_manager_json.php',
                allowFileManager: ("{$allowFileManager}" == 1) ? "true" : "false",
                allowImageUpload: ("{$allowImageUpload}" == 1) ? "true" : "false",
                allowMediaUpload: ("{$allowMediaUpload}" == 1) ? "true" : "false",
                showHelpGrid: ("{$showHelpGrid}" == 1) ? "true" : "false",
                themeType: "{$themeType}",
                extraFileUploadParams: {$extraFileUploadParams}, 
                //错误处理 handler
                errorMsgHandler: function (message, type) {
                    try {
                        JDialog.msg({type: type, content: message, timer: 2000});
                    } catch (Error) {
                        alert(message);
                    }
                }
            });
        }
    });

EOT;
        return parent::render();
    }
}