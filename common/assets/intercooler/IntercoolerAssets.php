<?php
/**
 * Created by PhpStorm.
 * User: Kirill Gladkiy
 * Date: 8/31/2016
 * Time: 15:45
 */

namespace common\assets\intercooler;

use yii\web\AssetBundle;

class IntercoolerAssets extends AssetBundle
{

    public $sourcePath = '@common/assets/intercooler';

    public $js = [
        'js/intercooler-1.0.0.js',
        'js/intercooler-extra.js'
    ];

    public $depends = [
        'common\assets\loadingoverlay\LoadingOverlayAsset'
    ];

}