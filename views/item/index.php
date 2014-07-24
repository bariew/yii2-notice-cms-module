<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var bariew\noticeModule\models\ItemSearch $searchModel
 */

$this->title = Yii::t('app', 'Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notice-index">

    <h1><?php echo Html::encode($this->title) ?></h1>
    <p>
        <?php echo Html::a(Yii::t('app', 'Create {modelClass}', [
  'modelClass' => 'Item',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'created_at:datetime',
            'address',
            'owner_name',
            'owner_event',
            [
                'attribute' => 'status',
                'filter'     => Html::activeDropDownList($searchModel, 'status', $searchModel::statusList(), [
                    'prompt' => '',
                    'class' => 'form-control'
                ]),
                'value' => function ($data) { return $data::statusList()[$data->status];}
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
