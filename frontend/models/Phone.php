<?php

namespace frontend\models;

/**
 * This is the model class for table "{{%phone}}".
 *
 * @property int $id
 * @property string $contact_id
 * @property string $phone
 *
 * @property Contact $contact
 */
class Phone extends \common\models\Phone
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['contact_id', 'phone'], 'required'],
            ['phone', 'string', 'max' => 32],
        ];
    }

    public function beforeValidate()
    {

        if ($this->isNewRecord && $this->contact && $this->contact->getPhones()->count() >= 20) {
            $this->addError('phone', 'More then 20 phones is not allowed.');
        }

        return parent::beforeValidate();
    }


    /**
     * @return Contact|\yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(Contact::class, ['id' => 'contact_id']);
    }
}
