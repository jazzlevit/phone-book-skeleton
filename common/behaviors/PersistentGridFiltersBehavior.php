<?php

namespace common\behaviors;

use backend\helpers\ArrayHelper;
use yii\base\Behavior;

/**
 * This class implements persistent attributes feature.
 * Useful if Search Model needs to recall a filter state, set in Grid View.
 */
class PersistentGridFiltersBehavior extends Behavior
{

    /**
     * Populates the model with the data from end user.
     *
     * @param array $data the data array. This is usually `$_POST` or `$_GET`, but can also be any valid array
     * supplied by the end user.
     * @return boolean whether `$data` contained some data to populate the models attributes.
     */
    public function loadFilters($data)
    {
        $formName = $this->owner->formName();
        $remember = ArrayHelper::getValue($data, 'rememberParams', true);

        // Handle filters for "Search" models
        $gridFilterKey = 'gridFilterKeyFor_' . $formName . \Yii::$app->controller->id;
        // reset filter
        if (isset($data['resetGridFilter'])) {
            \Yii::$app->session->set($gridFilterKey, []);
        }
        // fillout search attributes from filter data
        $attributes = isset($data[$formName]) ? $data[$formName] : \Yii::$app->session->get($gridFilterKey);

        if (false === empty($attributes)) {
            foreach ($attributes as $key => $value) {
                if ($this->owner->canSetProperty($key)) {
                    $this->owner->$key = $value;
                }
            }
            $this->owner->setAttributes($attributes);

            if ($remember) {
                \Yii::$app->session->set($gridFilterKey, $attributes);
            }
        }

        return $this->owner->load($data, $formName);
    }

}
