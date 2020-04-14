<?php
/**
 * Created by PhpStorm.
 * User: Irina Sklyarenko
 * Date: 12/6/16
 * Time: 17:36
 */

namespace common\assets\loadingoverlay;

use yii\web\AssetBundle;

/**
 * Class LoadingOverlayAsset
 */
class LoadingOverlayAsset extends AssetBundle
{
    public $sourcePath = '@common/assets/loadingoverlay';

    public $js = [
        'js/loadingoverlay.min.js',
    ];

    public $depends = [];
}