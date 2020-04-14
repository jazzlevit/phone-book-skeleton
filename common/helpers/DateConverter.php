<?php

namespace common\helpers;
/**
 * Created by PhpStorm.
 * User: Lesha
 * Date: 28.05.15
 * Time: 2:16
 */
class DateConverter
{
    const DATE_FORMAT = 'php:Y-m-d';
    const DATETIME_FORMAT = 'php:Y-m-d H:i:s';
    const TIME_FORMAT = 'php:H:i:s';

    public static function convert($dateStr, $type='date', $format = null) {
        if ($type === 'datetime') {
            $fmt = ($format == null) ? self::DATETIME_FORMAT : $format;
        }
        elseif ($type === 'time') {
            $fmt = ($format == null) ? self::TIME_FORMAT : $format;
        }
        else {
            $fmt = ($format == null) ? self::DATE_FORMAT : $format;
        }

        return ctype_digit($dateStr) ? \Yii::$app->formatter->asDate($dateStr, $fmt) : $dateStr;
    }
}