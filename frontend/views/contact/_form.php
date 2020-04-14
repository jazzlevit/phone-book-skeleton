<?php

use frontend\models\Contact;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model Contact */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

    <?php

    $buttons[] = Html::a(Yii::t('app', 'Back'), ['/contact/index'], ['class' => 'btn btn-default']);
    $buttons[] = Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']);

    echo Html::tag('h2', Yii::t('app', $model->id ? 'Update contact' : 'Create new contact') . Html::tag('small', join(' ', $buttons), ['class' => 'pull-right']));

    ?>

    <hr>

    <div class="row">

        <div class="col-md-6">
            <h4 class="text-muted"><?php echo Yii::t('app', 'Contact:'); ?></h4>
            <?php echo $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>

        <?php if ($model->id) { ?>
            <div class="col-md-6">
                        <?php echo Html::tag('div', Yii::t('app', 'Loading...'), [
                                'id' => 'phoneListWrapper',
                                'ic-get-from' => Url::toRoute(['contact/phone-list', 'id' => $model->id]),
                                'ic-trigger-on' => 'load',
                                'ic-data-policy' => 'strict',
                                'ic-deps' => 'ignore',
                            ]);
                        ?>

            </div>
        <?php } ?>

    </div>

<?php ActiveForm::end();