<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var bariew\noticeModule\models\Notice $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="notice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'status')->textInput() ?>

    <?php echo $form->field($model, 'type')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
