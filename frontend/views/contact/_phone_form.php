<?php

/** @var \frontend\models\Contact $model */

use frontend\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();
?>
<h4 class="text-muted"><?php echo Yii::t('app', 'Edit Phone:'); ?></h4>
<?php echo $form->field($model, 'phone', ['inputOptions' => [
    'placeholder' => '+X (XXX) XXX-XX-XX', 'class' => 'form-control'
    ]]); ?>

<div class="text-right">
    <?php echo Html::button(Html::fa('times'), [
        'class' => 'btn btn-default btn-sm',
        'ic-target' =>'#phoneListWrapper',
        'ic-post-to' => Url::toRoute(['/contact/phone-list', 'id' => $model->contact_id]),
        'ic-data-policy' => 'strict',
        'ic-deps' => 'ignore',
    ]) ?>

    <?php echo Html::submitButton(Html::fa('check'), [
        'class' => 'btn btn-success btn-sm',
        'ic-target' =>'#phoneListWrapper',
        'ic-post-to' => $model->isNewRecord ? Url::toRoute(['/contact/add-phone', 'id' => $model->contact_id]) : Url::toRoute(['/contact/update-phone', 'id' => $model->id]),
        'ic-data-policy' => 'strict',
        'ic-deps' => 'ignore',
    ]) ?>
</div>


<?php ActiveForm::end();