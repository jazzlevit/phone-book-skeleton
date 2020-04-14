<?php

/** @var \frontend\models\Contact $model */

use frontend\helpers\Html;
use yii\helpers\Url;

?>
<div class="box">
    <div class="box-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="text-muted">
                    <?php echo Yii::t('app', 'Phones: ({count})', ['count' => $model->getPhones()->count()]); ?>
                </h4>
            </div>
            <div class="col-md-6 text-right">
                <?php
                echo Html::a(Yii::t('app', 'Add new phone'), '#', [
                    'class' => 'btn btn-warning btn-sm',
                    'ic-target' =>'#phoneListWrapper',
                    'ic-get-from' => Url::toRoute(['/contact/add-phone', 'id' => $model->id]),
                    'ic-data-policy' => 'strict',
                    'ic-deps' => 'ignore',
                ]);
                ?>
            </div>
        </div>
    </div>
    <div class="box-body">

        <label class="control-label text-muted">
            <?php echo Yii::t('app', 'Max 20 phone numbers'); ?>
        </label>

        <ul class="list-group">
            <?php foreach ($model->phones as $phone) { ?>
                <li class="list-group-item">
                    <div class="pull-right">
                        <?php echo Html::a(Html::fa('pencil'), '#', [
                            'class' => 'pointer text-success',
                            'ic-target' =>'#phoneListWrapper',
                            'ic-get-from' => Url::toRoute(['/contact/update-phone', 'id' => $phone->id]),
                            'ic-data-policy' => 'strict',
                            'ic-deps' => 'ignore',
                        ]); ?>
                        <?php echo Html::a(Html::fa('times'), '#', [
                            'class' => 'pointer text-danger',
                            'ic-target' =>'#phoneListWrapper',
                            'ic-post-to' => Url::toRoute(['/contact/delete-phone', 'id' => $phone->id]),
                            'ic-data-policy' => 'strict',
                            'ic-deps' => 'ignore',
                            'ic-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        ]); ?>
                    </div>
                    <?php echo Html::fa('phone'); ?>
                    <?php echo $phone->phone; ?>
                </li>
            <?php } ?>
        </ul>

    </div>
</div>
