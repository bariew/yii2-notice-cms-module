<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var bariew\noticeModule\models\NoticeSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="notice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'address') ?>

    <?php echo $form->field($model, 'title') ?>

    <?php echo $form->field($model, 'content') ?>

    <?php echo $form->field($model, 'owner_name') ?>

    <?php // echo $form->field($model, 'owner_event') ?>

    <?php // echo $form->field($model, 'owner_id') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
