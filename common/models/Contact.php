<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%contact}}".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 */
class Contact extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%contact}}';
    }
}
