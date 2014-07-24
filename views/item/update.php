<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var bariew\noticeModule\models\Item $model
 */

$this->title = Yii::t('app', 'Update {modelClass}: ' . $model->id, [
  'modelClass' => 'Item',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="notice-update">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
