<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        '/css/output.css?v=<?=time()?>',
        'https://cdn.boxicons.com/fonts/basic/boxicons.min.css',
        'https://cdn.jsdelivr.net/npm/daisyui@5',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',

    ];
}
