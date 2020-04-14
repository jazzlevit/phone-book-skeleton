<?php

namespace common\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Behavior;
use yii\base\Exception;

/**
 * Trim all attributes which are string in model
 *
 *
 * Minimal structure
 * ```php
 * use common\behaviors\TrimBehavior;
 *
 * public function behaviors()
 * {
 *     return [
 *         TrimBehavior::className(),
 *     ];
 * }
 * ```
 *
 *
 * If you wanted to disable the behavior for some attributes,
 * you would need to use exceptAttributes as array of attributes *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => TimestampBehavior::className(),
 *             'exceptAttributes' => [],
 *         ],
 *     ];
 * }
 * ```
 *
 *
 * Class TrimBehavior
 * @package common\behaviors
 */
class TrimBehavior extends Behavior
{

    /**
     * Array of attributes which have to be skipped
     *
     * @var array
     */
    public $exceptAttributes = [];

    public function init()
    {
        if (false === is_array($this->exceptAttributes)) {
            throw new Exception(Yii::t('app', 'TrimBehavior::exceptAttributes must be array.'));
        }

        parent::init();
    }


    /**
     * Must use only beforeValidate Event
     *
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    /**
     * Find attributes which are strings, and trims them
     *
     * @param $event
     */
    public function beforeValidate($event)
    {
        /** @var $owner ActiveRecord */
        $owner = $this->owner;

        foreach ($owner->getAttributes() as $key => $value) {
            if (false === in_array($key, $this->exceptAttributes) && is_string($value)) {
                $owner->{$key} = trim($value);
            }
        }
    }
}
