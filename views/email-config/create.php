<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\notice\models\EmailConfig $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
  'modelClass' => 'Email Config',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Email Configs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-config-create">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
