<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'css/notification.css',
        'template/assets/plugins/global/plugins.bundle.css',
        'template/assets/css/style.bundle.css',
    ];
    public $js = [
        'js/chart-script.js',
        'js/notification.js',
        'js/chart-5.js',
        'template/assets/plugins/global/plugins.bundle.js',
        'template/assets/js/scripts.bundle.js',
        'template/assets/js/widgets.bundle.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
