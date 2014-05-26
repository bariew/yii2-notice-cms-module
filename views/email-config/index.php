<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var bariew\noticeModule\models\EmailConfigSearch $searchModel
 */

$this->title = Yii::t('app', 'Email Configs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-config-index">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('app', 'Create {modelClass}', [
  'modelClass' => 'Email Config',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'subject',
            'content:ntext',
            'owner_name',
            // 'owner_event',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
