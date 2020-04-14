<?php

namespace frontend\models;

/**
 * This is the model class for table "{{%contact}}".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 *
 * @property Phone $phones
 * @property string $fullName
 */
class Contact extends \common\models\Contact
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @return Phone[]|\yii\db\ActiveQuery
     */
    public function getPhones()
    {
        return $this->hasMany(Phone::class, ['contact_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return join(' ', [$this->first_name, $this->last_name]);
    }
}
