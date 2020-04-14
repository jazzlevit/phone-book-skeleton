<?php
/**
 * Created by PhpStorm.
 * User: Astetsenko
 * Date: 8/4/2016
 * Time: 1:17 PM
 */

namespace common\assets\fontawesome;

use yii\web\AssetBundle;

/**
 * Font Awesome Asset
 */
class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@common/assets/fontawesome/dist';
    
    public $css = [
        'css/font-awesome.min.css',
    ];
    
    public $js = [];

    public $depends = [
    ];
}
