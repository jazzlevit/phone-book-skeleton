<?php
/**
 * @var \frontend\models\Contact $model
 */

use yii\helpers\Html;

$buttons[] = Html::a(Yii::t('app', 'Back'), ['/contact/index'], ['class' => 'btn btn-default']);

echo Html::tag('h2', Html::encode($model->getFullName()) . Html::tag('small', join(' ', $buttons), ['class' => 'pull-right']));

echo Html::tag('hr');

if ($model->getPhones()->exists()) {
    foreach ($model->getPhones()->each() as $phone) {
        $earphone = Html::tag('span', '' , ['class' => 'glyphicon glyphicon-earphone']);
        echo Html::tag('p', join(' ', [$earphone, $phone->phone]));
    }

} else {
    echo Html::tag(
        'div',
        'Phone numbers are not defined yet',
        ['class' => 'alert alert-warning']
    );
}
