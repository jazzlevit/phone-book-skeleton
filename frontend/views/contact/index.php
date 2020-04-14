<?php
/**
 * @var string $title
 */

use yii\grid\GridView;
use yii\helpers\Html;

$buttons[] = Html::a(Yii::t('app', 'Add Contact'), ['create'], ['class' => 'btn btn-default']);
if ($dataProvider->getCount() === 0) {
    $buttons[] = Html::a(
        'Generate random 30 contact with numbers for testing',
        ['contact/push'],
        [
            'class' => 'btn btn-warning',
            'data-confirm' => Yii::t('yii', 'Are you sure?'),
            'data-method' => 'post',
        ]
    );
}

echo Html::tag('h2', Html::encode($title) . Html::tag('small', join(' ', $buttons), ['class' => 'pull-right']));

if ($dataProvider->getCount() > 0) {

    echo GridView::widget([
        'id' => 'contactGrid',
        'dataProvider' => $dataProvider,
        'columns' => [
            'first_name',
            'last_name',
            [
                'label' => 'Phones',
                'value' => function ($model) {
                    return $model->getPhones()->count();
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]);

    echo Html::a(
        'Remove all data just for testing',
        ['contact/clear-table'],
        [
            'class' => 'btn btn-warning',
            'data-confirm' => Yii::t('yii', 'Are you sure?'),
            'data-method' => 'post',
            ]
    );
}
