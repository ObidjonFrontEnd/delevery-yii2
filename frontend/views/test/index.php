<?php
/** @var object $provider */
echo \yii\grid\GridView::widget([
    'dataProvider' => $provider,
    'layout' => "{items}\n{pager}",
    'columns' => [

        [
            'label'=>'avatar',
            'format'=>'html',
            'value'=>function ($model) {
                return yii\helpers\Html::img( '@web/image/default.jpg' , [
                    'class'=>'rounded-full',
                    'style'=>'width:50px;height:50px;',
                ]);
            }
        ],
        'description',
        'weight',
        'calories',
        'preparation_time',
        'ingredients',
        ['class' => \yii\grid\CheckboxColumn::className()],

    ]

]);


