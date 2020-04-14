<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%phone}}".
 *
 * @property int $id
 * @property string $contact_id
 * @property string $phone
 */
class Phone extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%phone}}';
    }
}
