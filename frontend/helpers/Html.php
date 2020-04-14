<?php

namespace frontend\helpers;

use Yii;

class Html extends \yii\helpers\Html
{

    /**
     * Returns prepared html string with a bootstrap glyphicon attached to the left side of given label.
     *
     * @param string $glyph
     * @param null|string $label
     * @param string $color
     * @return string
     */
    public static function glyphicon($glyph, $label = null, $color = 'default')
    {
        $str = self::tag('span', '', ['class' => 'glyphicon glyphicon-' . $glyph . ' text-' . $color, 'aria-hidden' => 'true']);

        if ($label) {
            $str .= ' ' . Yii::t('app', $label);
        }

        return $str;
    }

    /**
     * Returns prepared html string with a bootstrap glyphicon attached to the left side of given label.
     *
     * @param string $fa
     * @param null|string $label
     * @param string $color
     * @return string
     */
    public static function fa($fa, $label = null, $color = 'default')
    {
        $str = self::tag('span', '', ['class' => 'fa fa-' . $fa . ' text-' . $color, 'aria-hidden' => 'true']);

        if ($label) {
            $str .= ' ' . Yii::t('app', $label);
        }

        return $str;
    }

    /**
     * For required field adds red star into label
     *
     * @param \yii\base\Model $model
     * @param string $attribute
     * @param array $options
     * @return string
     */
    public static function activeLabel($model, $attribute, $options = [])
    {
        $for = ArrayHelper::remove($options, 'for', static::getInputId($model, $attribute));
        $attribute = static::getAttributeName($attribute);

        $attributeLabelName = static::encode($model->getAttributeLabel($attribute));
        if ($model->isAttributeRequired($attribute)) {
            $attributeLabelName .= static::tag('span', ' *', ['class' => 'text-danger']);
        }

        $label = ArrayHelper::remove($options, 'label', $attributeLabelName);
        return static::label($label, $for, $options);
    }

    /**
     * Join array to string using filter which remove empty elements
     *
     * @param array $data array (that) needed to be joined
     * @param string $separator
     * @param bool $useFilter whether to filter empty rows in array
     * @return string
     */
    public static function joinToString(array $data, $separator = ' ', $useFilter = true)
    {
        if ($useFilter) {
            $data = array_filter($data);
        }

        return join($separator, $data);

    }

    /**
     * Returns is value enabled using icon representation
     *
     * @param $value
     * @return string
     */
    public static function iconIsEnabled($value, $asText = false)
    {
        if ($asText) {
            return $value ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
        }

        return $value ? static::tag('span', '.', [
            'class' => 'fa fa-circle text-green',
            'style' => 'font-size:5px', //TODO remove styles from this, it's temporary decision
        ]) : '';
    }
}
