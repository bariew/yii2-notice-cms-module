<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;
/**
 * @var yii\web\View $this
 * @var bariew\noticeModule\models\EmailConfig $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="email-config-form">

    <?php $form = ActiveForm::begin(); ?>
    
        <?php echo $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

        <?php echo $form->field($model, 'subject')->textInput(['maxlength' => 255]) ?>

       <!-- <?php $form->field($model, 'content')->textarea(['rows' => 6]) ?>-->
        <div class="form-group required">
            <?php echo yii\imperavi\Widget::widget([
                'model' => $model,
                'attribute' => 'content',
                'options' => [],
            ]);?>
            <?php if ($model->hasErrors('content')): ?>
            <div class="has-error">
                <?php echo Html::error($model, 'content', $form->field($model, 'content')->errorOptions); ;?>
            </div>
            <?php endif; ?>
        </div>

        <label>Email variables</label>
        <?php echo DetailView::widget([
            'model'         => false,
            'attributes'     => $model->variables(),
        ]);?>

        <?= $form->field($model, 'owner_name')->widget(Select2::classname(), [
            'data' => $model::classList(),
            'options' => ['class' => 'form-control']
        ]);?>
        <?= $form->field($model, 'owner_event')->widget(DepDrop::classname(), [
                'data'=> $model->eventList(),
                'options' => [ 'class' => 'form-control'],
                'type' => DepDrop::TYPE_DEFAULT,
                'pluginOptions'=>[
                    'depends' => ['emailconfig-owner_name'],
                    'url' => Url::toRoute(['events']),
                    'loadingText' => '',
                    'initialize' => true
                ]
            ]);
        ?>

        <div class="form-group">
            <?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
