<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\notice\models\Notice $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
  'modelClass' => 'Notice',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notice-create">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
