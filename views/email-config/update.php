<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var bariew\noticeModule\models\EmailConfig $model
 */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
  'modelClass' => 'Email Config',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Email Configs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="email-config-update">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
