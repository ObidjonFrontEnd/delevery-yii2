<?php

use backend\models\Restaurant;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\RestaurantSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Restaurants');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'description:ntext',
//            'id',
//            'user_id',
//            'phone_number',
            'image',
//            'address_id',
            'rate',
            'status',
//            'created_at',
//            'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Restaurant $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
